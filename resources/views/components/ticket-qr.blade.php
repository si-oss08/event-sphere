@props(['code'])

@php
    $modules = 21;
    $hash = hash('sha256', $code);
    $cells = [];

    $isFinder = function (int $row, int $col) use ($modules): bool {
        $inTopLeft = $row < 7 && $col < 7;
        $inTopRight = $row < 7 && $col >= $modules - 7;
        $inBottomLeft = $row >= $modules - 7 && $col < 7;

        return $inTopLeft || $inTopRight || $inBottomLeft;
    };

    $isFinderBorder = function (int $row, int $col) use ($modules): bool {
        $patterns = [[0, 0], [0, $modules - 7], [$modules - 7, 0]];

        foreach ($patterns as [$startRow, $startCol]) {
            $localRow = $row - $startRow;
            $localCol = $col - $startCol;

            if ($localRow < 0 || $localRow > 6 || $localCol < 0 || $localCol > 6) {
                continue;
            }

            $onOuter = $localRow === 0 || $localRow === 6 || $localCol === 0 || $localCol === 6;
            $inCenter = $localRow >= 2 && $localRow <= 4 && $localCol >= 2 && $localCol <= 4;

            if ($onOuter || $inCenter) {
                return true;
            }
        }

        return false;
    };

    for ($row = 0; $row < $modules; $row++) {
        for ($col = 0; $col < $modules; $col++) {
            if ($isFinder($row, $col)) {
                if ($isFinderBorder($row, $col)) {
                    $cells[] = [$col, $row];
                }

                continue;
            }

            $index = ($row * $modules + $col) % 64;
            $bit = (hexdec($hash[$index]) >> ($index % 4)) & 1;

            if ($bit === 1) {
                $cells[] = [$col, $row];
            }
        }
    }
@endphp

<svg viewBox="0 0 {{ $modules }} {{ $modules }}" class="h-full w-full" role="img" aria-label="Kode tiket {{ $code }}" shape-rendering="crispEdges">
    <rect width="{{ $modules }}" height="{{ $modules }}" fill="#ffffff" />
    @foreach ($cells as [$x, $y])
        <rect x="{{ $x }}" y="{{ $y }}" width="1" height="1" fill="#0f172a" />
    @endforeach
</svg>
