<nav class="w-[250px] h-screen bg-white border-r border-gray-200">
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-6 w-auto full-current text-gray-800"/>
            <span class="text-lg font-semubold text-gray-800">Sgaghlni</span>
        </a>
    </div>

    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>
    </ul>

    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link href="{{ route('companies.index') }}" :active="request()->routeIs('dashboard')">
            Companies
        </x-nav-link>
    </ul>

    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link href="{{ route('job-applications.index') }}" :active="request()->routeIs('dashboard')">
            Jop Applications
        </x-nav-link>
    </ul>

    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link href="{{ route('job-categorise.index') }}" :active="request()->routeIs('dashboard')">
            Jop Categories
        </x-nav-link>
    </ul>

    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link href="{{ route('job-vacancies.index') }}" :active="request()->routeIs('dashboard')">
            Jop Vacancies
        </x-nav-link>
    </ul>

    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link href="{{ route('user.index') }}" :active="request()->routeIs('dashboard')">
            User
        </x-nav-link>

        <hr />
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-nav-link :herf="route('logout')" :active="false" class="text-red-500" onclick="event.preventDefault(); this.closest('form').submit();">
                Logout
            </x-nav-link>
        </form>
    </ul>
</nav>
