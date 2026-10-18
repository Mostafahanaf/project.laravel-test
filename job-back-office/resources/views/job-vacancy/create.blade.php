<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="overFlow-x-auto p-6">

        <div class=" max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md ">

        <form action="{{ route('job-vacancies.store') }}" method="POST" >
            @csrf
            <!-- Company Details -->
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Job Vacancy Details</h3>
                <p class="text-sm mb-4">Enter the job vacancy details</p>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Job Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="{{ $errors->has('title') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'">
                @error('title')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Locations</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}"
                class="{{ $errors->has('location') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'">
                @error('location')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="salary" class="block text-gray-700 text-sm font-bold mb-2">Expected Salary (USD)</label>
                <input type="number" name="salary" id="salary" value="{{ old('salary') }}"
                class="{{ $errors->has('salary') ? 'border-red-500 outline outline-1' :''}}  'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'">
                @error('salary')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                <select name="type" id="type" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="Full_Time" {{ old('type') == 'Full_Time' ? 'selected' : '' }}>Full-time</option>
                    <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                    <option value="Remote" {{ old('type') == 'Remote' ? 'selected' : '' }}>Remote</option>
                    <option value="Hybrid" {{ old('type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>



            <!-- company select dropdown -->
            <div class="mb-4">
                <label for="companyId" class="block text-gray-700 text-sm font-bold mb-2">Select Company</label>
                <select name="companyId" id="companyId"
                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm {{ $errors->has('companyId') ? 'border-red-500 outline outline-1' :''}}">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('companyId') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
                @error('companyId')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <!-- job category select dropdown -->
            <div class="mb-4">
                <label for="categoryId" class="block text-gray-700 text-sm font-bold mb-2">Select Job Category</label>
                <select name="categoryId" id="categoryId"
                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm {{ $errors->has('categoryId') ? 'border-red-500 outline outline-1' :''}}">
                    @foreach ($jobCategories as $jobCategory)
                        <option value="{{ $jobCategory->id }}" {{ old('categoryId') == $jobCategory->id ? 'selected' : '' }}>{{ $jobCategory->name }}</option>
                    @endforeach
                </select>
                @error('categoryId')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- job description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Job Description</label>
                <textarea name="description" id="description" rows="4"
                class="{{ $errors->has('description') ? 'border-red-500 outline outline-1' :''}} shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline ">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">

            <a href="{{ route('job-vacancies.index') }}"
            class=" py-2 px-4 rounded-md text-gray-500 hover:text-gray-700">
            Cancel
            </a>
                <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md focus:outline-none focus:ring-offset">
                    Add Job Vacancy
                </button>
            </div>
        </form>
        </div>
        </div>
    </div>
</x-app-layout>
