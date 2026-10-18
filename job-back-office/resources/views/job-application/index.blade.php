<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Job Applications') }} {{ request()->input('archived')=='true' ? ('Archived') : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6 max-w-7xl mx-auto">
        <toast.notification />
        <div class="flex flex-col items-end gap-4 w-full">
        @if(request()->input('archived')=='true')
        <!-- Active -->
        <a href="{{ route('job-applications.index') }}"
            class="inline-flex items-center bg-black hover:bg-gray-700 text-white text-sm font-semibold py-2 px-5 rounded-full shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Active </a>

        @else
        <!-- Archived -->

            <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
            class="inline-flex items-center bg-black hover:bg-gray-700 text-white text-sm font-semibold py-2 px-5 rounded-full shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Archived</a>
        @endif

        <!-- job application table -->

        <table class="w-full min-w-full divide-y divide-gray-200 rounded-xl shadow-md ring-1 ring-gray-200 bg-white">
            <th>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Applicant Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Position (job vacancy)</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Company</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                </tr>
            </th>
            <tbody class="divide-y divide-gray-100">
                @forelse ($jobApplications as $jobApplication)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            @if(request()->input('archived')=='true')
                                <span class="text-gray-500">{{ $jobApplication->user->name }}</span>
                            @else
                                <a href="{{ route('job-applications.show', $jobApplication->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $jobApplication->user->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $jobApplication->jobVacancy?->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 @if($jobApplication->status == 'accepted')  text-green-500 @elseif($jobApplication->status == 'rejected')  text-red-500 @else  text-yellow-500 @endif ">{{ $jobApplication->status }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                            @if(request()->input('archived')=='true')
                            <!-- Restore Button -->
                            <form action="{{ route('job-applications.restore', $jobApplication->id)}}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="px-3 py-1.5 rounded-md bg-green-50 text-green-700 font-medium hover:bg-green-100 transition">♻️ Restore</button>
                            </form>
                            @else
                            <!-- Eidt Button -->
                            <a href="{{ route('job-applications.edit', $jobApplication->id)}}" class="px-3 py-1.5 rounded-md bg-blue-50 text-blue-700 font-medium hover:bg-blue-100 transition">✍️ Edit</a>

                            <!-- Archived Button -->
                            <form action="{{ route('job-applications.destroy', $jobApplication->id)}}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-md bg-red-50 text-red-700 font-medium hover:bg-red-100 transition">🗃️ Archive</button>
                            </form>
                            @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-10 text-center text-sm text-gray-500">No job applications found</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4 w-full">
            {{ $jobApplications->links() }}
        </div>

    </div>
</x-app-layout>
