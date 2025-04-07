<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manage Work Schedules</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <ul>
                @foreach ($users as $user)
                    <li class="py-2 border-b">
                        <a href="{{ route('work-schedules.edit', $user) }}" class="text-blue-600 hover:underline">
                            {{ $user->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
