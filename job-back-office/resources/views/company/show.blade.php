<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>
    <div class="overFlow-x-auto p-6">
        <toast.notification />
        @if (auth()->user()->role == 'admin')
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('companies.index') }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800  py-2 px-4 rounded-md">← Back</a>
        </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Company Details: -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Company Details</h3>
                <p><strong>Name:</strong> {{ $company->owner->name }}</p>
                <p><strong>Email:</strong>{{ $company->owner->email }}</p>
                <p><strong>Address:</strong> {{ $company->address }}</p>
                <p><strong>Industry:</strong> {{ $company->industry }}</p>
                <p><strong>Website:</strong> <a href="{{ $company->website }}" class="text-blue-500 hover:text-blue-700 underline" target="_blank">{{ $company->website }}</a></p>
            </div>
            <!-- Edit and Archive Buttons -->
            <div class=" flex justify-end space-x-4 mb-6">
                @if (auth()->user()->role == 'company-owner')
                <a href="{{ route('my-company.edit') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Edit
                </a>
                @else
                    <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Edit
                    </a>
                @endif
                @if (auth()->user()->role == 'admin')
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Archive
                        </button>
                    </form>
                @endif
            </div>

            @if (auth()->user()->role == 'admin')

            <!-- Tabs Navigation -->
            <div class="mb-4">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('companies.show',['company' => $company->id, 'tab' => 'jobs'])}}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') === 'jobs' || request('tab') == '' ? 'border-b-2  border-blue-500' : ''}}">Jobs</a>
                    </li>
                    <li>
                        <a href="{{ route('companies.show',['company' => $company->id, 'tab' => 'applications']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') === 'applications' ? 'border-b-2  border-blue-500' : ''}}">Applications</a>
                    </li>
                </ul>
            </div>
            <!-- Tabs Content -->
            <div>
            <div id="jobs" class="{{ request('tab') === 'jobs' || request('tab') == '' ? 'block' : 'hidden' }}">
                <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Job Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Location</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($company->jobVacancies as $job)
                            <tr class="border-b">
                                <td class="px-6 py-4 text-gray-800">{{ $job->title }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $job->type }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $job->location }}</td>
                                <td>
                                    <div class="flex space-x-4">
                                        <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No jobs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Applications tab -->
            <div id="applications" class="{{ request('tab') === 'applications' ? 'block' : 'hidden' }}">
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
                        @forelse ($company->jobApplications as $application)
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
        @endif
    </div>

</x-app-layout>
