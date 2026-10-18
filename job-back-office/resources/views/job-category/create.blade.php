<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ADD Job Category') }}
        </h2>
    </x-slot>

    <div class="overFlow-x-auto p-6">

        <div class=" max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md ">

        <form action="{{ route('job-categorise.store') }}" method="POST" >
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Category Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="{{ $errors->has('name') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' }}">
                @error('name')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">

            <a href="{{ route('job-categorise.index') }}"
            class=" py-2 px-4 rounded-md text-gray-500 hover:text-gray-700">
            Cancel
            </a>
                <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md focus:outline-none focus:ring-offset">
                    Add Category
                </button>
            </div>
            </div>
        </form>
    </div>
</x-app-layout>
