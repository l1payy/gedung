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
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kalender Ketersediaan Gedung Aulia ({{ $monthTitle }})
            </h2>
            <div class="flex items-center gap-2">
                <a class="px-3 py-1 border rounded {{ ($allowPrev ?? false) ? 'hover:bg-gray-50' : 'opacity-40 cursor-not-allowed' }}"
                   href="{{ ($allowPrev ?? false) ? route('home', ['month' => $prevMonth->format('Y-m')]) : '#' }}">← Sebelumnya</a>
                <a class="px-3 py-1 border rounded {{ ($allowNext ?? false) ? 'hover:bg-gray-50' : 'opacity-40 cursor-not-allowed' }}"
                   href="{{ ($allowNext ?? false) ? route('home', ['month' => $nextMonth->format('Y-m')]) : '#' }}">Berikutnya →</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
                                <div class="border rounded p-3 bg-gray-50 h-full"></div>
                            @endfor
                            @foreach($days as $day)
                                @php
                                    $dateKey = $day->toDateString();
                                    $all = ($bookings[$dateKey] ?? collect())->sortBy('waktu_mulai');
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
                                        @auth
                                            @if(!$approved->count())
                                                <a href="{{ route('bookings.create') }}?tanggal={{ $dateKey }}"
                                                   class="mt-2 inline-flex items-center justify-center px-3 py-1 text-xs bg-primary text-white rounded hover:bg-green-700 w-full">
                                                    Buat Pemesanan di tanggal ini
                                                </a>
                                            @endif
                                        @endauth
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
                                    $all = ($bookings[$dateKey] ?? collect())->sortBy('waktu_mulai');
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
                                                {{ $pending->count() ? 'Pending' : 'Tersedia' }}
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
                                        @auth
                                            @if(!$approved->count())
                                                <a href="{{ route('bookings.create') }}?tanggal={{ $dateKey }}"
                                                   class="mt-2 inline-flex items-center px-3 py-1 text-xs bg-primary text-white rounded hover:bg-green-700 w-full">
                                                    Buat Pemesanan
                                                </a>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6">
                        @auth
                            <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded hover:bg-green-700">
                                Buat Pemesanan
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded hover:bg-green-700">
                                Login untuk memesan
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
