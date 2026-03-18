@php
use Carbon\Carbon;
$current = isset($currentMonth) ? $currentMonth->copy() : Carbon::now()->startOfMonth();
$startOfMonth = $current->copy()->startOfMonth();
$endOfMonth = $current->copy()->endOfMonth();
$startDow = $startOfMonth->dayOfWeek; // 0=Sun ... 6=Sat
$days = [];
for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
$days[] = $date->copy();
}
$monthTitle = $current->isoFormat('MMMM Y');
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="relative h-80 sm:h-96 lg:h-[32rem] w-full overflow-hidden rounded-2xl shadow-2xl">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ asset('storage/img/background.png') }}')"></div>
            <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center px-4">
                <p class="text-white text-sm md:text-base uppercase tracking-[0.3em] mb-4 font-light">Selamat Datang di Website Pemesanan</p>
                <h1 class="text-3xl md:text-6xl font-bold text-white tracking-tight leading-none uppercase">
                    GEDUNG SERBA GUNA AULIA
                </h1>
                <p class="text-white text-sm md:text-lg italic font-light max-w-2xl">Jl. Sempurna, Sambirejo Timur, Kec. Percut Sei Tuan,
                    Kabupaten Deli Serdang, Sumatera Utara</p>

                <div class="mt-16 flex flex-row gap-5">
                    <a href="#kalender" class="inline-flex items-center justify-center px-9 py-3 rounded-md border border-[#15803D] bg-[#ffffff] text-green font-bold text-sm hover:bg-[#166534] transition">
                        Pesan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </a>
                    <a href="#kontak" class="inline-flex items-center justify-center px-9 py-3 rounded-md border border-[#ffffff] bg-[#15803D] text-white font-bold text-sm hover:bg-[#166534] transition">
                        Lihat Alamat
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <section class="py-10 bg-[#0B5E2E] text-white rounded-2xl shadow-xl overflow-hidden">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold uppercase tracking-widest">Kenapa Memilih Kami?</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div class="space-y-3">
                        <div class="bg-white/10 rounded-full w-14 h-14 flex items-center justify-center mx-auto border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold">Gedung Luas</h3>
                        <p class="text-white/70 text-xs leading-relaxed">Kapasitas ribuan tamu untuk acara Anda.</p>
                    </div>

                    <div class="space-y-3">
                        <div class="bg-white/10 rounded-full w-14 h-14 flex items-center justify-center mx-auto border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold">Fasilitas Lengkap</h3>
                        <p class="text-white/70 text-xs leading-relaxed">AC, Sound System, dan Ruang Ganti.</p>
                    </div>

                    <div class="space-y-3">
                        <div class="bg-white/10 rounded-full w-14 h-14 flex items-center justify-center mx-auto border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold">Lokasi Strategis</h3>
                        <p class="text-white/70 text-xs leading-relaxed">Mudah diakses dengan parkir luas.</p>
                    </div>

                    <div class="space-y-3">
                        <div class="bg-white/10 rounded-full w-14 h-14 flex items-center justify-center mx-auto border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold">Harga Bersahabat</h3>
                        <p class="text-white/70 text-xs leading-relaxed">Penawaran terbaik untuk kualitas tinggi.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="py-8" id="kalender">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-lg text-gray-800">Kalender Ketersediaan ({{ $monthTitle }})</h2>
                        <div class="flex items-center gap-2">
                            <a class="px-3 py-1 border rounded {{ ($allowPrev ?? false) ? 'hover:bg-gray-50' : 'opacity-40 cursor-not-allowed' }}"
                                href="{{ ($allowPrev ?? false) ? route('home', ['month' => $prevMonth->format('Y-m')]) : '#' }}">← Sebelumnya</a>
                            <a class="px-3 py-1 border rounded {{ ($allowNext ?? false) ? 'hover:bg-gray-50' : 'opacity-40 cursor-not-allowed' }}"
                                href="{{ ($allowNext ?? false) ? route('home', ['month' => $nextMonth->format('Y-m')]) : '#' }}">Berikutnya →</a>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-2 text-xs">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span> Tersedia
                        </span>
                        <span class="inline-flex items-center gap-2 text-xs">
                            <span class="w-3 h-3 rounded-full bg-yellow-500"></span> Ada pengajuan (pending)
                        </span>
                        <span class="inline-flex items-center gap-2 text-xs">
                            <span class="w-3 h-3 rounded-full bg-red-600"></span> Gedung sudah dipesan (approved)
                        </span>
                    </div>
                    <div class="hidden lg:block">
                        <div class="grid grid-cols-7 gap-4">
                            <div class="text-xs text-gray-500">Minggu</div>
                            <div class="text-xs text-gray-500">Senin</div>
                            <div class="text-xs text-gray-500">Selasa</div>
                            <div class="text-xs text-gray-500">Rabu</div>
                            <div class="text-xs text-gray-500">Kamis</div>
                            <div class="text-xs text-gray-500">Jumat</div>
                            <div class="text-xs text-gray-500">Sabtu</div>
                        </div>
                        <div class="grid grid-cols-7 gap-4 mt-2 auto-rows-[1fr]">
                            @for ($i = 0; $i < $startDow; $i++)
                                <div class="border rounded p-3 bg-gray-50 h-full">
                        </div>
                        @endfor
                        @foreach($days as $day)
                        @php
                        $dateKey = $day->toDateString();
                        $all = ($rows ?? collect())->filter(function($b) use ($dateKey) {
                        $s = ($b->tanggal instanceof \Carbon\Carbon) ? $b->tanggal->toDateString() : \Carbon\Carbon::parse($b->tanggal)->toDateString();
                        $e = ($b->tanggal_selesai instanceof \Carbon\Carbon) ? $b->tanggal_selesai->toDateString() : \Carbon\Carbon::parse($b->tanggal_selesai)->toDateString();
                        return $s <= $dateKey && $e>= $dateKey;
                            })->sortBy('waktu_mulai');
                            $approved = $all->filter(fn($b) => $b->status === 'approved');
                            $pending = $all->filter(fn($b) => $b->status === 'pending');
                            $bg = 'bg-green-50';
                            if ($approved->count()) { $bg = 'bg-red-50'; }
                            elseif ($pending->count()) { $bg = 'bg-yellow-50'; }
                            @endphp
                            <div class="border rounded p-3 h-full min-h-[170px] flex flex-col {{ $day->isToday() ? 'border-primary' : 'border-gray-200' }} {{ $bg }}">
                                <div class="flex justify-between items-start">
                                    <span class="font-semibold text-base">{{ $day->isoFormat('D') }}</span>
                                    @if(!$approved->count())
                                    <span class="text-xs px-2 py-0.5 rounded shrink-0
                                                {{ $pending->count() ? 'bg-yellow-500 text-white' : 'bg-green-100 text-primary' }}">
                                        {{ $pending->count() ? 'Ada pengajuan' : 'Tersedia' }}
                                    </span>
                                    @endif
                                </div>
                                <div class="mt-2 space-y-2 flex-1">
                                    @if($approved->count() > 0)
                                    <div class="text-xs text-gray-600">Jam terisi (disetujui):</div>
                                    <ul class="space-y-1">
                                        @foreach($approved as $b)
                                        <li class="text-sm text-gray-700 break-words">
                                            {{ $b->nama_acara }}
                                            ({{ \Carbon\Carbon::parse($b->waktu_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($b->waktu_selesai)->format('H:i') }})
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-xs text-red-600 font-semibold">Gedung sudah dipesan</div>
                                    @else
                                    <div class="text-sm text-gray-700">Belum ada pemesanan disetujui.</div>
                                    @endif
                                    @if($pending->count() > 0)
                                    <div class="text-xs text-yellow-700">Menunggu persetujuan:</div>
                                    <ul class="space-y-1">
                                        @foreach($pending as $b)
                                        <li class="text-sm text-yellow-700 break-words">
                                            {{ $b->nama_acara }}
                                            ({{ \Carbon\Carbon::parse($b->waktu_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($b->waktu_selesai)->format('H:i') }})
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    @if(!$approved->count())
                                    <a href="{{ Auth::check() ? route('bookings.create', ['tanggal' => $dateKey]) : route('login') }}"
                                        class="mt-2 inline-flex items-center justify-center px-3 py-1 text-xs bg-primary text-white rounded hover:bg-green-700 w-full">
                                        Buat Pemesanan di tanggal ini
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
                <div class="block lg:hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($days as $day)
                        @php
                        $dateKey = $day->toDateString();
                        $all = ($rows ?? collect())->filter(function($b) use ($dateKey) {
                        $s = ($b->tanggal instanceof \Carbon\Carbon) ? $b->tanggal->toDateString() : \Carbon\Carbon::parse($b->tanggal)->toDateString();
                        $e = ($b->tanggal_selesai instanceof \Carbon\Carbon) ? $b->tanggal_selesai->toDateString() : \Carbon\Carbon::parse($b->tanggal_selesai)->toDateString();
                        return $s <= $dateKey && $e>= $dateKey;
                            })->sortBy('waktu_mulai');
                            $approved = $all->filter(fn($b) => $b->status === 'approved');
                            $pending = $all->filter(fn($b) => $b->status === 'pending');
                            $bg = 'bg-green-50';
                            if ($approved->count()) { $bg = 'bg-red-50'; }
                            elseif ($pending->count()) { $bg = 'bg-yellow-50'; }
                            @endphp
                            <div class="border rounded p-3 {{ $day->isToday() ? 'border-primary' : 'border-gray-200' }} {{ $bg }}">
                                <div class="flex justify-between items-start">
                                    <span class="font-medium">{{ $day->isoFormat('D MMM') }}</span>
                                    @if(!$approved->count())
                                    <span class="text-xs px-2 py-0.5 rounded shrink-0
                                                {{ $pending->count() ? 'bg-yellow-500 text-white' : 'bg-green-100 text-primary' }}">
                                        {{ $pending->count() ? 'Menunggu' : 'Tersedia' }}
                                    </span>
                                    @endif
                                </div>
                                <div class="mt-2 space-y-1">
                                    @if($approved->count() > 0)
                                    <ul class="space-y-1">
                                        @foreach($approved as $b)
                                        <li class="text-sm text-gray-700 break-words">
                                            {{ $b->nama_acara }}
                                            ({{ \Carbon\Carbon::parse($b->waktu_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($b->waktu_selesai)->format('H:i') }})
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="text-xs text-red-600 font-semibold">Gedung sudah dipesan</div>
                                    @else
                                    <div class="text-sm text-gray-700">Belum ada pemesanan disetujui.</div>
                                    @endif
                                    @if($pending->count() > 0)
                                    <ul class="space-y-1">
                                        @foreach($pending as $b)
                                        <li class="text-sm text-yellow-700 break-words">
                                            {{ $b->nama_acara }}
                                            ({{ \Carbon\Carbon::parse($b->waktu_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($b->waktu_selesai)->format('H:i') }})
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    @if(!$approved->count())
                                    <a href="{{ Auth::check() ? route('bookings.create', ['tanggal' => $dateKey]) : route('login') }}"
                                        class="mt-2 inline-flex items-center px-3 py-1 text-xs bg-primary text-white rounded hover:bg-green-700 w-full">
                                        Buat Pemesanan
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ Auth::check() ? route('bookings.create') : route('login') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded hover:bg-green-700">
                        {{ Auth::check() ? 'Buat Pemesanan' : 'Login untuk memesan' }}
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow-sm rounded p-6">
                <h3 class="text-lg font-semibold mb-3">Syarat & Ketentuan</h3>
                <ul class="text-sm text-gray-700 list-disc ms-5 space-y-1">
                    <li>Reservasi minimal 1 hari dan maksimal 1 tahun ke depan.</li>
                    <li>Pembayaran melalui rekening resmi Gedung Aulia.</li>
                    <li>Pembatalan mengikuti kebijakan pengelola.</li>
                    <li>Tanggung jawab kebersihan dan keamanan acara.</li>
                </ul>
            </div>
            <div class="bg-white shadow-sm rounded p-6">
                <h3 class="text-lg font-semibold mb-3">Fasilitas</h3>
                <ul class="text-sm text-gray-700 list-disc ms-5 space-y-1">
                    <li>Ruang serbaguna kapasitas besar.</li>
                    <li>Tempat parkir luas.</li>
                    <li>Sound system standar.</li>
                    <li>Ruang ganti dan musholla.</li>
                </ul>
            </div>
        </div>

        <div id="kontak" class="mt-8 bg-white shadow-sm rounded p-6">
            <h3 class="text-lg font-semibold mb-3">Kontak & Alamat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-[#0B5E2E] text-white rounded p-6 text-lg font-medium leading-8">
                    📞 Telepon: 0812-1552-7993 <br>
                    ✉️ Email: info@gedungserbagunaaulia.com <br>
                    🌐 Website: www.gedungserbagunaaulia.com <br>
                    Alamat : <br>
                    Jl. Sempurna, Sambirejo Timur, Kec. Percut Sei Tuan, <br>
                    Kabupaten Deli Serdang, Sumatera Utara
                </div>
                <div>
                    <iframe
                        src="https://www.google.com/maps?q=Gedung+Serba+Guna+Aulia+Jl.+Sempurna+Sambirejo+Timur&output=embed"
                        class="w-full h-80 rounded border"
                        style="border:0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <a href="https://maps.app.goo.gl/jseHhianyKvANWgr7" target="_blank" class="mt-2 inline-flex items-center text-green-700 font-medium hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
