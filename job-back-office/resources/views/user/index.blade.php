<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Users') }} {{ request()->input('archived')=='true' ? ('Archived') : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6 max-w-7xl mx-auto">
        <toast.notification />
        <div class="flex flex-col items-end gap-4 w-full">
        @if(request()->input('archived')=='true')
        <!-- Active -->
        <a href="{{ route('user.index') }}"
            class="inline-flex items-center bg-black hover:bg-gray-700 text-white text-sm font-semibold py-2 px-5 rounded-full shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Active Users </a>

        @else
        <!-- Archived -->

            <a href="{{ route('user.index', ['archived' => 'true']) }}"
            class="inline-flex items-center bg-black hover:bg-gray-700 text-white text-sm font-semibold py-2 px-5 rounded-full shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Archived Users</a>
        @endif

        <!-- Users table -->

        <table class="w-full min-w-full divide-y divide-gray-200 rounded-xl shadow-md ring-1 ring-gray-200 bg-white">
            <th>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"> Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">role</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                </tr>
            </th>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            <span class="text-gray-500">{{ $user->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->role }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center space-x-3">
                            @if(request()->input('archived')=='true')
                            <!-- Restore Button -->
                            <form action="{{ route('user.restore', $user->id)}}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="px-3 py-1.5 rounded-md bg-green-50 text-green-700 font-medium hover:bg-green-100 transition">♻️ Restore</button>
                            </form>
                            @else
                            <!-- if admin dont allow edit or delete -->
                            @if($user->role !='admin')
                            <!-- Edit Button -->
                            <a href="{{ route('user.edit', $user->id)}}" class="px-3 py-1.5 rounded-md bg-blue-50 text-blue-700 font-medium hover:bg-blue-100 transition">✍️ Edit</a>

                            <!-- Archive Button -->
                            <form action="{{ route('user.destroy', $user->id)}}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-md bg-red-50 text-red-700 font-medium hover:bg-red-100 transition">🗃️ Archive</button>
                            </form>
                            @endif
                            @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">No users found</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4 w-full">
            {{ $users->links() }}
        </div>

    </div>
</x-app-layout>
