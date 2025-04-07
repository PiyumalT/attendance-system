<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Work Schedule - {{ $user->name }}</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('work-schedules.update', $user) }}">
            @csrf @method('PUT')

            <div class="bg-white p-6 shadow rounded space-y-4">

                <h3 class="text-lg font-semibold">Default Schedule</h3>
                <div class="grid grid-cols-2 gap-4">
                    <input type="hidden" name="schedules[0][type]" value="default">
                    <input type="hidden" name="schedules[0][day]" value="">
                    <input type="time" name="schedules[0][start_time]" class="border rounded p-2" value="{{ $schedules['default'][0]->start_time ?? '' }}">
                    <input type="time" name="schedules[0][end_time]" class="border rounded p-2" value="{{ $schedules['default'][0]->end_time ?? '' }}">
                </div>

                <h3 class="text-lg font-semibold mt-6">Custom Rules</h3>
                <div class="space-y-4">
                    @php
                        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                    @endphp
                    @foreach($days as $i => $day)
                        <div class="grid grid-cols-4 gap-4">
                            <input type="hidden" name="schedules[{{ $i + 1 }}][type]" value="weekday">
                            <input type="text" name="schedules[{{ $i + 1 }}][day]" value="{{ $day }}" readonly class="border rounded p-2 bg-gray-100">
                            <input type="time" name="schedules[{{ $i + 1 }}][start_time]" class="border rounded p-2"
                                   value="{{ $schedules['weekday']->firstWhere('day', $day)->start_time ?? '' }}">
                            <input type="time" name="schedules[{{ $i + 1 }}][end_time]" class="border rounded p-2"
                                   value="{{ $schedules['weekday']->firstWhere('day', $day)->end_time ?? '' }}">
                        </div>
                    @endforeach
                </div>

                <div class="text-right mt-6">
                    <a href="{{ route('work-schedules.index') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 text-gray-800 mr-2">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Save Schedule
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
