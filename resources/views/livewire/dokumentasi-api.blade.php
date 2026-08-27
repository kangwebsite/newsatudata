<div>
    {{-- Breadcrumb --}}
    <div class="bg-brand-900 text-white pt-10 pb-16 shrink-0 relative mb-8 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)" />
            </svg>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex text-sm text-brand-200 mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" wire:navigate class="hover:text-white transition flex items-center gap-1">
                            <i class="ph ph-house"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph ph-caret-right text-brand-400 text-xs mx-1"></i>
                            <span class="text-white font-medium ml-1">Dokumentasi API</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">
                        Dokumentasi API
                    </h1>
                    <p class="text-brand-100 text-sm md:text-base leading-relaxed opacity-90">
                        Integrasikan data dari portal Satu Data Way Kanan langsung ke dalam aplikasi atau analisis Anda melalui RESTful API. Gratis, terbuka, dan mudah digunakan.
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="#pengantar" class="bg-white text-brand-800 px-5 py-2.5 rounded-lg text-sm font-semibold transition hover:bg-gray-50 flex items-center gap-2 shadow-lg">
                        <i class="ph ph-book-open"></i> Baca Dokumentasi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-8 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">

            
            <div class="grow bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-10 api-content">
                
                <section id="pengantar">
                    <h2>Pengantar</h2>
                    <p>API Satu Data Way Kanan diatur berdasarkan arsitektur <strong>REST</strong>. API kami menggunakan metode HTTP standar dan memberikan respon dalam format <code>JSON</code>. Semua permintaan (request) API harus dilakukan melalui protokol aman <code>HTTPS</code>.</p>
                    
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 my-6">
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Base URL</div>
                        <div class="flex items-center gap-3" x-data="{ copied: false, textToCopy: '{{ url('api/v2') }}' }">
                            <code class="text-sm font-mono text-brand-800 bg-white border border-slate-200 px-3 py-1.5 rounded grow" x-text="textToCopy"></code>
                            <button class="bg-white border border-slate-200 hover:bg-gray-50 text-slate-600 px-3 py-1.5 rounded text-sm transition" @click="navigator.clipboard.writeText(textToCopy); copied = true; setTimeout(() => copied = false, 2000);">
                                <i x-show="!copied" class="ph ph-copy"></i>
                                <i x-show="copied" x-cloak class="ph ph-check text-teal-400"></i>
                                 Salin
                            </button>
                        </div>
                    </div>
                </section>

                <section id="error-handling">
                    <h2>Penanganan Error (Error Handling)</h2>
                    <p>API kami menggunakan kode status HTTP konvensional untuk menunjukkan keberhasilan atau kegagalan permintaan API. Secara umum, kode di rentang <code>2xx</code> menunjukkan keberhasilan, <code>4xx</code> menunjukkan kegagalan dari sisi klien (misalnya, parameter tidak valid), dan <code>5xx</code> menunjukkan kegagalan pada server kami.</p>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Kode Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code class="text-green-600 bg-green-50 font-bold">200 - OK</code></td>
                                <td>Permintaan berhasil. Data akan dikembalikan pada *body* respon.</td>
                            </tr>
                            <tr>
                                <td><code class="text-red-600 bg-red-50 font-bold">404 - Not Found</code></td>
                                <td>Sumber daya (resource) atau *endpoint* tidak ditemukan.</td>
                            </tr>
                            <tr>
                                <td><code class="text-orange-600 bg-orange-50 font-bold">429 - Too Many Requests</code></td>
                                <td>Anda telah melewati batas permintaan yang diizinkan (Rate Limit).</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section id="list-dataset">
                    <h2>Daftar Dataset</h2>
                    <p>Endpoint ini digunakan untuk mengambil daftar seluruh dataset yang tersedia. Anda dapat menggunakan parameter untuk memfilter, mengurutkan, dan melakukan paginasi hasil.</p>

                    <div class="flex items-center gap-3 mb-4">
                        <span class="method-badge method-get">GET</span>
                        <code class="text-sm font-bold text-slate-700">/dataset</code>
                    </div>

                    <h3>Parameter Query</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code class="font-bold">per_page</code></td>
                                <td>integer</td>
                                <td>Total dataset per halaman. <em>Default: 10, Max: 50</em></td>
                            </tr>
                            <tr>
                                <td><code class="font-bold">page</code></td>
                                <td>integer</td>
                                <td>Nomor halaman paginasi. <em>Default: 1</em></td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="text-sm text-slate-500 italic mb-6">Contoh request: <code>GET {{ url('api/v2/dataset?per_page=20&page=2') }}</code></p>
                    

                    <div class="mt-4">
                        <h3 class="text-sm font-bold text-slate-700 mb-2">Contoh Respon (200 OK)</h3>
                        <div class="bg-slate-900 rounded-xl overflow-hidden shadow-md">
                            <div class="px-4 py-2 bg-slate-800 border-b border-slate-700">
                                <span class="text-xs font-medium text-slate-400">application/json</span>
                            </div>

