<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Users</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + Create New User
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-700 hover:underline">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-700 hover:underline">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-700 hover:underline">
                                        {{ $user->roles->pluck('name')->first() ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                <x-delete-button :action="route('users.destroy', $user->id)" :entity="'user ' . $user->name" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
