<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user->name }} | Applied to {{ $jobApplication->jobVacancy->title  }}
        </h2>
    </x-slot>
    <div class="overFlow-x-auto p-6">
        <toast.notification />

        <!-- Back Button -->
        <div class="mb-6">
        <a href="{{ route('job-applications.index') }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800  py-2 px-4 rounded-md">← Back</a>
            </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Application Details: -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Application Details</h3>
                <p><strong>Applicant:</strong> {{ $jobApplication->user->name }}</p>
                <p><strong>Job Vacancy:</strong> {{ $jobApplication->jobVacancy->title }}</p>
                <p><strong>Company:</strong> {{ $jobApplication->jobVacancy->company->name }}</p>
                <p><strong>Status:</strong> <span class="@if($jobApplication->status == 'accepted') text-green-500 @elseif($jobApplication->status == 'rejected') text-red-500 @else text-yellow-800 @endif">{{ $jobApplication->status }}</span></p>
                <p><strong>Resume:</strong>
                <a class="text-blue-500 hover:text-blue-700 underline"
                href="{{ $jobApplication->resume->fileUri }}" target="_blank">{{ $jobApplication->resume->fileUri }}</a></p>
            </div>
            <!-- Edit and Archive Buttons -->
            <div class=" flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-applications.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false']) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Edit
                </a>
                <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Archive
                    </button>
                </form>
            </div>
            <!-- Tabs Navigation -->
            <div class="mb-4">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('job-applications.show',['job_application' => $jobApplication->id, 'tab' => 'resume']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') === 'resume' || request('tab') == '' ? 'border-b-2  border-blue-500' : ''}}">Resume</a>
                    </li>
                    <li>
                        <a href="{{ route('job-applications.show',['job_application' => $jobApplication->id, 'tab' => 'AIFeedback']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') === 'AIFeedback' ? 'border-b-2  border-blue-500' : ''}}">AI Feedback</a>
                    </li>
                </ul>
            </div>
            <!-- Resume tab -->
            <div>
            <div id="resume" class="{{ request('tab') === 'resume' || request('tab') == '' ? 'block' : 'hidden' }}">
                <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Summary</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Skills</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Experience</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Education</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                            <td class="px-6 py-4 text-gray-800">{{ $jobApplication->resume->summary }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $jobApplication->resume->skills }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $jobApplication->resume->experience }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $jobApplication->resume->education }}</td>
                            </tr>

                    </tbody>
                </table>
            </div>
            <!-- AIFeedback tab -->
            <div id="AIFeedback" class="{{ request('tab') === 'AIFeedback' ? 'block' : 'hidden' }}">
                <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">AI Score</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                    <td class="px-6 py-4 text-gray-800">{{ $jobApplication->aiGeneratedScore }}</td>
                                    <td class="px-6 py-4 align-top text-sm leading-relaxed text-gray-700 whitespace-pre-line">{{ $jobApplication->aiGeneratedFeedback }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
