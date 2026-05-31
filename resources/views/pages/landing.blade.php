<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Audit</title>
    <link
    rel="icon"
    type="image/png"
    href="{{ asset('images/logo/android-chrome-512x512.png') }}"
>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: 'Poppins', sans-serif;
            background: #020617;
            color: white;
            overflow-x: hidden;
        }

        .gradient{
            background: linear-gradient(135deg,#2563eb,#7c3aed);
        }

        .glass{
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
        }

        html{
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="fixed top-0 w-full z-50 glass">
    <div class="max-w-7xl mx-auto px-8 py-5 flex justify-between items-center">

        <h1 class="text-3xl font-bold">
            <span class="text-blue-500">Org</span>Audit
        </h1>

        <div class="hidden md:flex items-center gap-8">

            <a href="#fitur" class="hover:text-blue-400 transition">
                Fitur
            </a>

            <a href="#panduan" class="hover:text-blue-400 transition">
                Panduan
            </a>

            <a href="/login"
               class="gradient px-6 py-3 rounded-xl hover:scale-105 transition duration-300">
                Login
            </a>

        </div>

    </div>
</nav>

<!-- Hero -->
<section class="min-h-screen flex items-center relative overflow-hidden">

    <div class="absolute w-[500px] h-[500px] bg-blue-600 rounded-full blur-[150px] opacity-20 -top-20 -left-20"></div>

    <div class="absolute w-[400px] h-[400px] bg-purple-600 rounded-full blur-[150px] opacity-20 bottom-0 right-0"></div>

    <div class="max-w-7xl mx-auto px-8 grid lg:grid-cols-2 gap-20 items-center relative z-10">

        <div>

            <h1 class="text-6xl font-bold leading-tight mb-8">
                Kelola Organisasi
                Secara Modern,
                Aman, dan Terstruktur
            </h1>

            <p class="text-slate-300 text-lg leading-relaxed mb-10">
                Platform manajemen organisasi kampus untuk mengatur role,
                divisi, transaksi, dan pengelolaan keuangan organisasi
                secara terintegrasi.
            </p>

            <div class="flex gap-5">

                <a href="{{ route('login.process') }}"
                   class="gradient px-8 py-4 rounded-2xl font-semibold hover:scale-105 transition duration-300 shadow-xl">
                    Mulai Sekarang
                </a>

                <a href="#fitur"
                   class="border border-slate-700 px-8 py-4 rounded-2xl hover:bg-slate-800 transition">
                    Lihat Fitur
                </a>

            </div>

        </div>

        <div class="relative">

            <img
                src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop"
                class="rounded-[40px] shadow-2xl border border-slate-700"
            >

        </div>

    </div>

</section>

<!-- Features -->
<section id="fitur" class="py-28 px-8">

    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-20">

            <h2 class="text-5xl font-bold mb-6">
                Fitur Website
            </h2>

            <p class="text-slate-400 text-lg">
                Sistem organisasi dengan fitur lengkap untuk manajemen divisi dan keuangan.
            </p>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Card -->
            <div class="glass p-8 rounded-3xl hover:-translate-y-2 transition duration-300">

                <div class="mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-14 h-14 text-blue-500"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.5 0h12a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5h-12A1.5 1.5 0 014.5 19.5v-7.5A1.5 1.5 0 016 10.5z"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-semibold mb-4">
                    Authentication
                </h3>

                <p class="text-slate-400">
                    Login dan register dengan sistem autentikasi pengguna.
                </p>

            </div>

            <!-- Card -->
            <div class="glass p-8 rounded-3xl hover:-translate-y-2 transition duration-300">

                <div class="mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-14 h-14 text-purple-500"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M3.75 21h16.5M4.5 3h15v18h-15V3zm3 4.5h9m-9 4.5h9m-9 4.5h6"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-semibold mb-4">
                    Room Organisasi
                </h3>

                <p class="text-slate-400">
                    Membuat dan mengelola room organisasi secara mudah.
                </p>

            </div>

            <!-- Card -->
            <div class="glass p-8 rounded-3xl hover:-translate-y-2 transition duration-300">

                <div class="mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-14 h-14 text-pink-500"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M18 18.72a9.094 9.094 0 003.742-.479m-3.742.479a9.05 9.05 0 01-4.242 0m4.242 0a9.05 9.05 0 004.242 0M15 15.75a3 3 0 11-6 0 3 3 0 016 0zm6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-semibold mb-4">
                    Role & Divisi
                </h3>

                <p class="text-slate-400">
                    Mengatur role anggota dan pengelolaan divisi organisasi.
                </p>

            </div>

            <!-- Card -->
            <div class="glass p-8 rounded-3xl hover:-translate-y-2 transition duration-300">

                <div class="mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-14 h-14 text-green-500"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M12 8c-1.657 0-3 1.12-3 2.5S10.343 13 12 13s3-1.12 3-2.5S13.657 8 12 8zm0 0V6m0 7v2m6-5h-2M8 10H6"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-semibold mb-4">
                    Keuangan
                </h3>

                <p class="text-slate-400">
                    Monitoring transaksi dan pengajuan pendanaan organisasi.
                </p>

            </div>

        </div>

    </div>

</section>

<!-- Panduan -->
<section id="panduan" class="py-28 px-8 bg-slate-950">

    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-20">

            <h2 class="text-5xl font-bold mb-6">
                Panduan Penggunaan
            </h2>

            <p class="text-slate-400 text-lg">
                Langkah penggunaan sistem organisasi kampus.
            </p>

        </div>

        <div class="grid lg:grid-cols-2 gap-10">

            <!-- Ketua -->
            <div class="glass p-10 rounded-3xl">

                <h3 class="text-3xl font-semibold mb-8 text-blue-400">
                    Ketua Organisasi
                </h3>

                <div class="space-y-6 text-slate-300 leading-relaxed">

                    <p>
                        Membuat room organisasi dan mengatur struktur organisasi.
                    </p>

                    <p>
                        Mengatur role dan hak akses anggota organisasi.
                    </p>

                    <p>
                        Mengelola room divisi bersama ketua divisi.
                    </p>

                    <p>
                        Memantau seluruh transaksi dan kondisi keuangan organisasi.
                    </p>

                </div>

            </div>

            <!-- Bendahara -->
            <div class="glass p-10 rounded-3xl">

                <h3 class="text-3xl font-semibold mb-8 text-purple-400">
                    Bendahara & Anggota
                </h3>

                <div class="space-y-6 text-slate-300 leading-relaxed">

                    <p>
                        Bendahara divisi dapat melakukan pencatatan transaksi.
                    </p>

                    <p>
                        Pengajuan pendanaan divisi dilakukan melalui sistem.
                    </p>

                    <p>
                        Bendahara organisasi dapat menyetujui atau menolak pengajuan dana.
                    </p>

                    <p>
                        Seluruh anggota dapat melihat laporan keuangan organisasi maupun divisi.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Footer -->
<footer class="py-10 text-center border-t border-slate-800">

    <h2 class="text-2xl font-bold mb-3">
        Organization Audit System
    </h2>

    <p class="text-slate-500">
        © 2026 All Rights Reserved
    </p>

</footer>

</body>
</html>