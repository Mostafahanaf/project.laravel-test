<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancies') }} {{ request()->input('archived')=='true' ? ('Archived') : '' }}
        </h2>
    </x-slot>

    <div class="overFlow-x-auto p-6">
        <toast.notification />
        <div class="flex justify-end items-center space-x-4">
        @if(request()->input('archived')=='true')
        <!-- Active -->
        <a href="{{ route('job-vacancies.index') }}"
            class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Active </a>

        @else
        <!-- Archived -->

            <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
            class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Archived</a>
        @endif

        <!-- add job vacancy button -->
            <a href="{{ route('job-vacancies.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            ➕ Add Job Vacancy</a>
        </div>

        <!-- job vacancy table -->

        <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <th>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </th>
            <tbody>
                @forelse ($jobVacancies as $jobVacancy)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived')=='true')
                                <span class="text-gray-500">{{ $jobVacancy->title }}</span>
                            @else
                                <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}" class="text-blue-500 hover:text-blue-700 underline">{{ $jobVacancy->title }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->company->name }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->location }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->type }}</td>
                        <td class="px-6 py-4 text-gray-800">${{ number_format($jobVacancy->salary, 2) }}</td>
                        <td>
                            <div class="flex space-x-4">
                            @if(request()->input('archived')=='true')
                            <!-- Restore Button -->
                            <form action="{{ route('job-vacancies.restore', $jobVacancy->id)}}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                            </form>
                            @else
                            <!-- Eidt Button -->
                            <a href="{{ route('job-vacancies.edit', $jobVacancy->id)}}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                            <!-- Archived Button -->
                            <form action="{{ route('job-vacancies.destroy', $jobVacancy->id)}}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                            </form>
                            @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-800">No job vacancies found</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>

    </div>
</x-app-layout>
