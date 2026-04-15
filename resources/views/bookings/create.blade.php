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
                        <div>
                            <x-input-label value="Kategori Acara" />
                            <select name="kategori_acara" id="kategori_acara" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Wisuda" data-harga="{{ $venue->harga_wisuda ?? 1500000 }}" {{ old('kategori_acara') == 'Wisuda' ? 'selected' : '' }}>Wisuda (Rp {{ number_format($venue->harga_wisuda ?? 1500000, 0, ',', '.') }}/hari)</option>
                                <option value="Nikah" data-harga="{{ $venue->harga_nikah ?? 6500000 }}" {{ old('kategori_acara') == 'Nikah' ? 'selected' : '' }}>Nikah (Rp {{ number_format($venue->harga_nikah ?? 6500000, 0, ',', '.') }}/hari)</option>
                                <option value="Seminar" data-harga="{{ $venue->harga_seminar ?? 2000000 }}" {{ old('kategori_acara') == 'Seminar' ? 'selected' : '' }}>Seminar (Rp {{ number_format($venue->harga_seminar ?? 2000000, 0, ',', '.') }}/hari)</option>
                            </select>
                            <x-input-error :messages="$errors->get('kategori_acara')" class="mt-2" />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                            <x-input-label value="Tanggal Mulai (maks 1 tahun ke depan)" />
                            @php
                                $min = \Carbon\Carbon::now()->toDateString();
                                $max = \Carbon\Carbon::now()->addYear()->toDateString();
                            @endphp
                            <x-text-input name="tanggal" type="date" class="mt-1 block w-full"
                                value="{{ old('tanggal', $prefillDate ?? '') }}"
                                min="{{ $min }}" max="{{ $max }}" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label value="Tanggal Selesai" />
                                <x-text-input name="tanggal_selesai" type="date" class="mt-1 block w-full"
                                    value="{{ old('tanggal_selesai', $prefillDate ?? '') }}"
                                    min="{{ $min }}" max="{{ $max }}" required />
                                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label value="Jumlah Tamu" />
                            <x-text-input name="jumlah_tamu" type="number" min="1" class="mt-1 block w-full" value="{{ old('jumlah_tamu') }}" required />
                            <x-input-error :messages="$errors->get('jumlah_tamu')" class="mt-2" />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <x-input-label value="Harga perhari (sesuai kategori)" />
                                <x-text-input id="total-harga-display" type="text" class="mt-1 block w-full bg-gray-100"
                                    value="0" disabled />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label value="Nomor Rekening" />
                                <x-text-input type="text" class="mt-1 block w-full bg-gray-100"
                                    value="{{ $venue->bank_rekening ?? '' }}" disabled />
                            </div>
                        </div>
                        <div class="w-full p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">Silahkan Transfer ke Nomor Rekening diatas dan upload bukti ss di Bukti Transfer
                        </div>
                        <div>
                            <x-input-label value="Nomor Admin" />
                            <x-text-input type="text" class="mt-1 block w-full bg-gray-100"
                                value="{{ $venue->admin_phone ?? '' }}" disabled />
                        </div>
                        <div class="rounded bg-green-50 text-green-800 text-sm p-3">
                            <span id="calc-info">Total akan dihitung berdasarkan jumlah hari.</span>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const start = document.querySelector('input[name="tanggal"]');
                                const end = document.querySelector('input[name="tanggal_selesai"]');
                                const kategori = document.getElementById('kategori_acara');
                                const info = document.getElementById('calc-info');
                                const totalDisplay = document.getElementById('total-harga-display');
                                
                                function update() {
                                    if (!start.value || !end.value || !kategori.value) return;
                                    
                                    const selectedOption = kategori.options[kategori.selectedIndex];
                                    const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                                    
                                    const s = new Date(start.value);
                                    const e = new Date(end.value);
                                    if (e < s) return;
                                    const days = Math.round((e - s) / 86400000) + 1;
                                    const total = days * harga;
                                    info.textContent = `Dipesan selama: ${days} hari • Per hari: Rp ${harga.toLocaleString('id-ID')} • Total: Rp ${total.toLocaleString('id-ID')}`;
                                    totalDisplay.value = total.toLocaleString('id-ID');
                                }
                                start.addEventListener('change', update);
                                end.addEventListener('change', update);
                                kategori.addEventListener('change', update);
                                update();
                            });
                        </script>
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
