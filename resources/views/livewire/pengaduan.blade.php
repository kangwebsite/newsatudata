<div>
    <div class="bg-white border-b border-gray-200 pt-6 pb-8 shrink-0 relative overflow-hidden">
        
        <div class="absolute right-0 top-0 w-1/2 h-full bg-linear-to-l from-red-50/50 to-transparent pointer-events-none"></div>
        
        <div class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <nav class="flex text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="index.html" class="hover:text-brand-700 transition flex items-center gap-1">
                            <i class="ph ph-house"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-slate-400 text-xs mx-1"></i>
                            <span class="text-slate-700 font-medium ml-1">Layanan Pengaduan</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 leading-tight mb-3">Layanan Pengaduan & Bantuan</h1>
                <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                    Kami berkomitmen menyediakan data yang akurat dan transparan. Jika Anda menemukan masalah pada data, aplikasi, atau ingin mengajukan permohonan dataset baru, silakan isi formulir di bawah ini.
                </p>
            </div>
        </div>
    </div>

    <main class="grow max-w-[100rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                    
                    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                        <i class="ph ph-note-pencil text-brand-600 text-2xl"></i> Formulir Pelaporan
                    </h2>

                    <form wire:submit="submit" class="space-y-6">
                        
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="nama" name="nama" wire:model="name" placeholder="Masukkan nama Anda" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                @error('name') 
                                    <span style="color: red;">{{ $message }}</span> 
                                @enderror
                            </div>
                            <div>
                                <label for="instansi" class="block text-sm font-semibold text-slate-700 mb-1.5">Instansi / Organisasi</label>
                                <input type="text" id="instansi" name="instansi" wire:model="organisation" placeholder="Masyarakat Umum / Nama Instansi" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                @error('organisation') 
                                    <span style="color: red;">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" wire:model="email" placeholder="email@contoh.com" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                @error('email') 
                                    <span style="color: red;">{{ $message }}</span> 
                                @enderror
                            </div>
                            <div>
                                <label for="telepon" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                                <input type="tel" id="telepon" name="telepon" wire:model="phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                @error('phone') 
                                    <span style="color: red;">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        
                        <div>
                            <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori Laporan <span class="text-red-500">*</span></label>
                            <select id="kategori" name="kategori" wire:model="category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition cursor-pointer text-slate-700">
                                <option hidden>Pilih kategori masalah...</option>
                                <option value="data_salah">Indikasi Kesalahan Data / Data Tidak Akurat</option>
                                <option value="data_kadaluarsa">Data Tidak Mutakhir (Outdated)</option>
                                <option value="permohonan_data">Permohonan Dataset Baru</option>
                                <option value="bug_sistem">Kendala Teknis / Bug Aplikasi</option>
                                <option value="lainnya">Lainnya / Saran & Masukan</option>
                            </select>
                            @error('category') 
                                <span style="color: red;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label for="tautan" class="block text-sm font-semibold text-slate-700 mb-1.5">Tautan (URL) Terkait <span class="text-slate-400 font-normal text-xs">(Opsional)</span></label>
                            <input type="url" id="tautan" name="tautan" wire:model="url" placeholder="Contoh: https://data.waykanankab.go.id/dataset/..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                            <p class="text-xs text-slate-500 mt-1.5">Sertakan tautan halaman dataset atau fitur yang menjadi kendala untuk memudahkan pengecekan.</p>
                            @error('url') 
                                <span style="color: red;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                            <textarea id="deskripsi" name="deskripsi" wire:model="description" rows="5" placeholder="Jelaskan secara detail masalah yang Anda temukan atau data yang Anda butuhkan..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition resize-none"></textarea>
                            @error('description') 
                                <span style="color: red;">{{ $message }}</span> 
                            @enderror
                        </div>


                        <div wire:ignore>
                            <div class="cf-turnstile" 
                                data-sitekey="{{ config('services.turnstile.site_key') }}" 
                                data-callback="turnstileCallback">
                            </div>
                        </div>
                        <script>
                            function turnstileCallback(token) {
                                @this.set('turnstileToken', token);
                            }
                        </script>
                        @error('turnstileToken') 
                            <span style="color: red;">{{ $message }}</span> 
                        @enderror
                        

                        <div class="pt-4 flex items-center justify-between border-t border-gray-100">
                            <p class="text-xs text-slate-500 max-w-sm">Dengan mengirimkan form ini, Anda menyetujui kebijakan privasi dan pemrosesan data oleh Pemkab Way Kanan.</p>
                            <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white px-8 py-3 rounded-lg font-semibold text-sm transition shadow-md flex items-center gap-2">
                                <i class="ph ph-paper-plane-right"></i> Kirim Laporan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            
            <aside class="lg:col-span-1 space-y-6">
                
                
                <div class="bg-brand-900 text-white rounded-xl shadow-sm p-6 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 text-white/10">
                        <i class="ph-fill ph-headset text-9xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-4 relative z-10 flex items-center gap-2">
                        <i class="ph ph-headset text-brand-300 text-xl"></i> Hubungi Langsung
                    </h3>
                    <ul class="space-y-4 relative z-10 text-sm">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded bg-brand-800 flex items-center justify-center flex-shrink-0 text-brand-300">
                                <i class="ph ph-envelope-simple"></i>
                            </div>
                            <div>
                                <span class="block text-brand-200 text-xs mb-0.5">Email Dukungan</span>
                                <a href="mailto:diskominfo@waykanankab.go.id" class="font-medium hover:text-brand-300 transition">diskominfo@waykanankab.go.id</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded bg-brand-800 flex items-center justify-center flex-shrink-0 text-brand-300">
                                <i class="ph ph-phone"></i>
                            </div>
                            <div>
                                <span class="block text-brand-200 text-xs mb-0.5">Telepon (Jam Kerja)</span>
                                <span class="font-medium">(0723) 461 001</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded bg-brand-800 flex items-center justify-center flex-shrink-0 text-brand-300">
                                <i class="ph ph-map-pin"></i>
                            </div>
                            <div>
                                <span class="block text-brand-200 text-xs mb-0.5">Sekretariat Walidata</span>
                                <span class="font-medium text-brand-50 leading-relaxed">Jl. Way Kanan Raya Perkantoran<br>Blambangan Umpu, Way Kanan<br>Lampung 34764 Dinas Kominfo Way Kanan</span>
                            </div>
                        </li>
                    </ul>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <i class="ph ph-steps text-brand-600 text-xl"></i> Alur Penanganan Aduan
                    </h3>
                    
                    <div class="relative pl-6 border-l-2 border-gray-100 space-y-6">
                        
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-blue-100 border-2 border-blue-500 shadow-sm z-10"></div>
                            <h4 class="text-sm font-bold text-slate-800">1. Penerimaan Laporan</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Admin SIMASSADAWAN menerima laporan masuk dan memberikan nomor tiket pelacakan melalui email.</p>
                        </div>
                        
                        
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-orange-100 border-2 border-orange-500 shadow-sm z-10"></div>
                            <h4 class="text-sm font-bold text-slate-800">2. Verifikasi & Eskalasi</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Laporan ditinjau. Jika menyangkut substansi data, akan diteruskan ke OPD Produsen Data terkait.</p>
                        </div>

                        
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-brand-100 border-2 border-brand-500 shadow-sm z-10"></div>
                            <h4 class="text-sm font-bold text-slate-800">3. Tindak Lanjut & Resolusi</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Perbaikan data atau sistem dilakukan. Waktu penyelesaian (SLA) bervariasi antara 1-5 hari kerja.</p>
                        </div>
                    </div>
                </div>
                

            </aside>

        </div>
    </main>
</div>