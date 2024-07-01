<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('layouts.app.taskManager') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                        {{ __('layouts.app.tasks') }}
                    </x-nav-link>
                    <x-nav-link :href="route('task_statuses.index')" :active="request()->routeIs('task_statuses.index')">
                        {{ __('layouts.app.statuses') }}
                    </x-nav-link>
                    <x-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.index')">
                        {{ __('layouts.app.labels') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if (Auth::user())
                    <div class="flex items-center lg:order-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')"
                                class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('layouts.app.logout') }}
                            </a>
                        </form>
                    </div>
                @else
                    <div class="flex items-center lg:order-2">
                        <a href="{{ route('login') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('layouts.app.login') }}
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                            {{ __('layouts.app.registry') }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('layouts.app.taskManager') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                {{ __('layouts.app.tasks') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('task_statuses.index')" :active="request()->routeIs('task_statuses.index')">
                {{ __('layouts.app.statuses') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.index')">
                {{ __('layouts.app.labels') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->

        <div class="pt-4 pb-1 border-t border-gray-200">
            @if (Auth::user())
                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('layouts.app.logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('layouts.app.login') }}
                    </x-responsive-nav-link>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('layouts.app.registry') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        </div>
    </div>
</nav>
