
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-4">

        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">
                    Active Users
                </h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['activeUsers'] }}
                </p>
                <p class="text-sm text-gray-500">Last 30 days</p>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">
                    Total Jobs
                </h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['totalJobs'] }}
                </p>
                <p class="text-sm text-gray-500">All time</p>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">
                    Total Applications
                </h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['totalApplications'] }}
                </p>
                <p class="text-sm text-gray-500">All time</p>
            </div>

        </div>

        {{-- Most Applied Jobs --}}
        <div class="bg-white p-6 shadow-sm sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                Most Applied Jobs
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 uppercase text-gray-500">
                                Job Title
                            </th>
                            @if(auth()->user()->role == 'admin')
                            <th class="py-2 uppercase text-gray-500">
                                Company
                            </th>
                            @endif
                            <th class="py-2 uppercase text-gray-500">
                                Total Applications
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($analytics['mostAppliedJobs'] as $job)
                            <tr>
                                <td class="py-4">
                                    {{ $job->title }}
                                </td>
                                @if(auth()->user()->role == 'admin')
                                <td class="py-4">
                                    {{ $job->company->name ?? 'N/A' }}
                                </td>
                                @endif
                                <td class="py-4">
                                    {{ $job->totalCount }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-gray-500">
                                    No jobs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Conversion Rates --}}
        <div class="bg-white p-6 shadow-sm sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                Conversion Rates
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 uppercase text-gray-500">
                                Job Title
                            </th>
                            <th class="py-2 uppercase text-gray-500">
                                Views
                            </th>
                            <th class="py-2 uppercase text-gray-500">
                                Applications
                            </th>
                            <th class="py-2 uppercase text-gray-500">
                                Conversion Rate
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($analytics['conversionRates'] as $conversionRate)
                            <tr>
                                <td class="py-4">
                                    {{ $conversionRate->title }}
                                </td>
                                <td class="py-4">
                                    {{ $conversionRate->viewCount }}
                                </td>
                                <td class="py-4">
                                    {{ $conversionRate->totalCount }}
                                </td>
                                <td class="py-4">
                                    {{ $conversionRate->conversionRate }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-gray-500">
                                    No conversion data available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
