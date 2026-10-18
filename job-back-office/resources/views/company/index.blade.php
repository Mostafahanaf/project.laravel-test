<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Company {{ request()->input('archived')=='true' ? ('Archived') : '' }}
        </h2>
    </x-slot>

    <div class="overFlow-x-auto p-6">
        <toast.notification />
        <div class="flex justify-end items-center space-x-4">
        @if(request()->input('archived')=='true')
        <!-- Active -->
        <a href="{{ route('companies.index') }}"
            class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Active </a>

        @else
        <!-- Archived -->

            <a href="{{ route('companies.index', ['archived' => 'true']) }}"
            class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Archived</a>
        @endif

        <!-- add company button -->
            <a href="{{ route('companies.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            ➕ Add Company</a>
        </div>

        <!-- company table -->

        <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <th>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Address</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Industry</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Website</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </th>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived')=='true')
                                <span class="text-gray-500">{{ $company->name }}</span>
                            @else
                                <a href="{{ route('companies.show', $company->id) }}" class="text-blue-500 hover:text-blue-700 underline">{{ $company->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->address }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->industry }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->website }}</td>
                        <td>
                            <div class="flex space-x-4">
                            @if(request()->input('archived')=='true')
                            <!-- Restore Button -->
                            <form action="{{ route('companies.restore', $company->id)}}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                            </form>
                            @else
                            <!-- Eidt Button -->
                            <a href="{{ route('companies.edit', $company->id)}}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                            <!-- Archived Button -->
                            <form action="{{ route('companies.destroy', $company->id)}}" method="POST" class="inline-block">
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
                        <td colspan="2" class="px-6 py-4 text-gray-800">No companies found</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4">
            {{ $companies->links() }}
        </div>

    </div>
</x-app-layout>
