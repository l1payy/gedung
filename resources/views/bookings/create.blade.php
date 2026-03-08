<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Form Pemesanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
                            <ul class="list-disc ms-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label value="Nama Acara" />
                            <x-text-input name="nama_acara" type="text" class="mt-1 block w-full" value="{{ old('nama_acara') }}" required />
                            <x-input-error :messages="$errors->get('nama_acara')" class="mt-2" />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                            <x-input-label value="Tanggal" />
                            <x-text-input name="tanggal" type="date" class="mt-1 block w-full" value="{{ old('tanggal', $prefillDate ?? '') }}" required />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label value="Waktu Mulai" />
                                <x-text-input name="waktu_mulai" type="time" class="mt-1 block w-full" value="{{ old('waktu_mulai') }}" required />
                                <x-input-error :messages="$errors->get('waktu_mulai')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label value="Waktu Selesai" />
                                <x-text-input name="waktu_selesai" type="time" class="mt-1 block w-full" value="{{ old('waktu_selesai') }}" required />
                                <x-input-error :messages="$errors->get('waktu_selesai')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label value="Jumlah Tamu" />
                            <x-text-input name="jumlah_tamu" type="number" min="1" class="mt-1 block w-full" value="{{ old('jumlah_tamu') }}" required />
                            <x-input-error :messages="$errors->get('jumlah_tamu')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label value="Deskripsi" />
                            <textarea name="deskripsi" class="mt-1 block w-full rounded border-gray-300">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label value="Bukti Transfer (jpg/png/pdf, maks 5MB)" />
                            <input name="bukti_transfer" type="file" class="mt-1 block w-full" accept=".jpg,.jpeg,.png,.pdf" />
                            <x-input-error :messages="$errors->get('bukti_transfer')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button class="bg-primary hover:bg-green-700">
                                Simpan Pemesanan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
