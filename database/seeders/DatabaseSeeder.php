<?php

namespace Database\Seeders;

use App\EventStatus;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\RegistrationStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin EventSphere',
            'email' => 'admin@eventsphere.test',
            'phone' => '081200000001',
        ]);

        $organizer = User::factory()->organizer()->create([
            'name' => 'Rani Puspita',
            'email' => 'organizer@eventsphere.test',
            'phone' => '081200000002',
            'organization_name' => 'Nusantara Creative',
            'bio' => 'Penyelenggara konferensi teknologi dan festival kreatif sejak 2018.',
        ]);

        $participant = User::factory()->participant()->create([
            'name' => 'Budi Santoso',
            'email' => 'participant@eventsphere.test',
            'phone' => '081200000003',
            'bio' => 'Pecinta event teknologi, musik, dan pengembangan diri.',
        ]);

        $otherOrganizers = User::factory()->count(3)->organizer()->create();

        $participants = User::factory()->count(24)->participant()->create();
        $participants->push($participant);

        $categories = collect([
            ['name' => 'Teknologi', 'description' => 'Konferensi, workshop, dan meetup seputar dunia teknologi.', 'color' => '#4f46e5'],
            ['name' => 'Bisnis', 'description' => 'Seminar dan pelatihan seputar kewirausahaan dan manajemen.', 'color' => '#0ea5e9'],
            ['name' => 'Musik', 'description' => 'Konser, festival, dan pertunjukan musik dari berbagai genre.', 'color' => '#db2777'],
            ['name' => 'Seni & Budaya', 'description' => 'Pameran seni, teater, dan pertunjukan budaya.', 'color' => '#f59e0b'],
            ['name' => 'Olahraga', 'description' => 'Kompetisi, turnamen, dan kegiatan olahraga komunitas.', 'color' => '#10b981'],
            ['name' => 'Pendidikan', 'description' => 'Pelatihan, bootcamp, dan kelas pengembangan keterampilan.', 'color' => '#8b5cf6'],
            ['name' => 'Kesehatan', 'description' => 'Seminar kesehatan, kebugaran, dan gaya hidup sehat.', 'color' => '#14b8a6'],
            ['name' => 'Komunitas', 'description' => 'Acara gathering dan kolaborasi antar komunitas.', 'color' => '#ef4444'],
        ])->mapWithKeys(fn (array $category, int $index) => [
            $category['name'] => Category::create([
                ...$category,
                'slug' => Str::slug($category['name']),
            ]),
        ]);

        $events = [
            [
                'title' => 'Indonesia Developer Summit 2026',
                'category' => 'Teknologi',
                'organizer' => $organizer,
                'description' => "Indonesia Developer Summit adalah konferensi tahunan terbesar untuk para pengembang perangkat lunak di Indonesia.\n\nTahun ini kami menghadirkan lebih dari 30 pembicara dari perusahaan teknologi terkemuka, dengan topik mulai dari arsitektur sistem terdistribusi, keamanan aplikasi, hingga pemanfaatan AI generatif dalam alur kerja pengembangan.\n\nAgenda mencakup sesi keynote, workshop paralel, dan sesi networking yang dirancang untuk memperluas wawasan sekaligus jejaring profesional Anda.",
                'venue' => 'Jakarta Convention Center',
                'city' => 'Jakarta',
                'address' => 'Jl. Gatot Subroto, Senayan, Jakarta Pusat',
                'days' => 18,
                'hour' => 9,
                'duration' => 8,
                'capacity' => 500,
                'price' => 250000,
                'featured' => true,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Festival Musik Nusantara 2026',
                'category' => 'Musik',
                'organizer' => $otherOrganizers[0],
                'description' => "Nikmati dua hari penuh musik dari musisi terbaik Indonesia di Festival Musik Nusantara.\n\nDengan panggung utama berkapasitas besar, area kuliner nusantara, dan zona komunitas, festival ini menjadi perayaan budaya musik yang sayang untuk dilewatkan.\n\nBawa teman-teman Anda dan rasakan pengalaman konser yang tak terlupakan di bawah langit terbuka.",
                'venue' => 'Lapangan Gasibu',
                'city' => 'Bandung',
                'address' => 'Jl. Diponegoro, Citarum, Bandung',
                'days' => 32,
                'hour' => 15,
                'duration' => 7,
                'capacity' => 1000,
                'price' => 150000,
                'featured' => true,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Workshop UI/UX untuk Pemula',
                'category' => 'Teknologi',
                'organizer' => $organizer,
                'description' => "Belajar dasar-dasar desain antarmuka dan pengalaman pengguna dalam workshop intensif satu hari.\n\nPeserta akan mempraktikkan riset pengguna sederhana, membuat wireframe, hingga menyusun prototipe interaktif menggunakan tools populer.\n\nWorkshop ini cocok untuk pemula yang ingin memulai karier di bidang product design.",
                'venue' => 'Gedung Creative Hub',
                'city' => 'Yogyakarta',
                'address' => 'Jl. Suryodiningratan No. 12, Yogyakarta',
                'days' => 10,
                'hour' => 10,
                'duration' => 5,
                'capacity' => 60,
                'price' => 75000,
                'featured' => false,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Seminar Kewirausahaan Digital',
                'category' => 'Bisnis',
                'organizer' => $otherOrganizers[1],
                'description' => "Pelajari strategi membangun bisnis digital yang berkelanjutan dari para praktisi dan founder startup.\n\nMateri mencakup validasi ide, model bisnis, pemasaran digital, hingga pengelolaan keuangan untuk usaha rintisan.\n\nSesi tanya jawab dan konsultasi singkat tersedia bagi peserta yang membawa ide bisnis.",
                'venue' => 'Hotel Santika Premier',
                'city' => 'Surabaya',
                'address' => 'Jl. Basuki Rahmat No. 67, Surabaya',
                'days' => 25,
                'hour' => 13,
                'duration' => 4,
                'capacity' => 150,
                'price' => 50000,
                'featured' => false,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Pameran Seni Rupa Kontemporer',
                'category' => 'Seni & Budaya',
                'organizer' => $otherOrganizers[2],
                'description' => "Pameran seni rupa kontemporer yang menampilkan karya dari 25 seniman muda Indonesia.\n\nMengangkat tema \"Ruang dan Ingatan\", pameran ini mengeksplorasi hubungan antara tempat, memori, dan identitas melalui media lukis, instalasi, dan seni digital.\n\nPameran terbuka untuk umum dan cocok dinikmati bersama keluarga.",
                'venue' => 'Museum Seni Modern',
                'city' => 'Jakarta',
                'address' => 'Jl. Medan Merdeka Barat No. 8, Jakarta Pusat',
                'days' => 14,
                'hour' => 10,
                'duration' => 9,
                'capacity' => 300,
                'price' => 0,
                'featured' => true,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Turnamen Futsal Antar Komunitas',
                'category' => 'Olahraga',
                'organizer' => $otherOrganizers[0],
                'description' => "Ajang silaturahmi antar komunitas melalui turnamen futsal yang kompetitif dan menyenangkan.\n\nSetiap tim terdiri dari 7 pemain (5 inti dan 2 cadangan). Pendaftaran dibuka untuk 16 tim pertama.\n\nTersedia hadiah menarik, jersey eksklusif, dan area penonton yang nyaman.",
                'venue' => 'GOR C-Tra Arena',
                'city' => 'Bandung',
                'address' => 'Jl. Ahmad Yani No. 221, Bandung',
                'days' => 21,
                'hour' => 8,
                'duration' => 6,
                'capacity' => 112,
                'price' => 100000,
                'featured' => false,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Bootcamp Data Analytics Batch 12',
                'category' => 'Pendidikan',
                'organizer' => $organizer,
                'description' => "Program bootcamp intensif selama satu hari untuk menguasai dasar analisis data menggunakan Python dan SQL.\n\nPeserta akan belajar membersihkan data, membuat visualisasi, dan menyusun laporan analitik yang mudah dipahami pemangku kepentingan.\n\nKuota terbatas agar setiap peserta mendapat pendampingan maksimal.",
                'venue' => 'Gedung Digital Talent Center',
                'city' => 'Jakarta',
                'address' => 'Jl. Raya Pasar Minggu No. 19, Jakarta Selatan',
                'days' => 7,
                'hour' => 9,
                'duration' => 8,
                'capacity' => 40,
                'price' => 300000,
                'featured' => false,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Seminar Gaya Hidup Sehat 2026',
                'category' => 'Kesehatan',
                'organizer' => $otherOrganizers[1],
                'description' => "Kembalikan energi dan tingkatkan kualitas hidup dengan memahami pola makan, olahraga, serta manajemen stres yang tepat.\n\nNarasumber terdiri dari dokter umum, ahli gizi, dan pelatih kebugaran bersertifikat.\n\nTermasuk sesi pemeriksaan kesehatan ringan gratis untuk peserta.",
                'venue' => 'Balai Kartini',
                'city' => 'Jakarta',
                'address' => 'Jl. Gatot Subroto Kav. 37, Jakarta Selatan',
                'days' => 40,
                'hour' => 8,
                'duration' => 4,
                'capacity' => 250,
                'price' => 25000,
                'featured' => false,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Komunitas Frontend Meetup #24',
                'category' => 'Komunitas',
                'organizer' => $otherOrganizers[2],
                'description' => "Meetup bulanan komunitas frontend developer: berbagi pengalaman, tips, dan praktik terbaik seputar pengembangan antarmuka web.\n\nTema bulan ini adalah \"Performance Budgeting untuk Aplikasi Modern\" dengan demo langsung optimasi Core Web Vitals.\n\nGratis dan terbuka untuk semua tingkat pengalaman.",
                'venue' => 'Coworking Space Kemang',
                'city' => 'Jakarta',
                'address' => 'Jl. Kemang Raya No. 45, Jakarta Selatan',
                'days' => 5,
                'hour' => 19,
                'duration' => 3,
                'capacity' => 80,
                'price' => 0,
                'featured' => false,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Konser Akustik Senja',
                'category' => 'Musik',
                'organizer' => $otherOrganizers[0],
                'description' => "Nikmati petikan gitar dan harmoni vokal dalam konser akustik intim bertema senja.\n\nMenampilkan penyanyi-penyanyi lokal pilihan dengan aransemen akustik yang hangat, konser ini dirancang untuk menjadi ruang istirahat dari hiruk pikuk kota.\n\nKapasitas terbatas demi kenyamanan penonton.",
                'venue' => 'Amphitheater Taman Budaya',
                'city' => 'Yogyakarta',
                'address' => 'Jl. Sriwedari No. 1, Yogyakarta',
                'days' => 27,
                'hour' => 16,
                'duration' => 3,
                'capacity' => 120,
                'price' => 90000,
                'featured' => false,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Hackathon Solusi Kota Cerdas',
                'category' => 'Teknologi',
                'organizer' => $organizer,
                'description' => "Hackathon 24 jam untuk menciptakan solusi digital bagi permasalahan perkotaan: transportasi, sampah, dan layanan publik.\n\nTim terdiri dari 3–5 orang dengan latar belakang beragam. Tim terbaik akan mendapatkan pendanaan awal dan pendampingan inkubasi.\n\nPeserta wajib membawa laptop dan semangat kolaborasi.",
                'venue' => 'ICE BSD Hall 5',
                'city' => 'Tangerang',
                'address' => 'Jl. BSD Grand Boulevard, Tangerang',
                'days' => 45,
                'hour' => 8,
                'duration' => 24,
                'capacity' => 200,
                'price' => 0,
                'featured' => true,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Pelatihan Public Speaking Profesional',
                'category' => 'Pendidikan',
                'organizer' => $otherOrganizers[1],
                'description' => "Tingkatkan kepercayaan diri dan kemampuan berbicara di depan publik melalui latihan praktis.\n\nMateri mencakup teknik pernapasan, struktur presentasi, bahasa tubuh, serta cara menangani pertanyaan sulit dari audiens.\n\nSetiap peserta akan melakukan simulasi presentasi dan menerima umpan balik langsung.",
                'venue' => 'Hotel Grand Mercure',
                'city' => 'Medan',
                'address' => 'Jl. Sutomo No. 1, Medan',
                'days' => 12,
                'hour' => 9,
                'duration' => 6,
                'capacity' => 50,
                'price' => 125000,
                'featured' => false,
                'status' => EventStatus::Published,
            ],
            [
                'title' => 'Gathering Relawan Sosial 2026',
                'category' => 'Komunitas',
                'organizer' => $otherOrganizers[2],
                'description' => "Pertemuan tahunan para relawan dan pegiat sosial untuk berbagi cerita, merayakan capaian, dan merancang kolaborasi berikutnya.\n\nAcara diisi dengan sesi refleksi, lokakarya perencanaan program, serta malam apresiasi relawan.\n\nTerbuka bagi siapa pun yang tertarik berkontribusi pada kegiatan sosial.",
                'venue' => 'Gedung Yayasan Cahaya',
                'city' => 'Semarang',
                'address' => 'Jl. Pandanaran No. 88, Semarang',
                'days' => 55,
                'hour' => 10,
                'duration' => 5,
                'capacity' => 100,
                'price' => 0,
                'featured' => false,
                'status' => EventStatus::Draft,
            ],
            [
                'title' => 'Tech Career Fair 2025',
                'category' => 'Bisnis',
                'organizer' => $organizer,
                'description' => "Bursa kerja dan pameran karier di bidang teknologi yang mempertemukan talenta dengan perusahaan terkemuka.\n\nAcara telah sukses diselenggarakan dengan lebih dari 1.200 pengunjung dan 40 perusahaan peserta.\n\nTerima kasih kepada seluruh peserta dan mitra yang telah mendukung.",
                'venue' => 'Balai Sidang Jakarta',
                'city' => 'Jakarta',
                'address' => 'Jl. Gatot Subroto, Jakarta Pusat',
                'days' => -45,
                'hour' => 9,
                'duration' => 8,
                'capacity' => 800,
                'price' => 0,
                'featured' => false,
                'status' => EventStatus::Completed,
            ],
            [
                'title' => 'Lokakarya Fotografi Jalanan',
                'category' => 'Seni & Budaya',
                'organizer' => $otherOrganizers[0],
                'description' => "Belajar menangkap momen dan cerita melalui fotografi jalanan bersama fotografer profesional.\n\nSesi teori akan membahas komposisi, cahaya, dan etika memotret di ruang publik, dilanjutkan praktik langsung di area kota tua.\n\nPeserta cukup membawa kamera atau ponsel dengan kamera yang baik.",
                'venue' => 'Kota Tua Creative Space',
                'city' => 'Jakarta',
                'address' => 'Jl. Kali Besar Barat No. 5, Jakarta Barat',
                'days' => -15,
                'hour' => 7,
                'duration' => 5,
                'capacity' => 35,
                'price' => 50000,
                'featured' => false,
                'status' => EventStatus::Completed,
            ],
        ];

        $createdEvents = collect($events)->mapWithKeys(function (array $data) use ($categories): array {
            $startsAt = now()->startOfDay()->addDays($data['days'])->setTime($data['hour'], 0);

            $event = Event::factory()->create([
                'organizer_id' => $data['organizer']->id,
                'category_id' => $categories[$data['category']]->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']).'-'.Str::lower(Str::random(4)),
                'description' => $data['description'],
                'venue' => $data['venue'],
                'city' => $data['city'],
                'address' => $data['address'],
                'starts_at' => $startsAt,
                'ends_at' => $startsAt->copy()->addHours($data['duration']),
                'capacity' => $data['capacity'],
                'price' => $data['price'],
                'poster_path' => 'https://picsum.photos/seed/'.$data['category'].'-'.$data['days'].'/1200/800',
                'status' => $data['status'],
                'featured' => $data['featured'],
            ]);

            return [$data['title'] => $event];
        });

        $activeEvents = $createdEvents->filter(
            fn (Event $event) => in_array($event->status, [EventStatus::Published, EventStatus::Completed], true),
        );

        foreach ($activeEvents as $event) {
            $attendees = $participants->shuffle()->take(random_int(4, 16));

            foreach ($attendees as $attendee) {
                $isPast = $event->status === EventStatus::Completed;
                $status = match (true) {
                    $isPast && fake()->boolean(80) => RegistrationStatus::Attended,
                    $isPast => RegistrationStatus::Cancelled,
                    fake()->boolean(15) => RegistrationStatus::Pending,
                    fake()->boolean(10) => RegistrationStatus::Cancelled,
                    default => RegistrationStatus::Confirmed,
                };

                Registration::create([
                    'event_id' => $event->id,
                    'user_id' => $attendee->id,
                    'status' => $status,
                    'checked_in_at' => $status === RegistrationStatus::Attended ? $event->starts_at->copy()->addMinutes(15) : null,
                ]);
            }
        }

        $demoRegistrations = $createdEvents->only([
            'Indonesia Developer Summit 2026',
            'Festival Musik Nusantara 2026',
            'Workshop UI/UX untuk Pemula',
            'Tech Career Fair 2025',
        ]);

        foreach ($demoRegistrations as $event) {
            Registration::updateOrCreate(
                ['event_id' => $event->id, 'user_id' => $participant->id],
                [
                    'status' => $event->status === EventStatus::Completed
                        ? RegistrationStatus::Attended
                        : RegistrationStatus::Confirmed,
                    'checked_in_at' => $event->status === EventStatus::Completed ? $event->starts_at : null,
                ],
            );
        }

        $this->command->info('EventSphere seeded: '.User::count().' pengguna, '.Event::count().' event, '.Registration::count().' pendaftaran.');
        $this->command->info('Login demo: admin@eventsphere.test / organizer@eventsphere.test / participant@eventsphere.test — password: password');
    }
}
