<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant Status') }}
        </h2>
    </x-slot>

    <div class="overFlow-x-auto p-6">

        <div class=" max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md ">

        <form action="{{ route('job-applications.update',[ 'job_application' => $jobApplication->id, 'redirectToList' => request()->query('redirectToList') ]) }}" method="POST" >
            @csrf
            @method('PUT')
            <!-- job Application  Details -->
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Job Application Details</h3>
                <p class="text-sm mb-4">Enter the job application details</p>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2"> Applicant Name </label>
                <span>{{ $jobApplication->user->name }}</span>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2"> Job Vacancy </label>
                <span>{{ $jobApplication->jobVacancy->title }}</span>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2"> Company </label>
                <span>{{ $jobApplication->jobVacancy->company->name }}</span>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2"> AI Generated Score </label>
                <span>{{ $jobApplication->aiGeneratedScore }}</span>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2"> AI Generated Feedback </label>
                <span>{{ $jobApplication->aiGeneratedFeedback }}</span>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="pending" {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="accepted" {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>


            <div class="flex justify-end space-x-4">

            <a href="{{ route('job-applications.index') }}"
            class=" py-2 px-4 rounded-md text-gray-500 hover:text-gray-700">
            Cancel
            </a>
                <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md focus:outline-none focus:ring-offset">
                    Update Applicant Status
                </button>
            </div>
        </form>
        </div>
        </div>
    </div>
</x-app-layout>
