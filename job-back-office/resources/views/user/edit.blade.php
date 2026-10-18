<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="overFlow-x-auto p-6">

        <div class=" max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md ">

        <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- User Details -->
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">User Details</h3>
                <p class="text-sm mb-4">Enter the user details</p>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2"> User Name </label>
                <span>{{ $user->name }}</span>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">User Email </label>
                <span>{{ $user->email }}</span>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2"> User Role </label>
                <span>{{ $user->role }}</span>
            </div>

            <!-- owner Password (can update the password) -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2 " >
                    Change user Password </label>
            <div class="relative" x-data="{ showPassword: false }">
                <x-text-input id="password" class="block w-full pr-10"
                x-bind:type="showPassword ? 'text' : 'password'"  name="password"
                autocomplete="current-password" />

            <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500"
                @click="showPassword = !showPassword" >

            <!-- CLOSED EYE - Password is hidden -->
            <svg x-show="!showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg" >
                <path
                    d="M2.45898 12C3.73324 7.94288 7.52354 5 12.0012 5C16.4788 5 20.2691 7.94291 21.5434 12C20.2691 16.0571 16.4788 19 12.0012 19C7.52354 19 3.73324 16.0571 2.45898 12Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />

                <path
                    d="M3 3L21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>


            <!-- OPEN EYE - Password is visible -->
            <svg x-show="showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />

                <path
                    d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            </button>
        </div>
        </div>
        </div>


            <div class="flex justify-end space-x-4">

            <a href="{{ route('user.index') }}"
            class=" py-2 px-4 rounded-md text-gray-500 hover:text-gray-700">
            Cancel
            </a>
                <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md focus:outline-none focus:ring-offset">
                    Update User Status
                </button>
            </div>
        </form>
        </div>
        </div>
    </div>
</x-app-layout>
