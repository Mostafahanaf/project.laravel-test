<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Categories {{ request()->input('archived')=='true' ? ('Archived') : '' }}
        </h2>
    </x-slot>

    <div class="overFlow-x-auto p-6">
        <toast.notification />
        <div class="flex justify-end items-center space-x-4">
        @if(request()->input('archived')=='true')
        <!-- Active -->
        <a href="{{ route('job-categorise.index') }}"
            class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Active </a>
        
        @else
        <!-- Archived -->
        
            <a href="{{ route('job-categorise.index', ['archived' => 'true']) }}"
            class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Archived</a>
        @endif
        
        <!-- add job category button -->
            <a href="{{ route('job-categorise.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            ➕ Add Job Category</a>
        </div>

        <!-- jobcategory table -->

        <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <th>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </th>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                            @if(request()->input('archived')=='true')
                            <!-- Restore Button -->
                            <form action="{{ route('job-categorise.restore', $category->id)}}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                            </form>
                            @else
                            <!-- Eidt Button -->
                            <a href="{{ route('job-categorise.edit', $category->id)}}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                            <!-- Archived Button -->
                            <form action="{{ route('job-categorise.destroy', $category->id)}}" method="POST" class="inline-block">
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
                        <td colspan="2" class="px-6 py-4 text-gray-800">No categories found</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>

    </div>
</x-app-layout>
