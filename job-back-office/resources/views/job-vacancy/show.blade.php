<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>
    <div class="overFlow-x-auto p-6">
        <toast.notification />

        <!-- Back Button -->
        <div class="mb-6">
        <a href="{{ route('job-vacancies.index') }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800  py-2 px-4 rounded-md">← Back</a>
            </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Job Details: -->
            <div>
                <h3 class="text-lg font-semibold mb-4">JobVacancy Details</h3>
                <p><strong>Company:</strong> {{ $jobVacancy->company->name }}</p>
                <p><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                <p><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                <p><strong>Salary:</strong> ${{ number_format($jobVacancy->salary, 2) }}</p>
                <p><strong>Description:</strong>{{ $jobVacancy->description }}</p>
            </div>
            <!-- Edit and Archive Buttons -->
            <div class=" flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false']) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Edit
                </a>
                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline-block">
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
                        <a href="{{ route('job-vacancies.show',['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'applications' || request('tab') == '' ? 'border-b-2  border-blue-500' : ''}}">Applications</a>
                    </li>
                </ul>
            </div>
            <!-- Tabs Content -->
            <div>

            <!-- Applications tab -->
            <div id="applications" class="{{ request('tab') == 'applications' || request('tab') == '' ? 'block' : 'hidden' }}">
                <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applicant Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Job Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobVacancy->jobApplications as $application)
                            <tr class="border-b">
                                <td class="px-6 py-4 text-gray-800">{{ $application->user->name }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $application->jobVacancy->title }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $application->status }}</td>
                                <td>
                                    <div class="flex space-x-4">
                                        <a href="{{ route('job-applications.show', $application->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
