<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter Clone - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600" rel="stylesheet" />
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        /* Loading screen styles */
        .app-loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s ease-out;
        }

        .app-loading.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #e5e7eb;
            border-top: 3px solid #0ea5e9;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Hide main content until Alpine is ready */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-inter">
    <!-- Loading Screen -->
    <div id="app-loading" class="app-loading">
        <div class="text-center">
            <div class="loading-spinner mx-auto mb-4"></div>
            <p class="text-gray-600 text-sm">Loading...</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-3 lg:grid-cols-4 max-w-6xl mx-auto gap-2 mt-2">
        <x-sidebar />
        <div class="lg:col-span-2 max-h-screen min-h-screen overflow-y-auto scroll no-scrollbar">
            @yield('content')
        </div>
        <aside class="bg-white rounded-2xl sticky top-0 h-72 shadow p-4" x-data="trendingData()"
            x-init="loadTrends()">
            <h4 class="font-bold text-lg mb-3 mt-0.5">Trending</h4>
            <div x-show="isLoading" class="text-center py-10 text-gray-400">
                <p>Loading...</p>
            </div>
            <div x-show="!isLoading && trends.length === 0" class="text-center py-10 text-gray-400">
                <p>No trends yet.</p>
            </div>
            <ol class="pl-5" x-show="!isLoading && trends.length > 0">
                <template x-for="(trend, index) in trends" :key="trend.id || index">
                    <li class="mb-2.5 text-base">
                        <a :href="getTrendUrl(trend)" class="font-semibold text-sky-500 no-underline hover:underline"
                            x-text="getTrendText(trend)"></a>
                        <br>
                        <span class="text-gray-400 text-xs" x-text="`${trend.count} posts`"></span>
                    </li>
                </template>
            </ol>
        </aside>
    </div>

    <script>
        // Trending data component (your existing code)
        function trendingData() {
            return {
                trends: [],
                isLoading: true,
                async loadTrends() {
                    try {
                        const response = await fetch('{{ route('api.trends') }}');
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        this.trends = data;
                    } catch (error) {
                        console.error('Failed to load trends:', error);
                        // Optionally show user-friendly error message
                        // this.error = 'Failed to load trending topics';
                    } finally {
                        this.isLoading = false;
                    }
                },
                getTrendText(trend) {
                    return trend.type === 'hashtag' ? `#${trend.value}` : trend.value;
                },
                getTrendUrl(trend) {
                    const query = trend.type === 'hashtag' ? `#${trend.value}` : trend.value;
                    // Using Laravel's route() helper - make sure it's available in your view
                    return route('tweets.search', {
                        q: query
                    });
                }
            };
        }

        // Function to hide loading screen
        function hideLoadingScreen() {
            const loadingScreen = document.getElementById('app-loading');
            if (loadingScreen) {
                loadingScreen.classList.add('fade-out');
                setTimeout(() => {
                    loadingScreen.remove();
                }, 300); // Match the CSS transition duration
            }
        }

        // Hide loading screen when Alpine is ready
        document.addEventListener('alpine:init', () => {
            setTimeout(() => {
                hideLoadingScreen();
            }, 100);
        });

        // Fallback: Hide loading screen after a maximum time
        setTimeout(() => {
            hideLoadingScreen();
        }, 5000); // 5 seconds maximum loading time
    </script>
    @stack('scripts')
</body>

</html>
