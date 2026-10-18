@php
    $user = auth()->user();

    if ($user->role === 'admin') {
        $formAction = route('companies.update', [
            'company' => $company->id,
            'redirectToList' => request('redirectToList'),
        ]);
    } else {
        // company-owner (the route middleware already restricts access)
        $formAction = route('my-company.update');
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') . ' - ' . $company->name }}
        </h2>
    </x-slot>

    <div class="overFlow-x-auto p-6">

        <div class=" max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md ">
        <form action="{{ $formAction }}" method="POST" >
            @csrf
            @method('PUT')
            <!-- Company Details -->
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Company Details</h3>
                <p class="text-sm mb-4">Enter the company details</p>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                <input type="text" name="name" id="name" value="{{ old('name' , $company->name) }}"
                class="{{ $errors->has('name') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'">
                @error('name')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                <input type="text" name="address" id="address" value="{{ old('address' , $company->address) }}"
                class="{{ $errors->has('address') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'">
                @error('address')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="industry" class="block text-gray-700 text-sm font-bold mb-2">Industry</label>
                <select name="industry" id="industry" value="{{ old('industry', $company->industry) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach ($industries as $industry)
                    <option value="{{ $industry}}">{{ $industry}}</option>
                    @endforeach
                </select>
                @error('industry')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="website" class="block text-gray-700 text-sm font-bold mb-2">Website (optionaly)</label>
                <input type="text" name="website" id="website" value="{{ old('website', $company->website) }}"
                class="{{ $errors->has('website') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'">
                @error('website')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            </div>

            <!-- Company Owner -->
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Company Owner</h3>
                <p class="text-sm mb-4">Enter the company owner details</p>

            <div class="mb-4">
                <label for="Owner_name" class="block text-gray-700 text-sm font-bold mb-2">Owner Name</label>
                <input type="text" name="Owner_name" id="Owner_name" value="{{ old('Owner_name', $company->owner->name) }}"
                class="{{ $errors->has('Owner_name') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'">
                @error('Owner_name')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <!-- Owner Email (read only not changed) -->
            <div class="mb-4">
                <label for="Owner_email" class="block text-gray-700 text-sm font-bold mb-2">Owner Email</label>
                <input disabled type="email" name="Owner_email" id="Owner_email" value="{{ old('Owner_email', $company->owner->email) }}"
                class="{{ $errors->has('Owner_email') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200">
                @error('Owner_email')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- owner Password (can update the password) -->
            <div class="mb-4">
                <label for="Owner_password" class="block text-gray-700 text-sm font-bold mb-2 " value="{{ old('Owner_password', $company->owner->password) }}">
                    Change Owner Password (leave blank to keep same)</label>
            <div class="relative" x-data="{ showPassword: false }">
                <x-text-input id="Owner_password" class="block w-full pr-10"
                x-bind:type="showPassword ? 'text' : 'password'"  name="Owner_password"
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
            @if (auth()->user()->role == 'company-owner')
                <a href="{{ route('my-company.show') }}"
                class=" py-2 px-4 rounded-md text-gray-500 hover:text-gray-700">
                Cancel
                </a>
            @endif

            @if (auth()->user()->role == 'admin')
                <a href="{{ route('companies.index') }}"
                class=" py-2 px-4 rounded-md text-gray-500 hover:text-gray-700">
                Cancel
                </a>
            @endif
                <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md focus:outline-none focus:ring-offset">
                    Update Company
                </button>
            X
            </div>
        </form>
        </div>
    </div>
</x-app-layout>
