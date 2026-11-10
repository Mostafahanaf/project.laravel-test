
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $jobVacancy->title }} - Apply
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">

            <!-- Back Button -->
            <a href="{{ route('dashboard') }}"
               class="text-blue-400 hover:underline mb-6 inline-block">
                ← Back to Job Details
            </a>

            <!-- Job Information -->
            <div class="border-b border-white/10 pb-6 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-white">
                        {{ $jobVacancy->title }}
                    </h1>

                    <p class="text-md text-gray-400 mt-1">
                        {{ $jobVacancy->company->name }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 mt-3">
                        <p class="text-sm text-gray-400">
                            {{ $jobVacancy->location }}
                        </p>

                        <span class="text-gray-500">•</span>

                        <p class="text-sm text-gray-400">
                            {{ '$' . number_format($jobVacancy->salary) }}
                        </p>

                        <span class="text-sm bg-indigo-500 text-white px-3 py-2 rounded-lg">
                            {{ $jobVacancy->type }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <form
                action="{{ route('job-vacancies.process-application', $jobVacancy->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-8"
            >
                @csrf

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-500/10 border border-red-500 text-red-400 p-4 rounded-lg">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Resume Selection -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-4">
                        Choose Your Resume
                    </h3>

                    <div class="mb-6">
                        <x-input-label
                            for="resume"
                            value="Select from your existing resumes:"
                            class="text-gray-300"
                        />

                        <div class="space-y-3 mt-4">

                            @forelse ($resumes as $resume)

                                <label
                                    for="resume-{{ $resume->id }}"
                                    class="flex items-center gap-3 p-4 rounded-lg border border-gray-700 bg-gray-900 hover:border-blue-500 hover:bg-gray-800 transition cursor-pointer"
                                >
                                    <input
                                        type="radio"
                                        name="resume"
                                        id="resume-{{ $resume->id }}"
                                        value="{{ $resume->id }}"
                                        class="w-4 h-4 text-blue-500 bg-gray-700 border-gray-600 focus:ring-blue-500"
                                        {{ old('resume') == $resume->id ? 'checked' : '' }}
                                    >

                                    <span class="text-white">
                                        {{ $resume->filename }}
                                    </span>
                                </label>

                            @empty

                                <p class="text-gray-400 bg-gray-900 p-4 rounded-lg">
                                    You don't have any saved resumes yet.
                                </p>

                            @endforelse

                        </div>
                    </div>
                </div>

                <!-- Upload New Resume -->
                <div
                    x-data="{
                        fileName: '',
                        hasError: {{ $errors->has('resume_file') ? 'true' : 'false' }}
                    }"
                >
                    <h3 class="text-xl font-semibold text-white mb-4">
                        Upload New Resume
                    </h3>

                    <x-input-label
                        for="new_resume_file"
                        value="Or upload a new resume:"
                        class="text-gray-300 mb-3"
                    />

                    <label
                        for="new_resume_file"
                        class="block cursor-pointer"
                    >
                        <div
                            class="border-2 border-dashed border-gray-600 rounded-lg p-8 hover:border-blue-500 hover:bg-gray-900/50 transition"
                            :class="{
                                'border-blue-500': fileName,
                                'border-red-500': hasError
                            }"
                        >

                            <input
                                @change="fileName = $event.target.files.length ? $event.target.files[0].name : ''"
                                type="file"
                                name="resume_file"
                                id="new_resume_file"
                                class="hidden"
                                accept=".pdf,application/pdf"
                            >

                            <div class="text-center">

                                <template x-if="!fileName">
                                    <div>
                                        <svg
                                            class="w-10 h-10 mx-auto mb-3 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                            />
                                        </svg>

                                        <p class="text-gray-300 font-medium">
                                            Click to upload your resume
                                        </p>

                                        <p class="text-gray-500 text-sm mt-2">
                                            PDF format (Max 500 KB)
                                        </p>
                                    </div>
                                </template>

                                <template x-if="fileName">
                                    <div>
                                        <p
                                            x-text="fileName"
                                            class="text-blue-400 font-medium"
                                        ></p>

                                        <p class="text-gray-400 text-sm mt-2">
                                            Click to change file
                                        </p>
                                    </div>
                                </template>

                            </div>
                        </div>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-white/10">

                    <x-primary-button class="w-full justify-center py-3">
                        Apply Now
                    </x-primary-button>

                </div>

            </form>
        </div>
    </div>
</x-app-layout>
