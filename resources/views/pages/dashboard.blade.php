    @extends('layouts.app')

    @section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-12">
        <x-ecommerce.ecommerce-metrics />
        {{-- <x-ecommerce.monthly-sale /> --}}
        </div>
        {{-- <div class="col-span-12 xl:col-span-5">
            <x-ecommerce.monthly-target />
        </div> --}}

        {{-- <div class="col-span-12">
        <x-ecommerce.statistics-chart />
        </div>

        <div class="col-span-12 xl:col-span-5">
        <x-ecommerce.customer-demographic />
        </div>

        <div class="col-span-12 xl:col-span-7">
        <x-ecommerce.recent-orders />
        </div> --}}
    </div>
    @auth
    <div class="p-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    Organisasi Saya
                </h1>

            </div>

        </div>

        
        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">

            <!-- CARD 1 -->
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <img
                    src="https://images.unsplash.com/photo-1498050108023-c5249f4df085"
                    class="w-full h-48 object-cover">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            Coding Room
                        </h2>

                        <span
                            class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 text-xs px-3 py-1 rounded-full">
                            Active
                        </span>

                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3">
                        Diskusi seputar pemrograman web, mobile, dan teknologi terbaru.
                    </p>

                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 24 Member
                        </span>

                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition">
                            Lihat
                        </button>

                    </div>

                </div>
            </div>

            <!-- CARD 2 -->
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <img
                    src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3"
                    class="w-full h-48 object-cover">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            UI/UX Design
                        </h2>

                        <span
                            class="bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 text-xs px-3 py-1 rounded-full">
                            Design
                        </span>

                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3">
                        Belajar desain modern dan pengalaman pengguna aplikasi.
                    </p>

                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 18 Member
                        </span>

                        <button
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl transition">
                            Lihat
                        </button>

                    </div>

                </div>
            </div>

            <!-- CARD 3 -->
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <img
                    src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f"
                    class="w-full h-48 object-cover">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            Startup Room
                        </h2>

                        <span
                            class="bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300 text-xs px-3 py-1 rounded-full">
                            Business
                        </span>

                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3">
                        Diskusi ide startup dan pengembangan bisnis digital.
                    </p>

                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 31 Member
                        </span>

                        <button
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl transition">
                            Lihat
                        </button>

                    </div>

                </div>
            </div>

            <!-- CARD 4 -->
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <img
                    src="https://images.unsplash.com/photo-1518770660439-4636190af475"
                    class="w-full h-48 object-cover">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            AI Room
                        </h2>

                        <span
                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-xs px-3 py-1 rounded-full">
                            AI
                        </span>

                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3">
                        Belajar machine learning dan artificial intelligence.
                    </p>

                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 15 Member
                        </span>

                        <button
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl transition">
                            Lihat
                        </button>

                    </div>

                </div>
            </div>

            <!-- CARD 5 -->
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <img
                    src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d"
                    class="w-full h-48 object-cover">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            Freelance Room
                        </h2>

                        <span
                            class="bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 text-xs px-3 py-1 rounded-full">
                            Career
                        </span>

                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3">
                        Cari project freelance dan kolaborasi mahasiswa.
                    </p>

                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 12 Member
                        </span>

                        <button
                            class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-xl transition">
                            Lihat
                        </button>

                    </div>

                </div>
            </div>

            <!-- CARD 6 -->
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                <img
                    src="https://images.unsplash.com/photo-1516321497487-e288fb19713f"
                    class="w-full h-48 object-cover">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            Cyber Security
                        </h2>

                        <span
                            class="bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 text-xs px-3 py-1 rounded-full">
                            Security
                        </span>

                    </div>

                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3">
                        Belajar keamanan sistem dan ethical hacking.
                    </p>

                    <div class="flex items-center justify-between mt-6">

                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            👥 20 Member
                        </span>

                        <button
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl transition">
                            Lihat
                        </button>

                    </div>

                </div>
            </div>

        </div>
       

    </div>
     @endauth
    @endsection
