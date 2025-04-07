<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Work Schedule: {{ $schedule->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('work-schedules.update', $schedule->id) }}">
                @csrf
                @method('PUT')

                <!-- Work Schedule Name -->
                <div class="mb-4">
                    <label for="name" class="block mb-1 font-medium">Schedule Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $schedule->name) }}" required class="w-full border rounded p-2">
                </div>

                <!-- Work Schedule Days -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold mb-2">Set Work Schedule for Each Day</h3>
                    <div class="grid grid-cols-7 gap-4">
                        @foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $index => $day)
                            <div class="border p-4 rounded-lg">
                                <label class="block text-sm font-medium">{{ $day }}</label>

                                <input type="time" name="days[{{ $index }}][start_time]" value="{{ old('days.' . $index . '.start_time', $schedule->days->where('day_of_week', $index)->first()->start_time ?? '') }}" class="w-full border rounded p-2 mt-2">

                                <input type="time" name="days[{{ $index }}][end_time]" value="{{ old('days.' . $index . '.end_time', $schedule->days->where('day_of_week', $index)->first()->end_time ?? '') }}" class="w-full border rounded p-2 mt-2">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update Schedule
                    </button>
                    <a href="{{ route('work-schedules.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded ml-4 hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