<div class="p-4 overflow-x-auto code-scrollbar text-sm font-mono text-slate-300">
<pre class="m-0"><code class="block-code">{
    <span class="text-blue-300">"data"</span>: [
        {
            <span class="text-blue-300">"name"</span>: <span class="text-green-300">"Data Infrastruktur Tahunan"</span>,
            <span class="text-blue-300">"slug"</span>: <span class="text-green-300">"data-infrastruktur-tahunan"</span>,
            <span class="text-blue-300">"description"</span>: <span class="text-green-300">"Data Infrastruktur Tahunan"</span>,
            <span class="text-blue-300">"file"</span>: <span class="text-green-300">"https://new-satudata.test/storage/datastore/01JSMSF0RD90PFSJ95M680Y4J9.csv"</span>,
            <span class="text-blue-300">"organization"</span>: <span class="text-green-300">"KECAMATAN BARADATU"</span>,
            <span class="text-blue-300">"topik"</span>: <span class="text-green-300">"Infrastruktur"</span>,
            <span class="text-blue-300">"periode"</span>: <span class="text-green-300">"Tahunan"</span>,
            <span class="text-blue-300">"tipe_data"</span>: <span class="text-green-300">"Grafik"</span>,
            <span class="text-blue-300">"created_at"</span>: <span class="text-green-300">"2025-04-25 02:57:00"</span>,
            <span class="text-blue-300">"updated_at"</span>: <span class="text-green-300">"2026-08-06 04:37:10"</span>
        },
        {
            <span class="text-blue-300">"name"</span>: <span class="text-green-300">"DATA MENARA BTS WAY KANAN"</span>,
            <span class="text-blue-300">"slug"</span>: <span class="text-green-300">"data-menara-bts-way-kanan"</span>,
            <span class="text-blue-300">"description"</span>: <span class="text-green-300">"deskrispsi"</span>,
            <span class="text-blue-300">"file"</span>: <span class="text-green-300">"https://new-satudata.test/storage/datastore/01K7RCWVB0SWN7WDZZNPD98XBJ.csv"</span>,
            <span class="text-blue-300">"organization"</span>: <span class="text-green-300">"DINAS KOMUNIKASI DAN INFORMATIKA"</span>,
            <span class="text-blue-300">"topik"</span>: <span class="text-green-300">"Infrastruktur"</span>,
            <span class="text-blue-300">"periode"</span>: <span class="text-green-300">"Tahunan"</span>,
            <span class="text-blue-300">"tipe_data"</span>: <span class="text-green-300">"Grafik"</span>,
            <span class="text-blue-300">"created_at"</span>: <span class="text-green-300">"2025-10-16 22:25:00"</span>,
            <span class="text-blue-300">"updated_at"</span>: <span class="text-green-300">"2026-01-12 18:28:00"</span>
        }
    ],
    <span class="text-blue-300">"links"</span>: {
        <span class="text-blue-300">"first"</span>: <span class="text-green-300">"https://new-satudata.test/api/v2/dataset?page=1"</span>,
        <span class="text-blue-300">"last"</span>: <span class="text-green-300">"https://new-satudata.test/api/v2/dataset?page=244"</span>,
        <span class="text-blue-300">"prev"</span>: <span class="text-orange-300">null</span>,
        <span class="text-blue-300">"next"</span>: <span class="text-green-300">"https://new-satudata.test/api/v2/dataset?page=2"</span>
    },
    <span class="text-blue-300">"meta"</span>: {
        <span class="text-blue-300">"current_page"</span>: <span class="text-orange-300">1</span>,
        <span class="text-blue-300">"from"</span>: <span class="text-orange-300">1</span>,
        <span class="text-blue-300">"last_page"</span>: <span class="text-orange-300">244</span>,
        <span class="text-blue-300">"links"</span>: [
            {
                <span class="text-blue-300">"url"</span>: <span class="text-orange-300">null</span>,
                <span class="text-blue-300">"label"</span>: <span class="text-green-300">"&amp;laquo; Previous"</span>,
                <span class="text-blue-300">"page"</span>: <span class="text-orange-300">null</span>,
                <span class="text-blue-300">"active"</span>: <span class="text-orange-300">false</span>
            },
            .....
        ],
        <span class="text-blue-300">"path"</span>: <span class="text-green-300">"https://new-satudata.test/api/v2/dataset"</span>,
        <span class="text-blue-300">"per_page"</span>: <span class="text-orange-300">2</span>,
        <span class="text-blue-300">"to"</span>: <span class="text-orange-300">2</span>,
        <span class="text-blue-300">"total"</span>: <span class="text-orange-300">487</span>
    },
    <span class="text-blue-300">"status"</span>: <span class="text-orange-300">true</span>,
    <span class="text-blue-300">"message"</span>: <span class="text-green-300">"Dataset berhasil ditemukan"</span>
}</code></pre>
</div>

                        </div>
                    </div>
                </section>

                <section id="detail-dataset">
                    <h2>Detail Dataset</h2>
                    <p>Endpoint ini digunakan untuk mendapatkan metadata lengkap dan struktur dari sebuah dataset spesifik berdasarkan ID-nya.</p>

                    <div class="flex items-center gap-3 mb-4">
                        <span class="method-badge method-get">GET</span>
                        <code class="text-sm font-bold text-slate-700">/dataset/{slug}</code>
                    </div>

                    <h3>Path Parameter</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code class="font-bold">slug</code></td>
                                <td>string</td>
                                <td>ID unik dataset (slug). Diperlukan.</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <p class="text-sm text-slate-500 italic mb-6">Contoh request: <code>GET {{ url('api/v2/dataset/data-infrastruktur-tahunan') }}</code></p>

                    <div class="mt-4">
                        <h3 class="text-sm font-bold text-slate-700 mb-2">Contoh Respon (200 OK)</h3>
                        <div class="bg-slate-900 rounded-xl overflow-hidden shadow-md">
                            <div class="px-4 py-2 bg-slate-800 border-b border-slate-700">
                                <span class="text-xs font-medium text-slate-400">application/json</span>
                            </div>

