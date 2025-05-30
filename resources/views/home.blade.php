<x-app-layout>
    <section
        class="bg-center bg-no-repeat bg-cover bg-[url('https://www.umy.ac.id/wp-content/uploads/2024/10/Gedung-AR-Fachruddin-A-dan-B-1-scaled.jpg')] bg-gray-700 bg-blend-multiply min-h-screen flex items-center">
        <div class="w-full max-w-screen-xl px-4 py-24 mx-auto text-center lg:py-56">
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-white md:text-5xl lg:text-6xl">
                Kami Mengoptimalkan Audit Proses TI untuk Masa Depan yang Lebih Aman
            </h1>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
                Di sini, kami fokus pada audit dan pengawasan proses teknologi informasi yang dapat meningkatkan
                keamanan, efisiensi, dan kepatuhan untuk mendukung pertumbuhan bisnis jangka panjang.
            </p>

            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a href="{{ route('audit.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Get started
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
