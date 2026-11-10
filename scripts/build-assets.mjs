import { createHash } from 'node:crypto';
import { mkdir, readFile, readdir, rm, writeFile } from 'node:fs/promises';
import { watch } from 'node:fs';
import path from 'node:path';
import { transform } from 'lightningcss';
import { build as esbuild } from 'esbuild';

// The Tailwind engine ships a WASI fallback that works even when the native
// binding is unavailable (for example, blocked by Windows Application Control).
process.env.NAPI_RS_FORCE_WASI ??= 'true';

const { compile } = await import('@tailwindcss/node');

const root = process.cwd();
const buildDir = path.join(root, 'public', 'build');
const assetsDir = path.join(buildDir, 'assets');
const cssEntry = path.join(root, 'resources', 'css', 'app.css');
const jsEntry = path.join(root, 'resources', 'js', 'app.js');

const scanTargets = [
    { dir: path.join(root, 'resources', 'views'), extensions: ['.blade.php', '.php'] },
    { dir: path.join(root, 'resources', 'js'), extensions: ['.js'] },
    { dir: path.join(root, 'app'), extensions: ['.php'] },
    {
        dir: path.join(root, 'vendor', 'laravel', 'framework', 'src', 'Illuminate', 'Pagination', 'resources', 'views'),
        extensions: ['.blade.php', '.php'],
    },
];

const candidatePattern = /[^\s"'`<>=;{}()]+/g;

async function collectFiles(directory, extensions) {
    const files = [];

    let entries;

    try {
        entries = await readdir(directory, { withFileTypes: true });
    } catch {
        return files;
    }

    for (const entry of entries) {
        const entryPath = path.join(directory, entry.name);

        if (entry.isDirectory()) {
            files.push(...(await collectFiles(entryPath, extensions)));
        } else if (extensions.some((extension) => entry.name.endsWith(extension))) {
            files.push(entryPath);
        }
    }

    return files;
}

async function collectCandidates() {
    const candidates = new Set();

    for (const target of scanTargets) {
        for (const file of await collectFiles(target.dir, target.extensions)) {
            const contents = await readFile(file, 'utf8');

            for (const match of contents.matchAll(candidatePattern)) {
                const candidate = match[0];

                if (
                    candidate.length === 0 ||
                    candidate.length > 120 ||
                    candidate.includes('\\') ||
                    candidate.includes('$')
                ) {
                    continue;
                }

                candidates.add(candidate);
            }
        }
    }

    return [...candidates];
}

function hashedName(contents, extension) {
    return `app-${createHash('sha256').update(contents).digest('hex').slice(0, 8)}.${extension}`;
}

async function buildAssets() {
    const cssSource = await readFile(cssEntry, 'utf8');
    const compiler = await compile(cssSource, {
        base: path.dirname(cssEntry),
        onDependency: () => {},
    });
    const candidates = await collectCandidates();

    const rawCss = compiler.build(candidates);
    const { code: cssBuffer } = transform({
        filename: 'app.css',
        code: Buffer.from(rawCss),
        minify: true,
    });

    const jsResult = await esbuild({
        entryPoints: [jsEntry],
        bundle: true,
        minify: true,
        format: 'esm',
        target: 'es2020',
        write: false,
        logLevel: 'silent',
    });

    const jsCode = jsResult.outputFiles[0].text;
    const css = Buffer.from(cssBuffer);
    const cssName = hashedName(css, 'css');
    const jsName = hashedName(jsCode, 'js');

    await rm(buildDir, { recursive: true, force: true });
    await mkdir(assetsDir, { recursive: true });

    await writeFile(path.join(assetsDir, cssName), css);
    await writeFile(path.join(assetsDir, jsName), jsCode);

    const manifest = {
        'resources/css/app.css': {
            file: `assets/${cssName}`,
            src: 'resources/css/app.css',
            isEntry: true,
        },
        'resources/js/app.js': {
            file: `assets/${jsName}`,
            src: 'resources/js/app.js',
            isEntry: true,
        },
    };

    await writeFile(path.join(buildDir, 'manifest.json'), JSON.stringify(manifest, null, 2));

    const kilobytes = (bytes) => `${(bytes / 1024).toFixed(1)} kB`;
    console.log(`Built assets: ${cssName} (${kilobytes(css.length)}), ${jsName} (${kilobytes(Buffer.byteLength(jsCode))})`);
}

await buildAssets();

if (process.argv.includes('--watch')) {
    let timer;

    console.log('Watching resources and app for changes…');

    for (const target of [...scanTargets.map((target) => target.dir), path.dirname(cssEntry)]) {
        watch(target, { recursive: true }, () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                buildAssets().catch((error) => console.error('Build failed:', error.message));
            }, 200);
        });
    }
}