<div class="p-4 overflow-x-auto code-scrollbar text-sm font-mono text-slate-300">
<pre class="m-0"><code class="block-code">{
    <span class="text-blue-300">"data"</span>: {
        <span class="text-blue-300">"name"</span>: <span class="text-green-300">"Data Infrastruktur Tahunan"</span>,
        <span class="text-blue-300">"slug"</span>: <span class="text-green-300">"data-infrastruktur-tahunan"</span>,
        <span class="text-blue-300">"description"</span>: <span class="text-green-300">"Data Infrastruktur Tahunan"</span>,
        <span class="text-blue-300">"file"</span>: <span class="text-green-300">"https://new-satudata.test/storage/datastore/01JSMSF0RD90PFSJ95M680Y4J9.csv"</span>,
        <span class="text-blue-300">"organization"</span>: <span class="text-green-300">"KECAMATAN BARADATU"</span>,
        <span class="text-blue-300">"topik"</span>: <span class="text-green-300">"Infrastruktur"</span>,
        <span class="text-blue-300">"periode"</span>: <span class="text-green-300">"Tahunan"</span>,
        <span class="text-blue-300">"tipe_data"</span>: <span class="text-green-300">"Grafik"</span>,
        <span class="text-blue-300">"created_at"</span>: <span class="text-green-300">"2025-04-25 02:57:00"</span>,
        <span class="text-blue-300">"updated_at"</span>: <span class="text-green-300">"2026-08-06 04:37:10"</span>
    },
    <span class="text-blue-300">"status"</span>: <span class="text-orange-300">true</span>,
    <span class="text-blue-300">"message"</span>: <span class="text-green-300">"Dataset berhasil ditemukan"</span>
}</code></pre>
</div>

                        </div>
                    </div>

                </section>
                

            </div>
        </div>
    </main>
</div>
