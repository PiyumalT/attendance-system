<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Salary Report</h2>
    </x-slot>

    <div class="p-4 max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <form method="GET" class="flex items-center gap-2">
                <input type="hidden" name="month" value="{{ $previousMonth }}">
                <button type="submit" class="px-3 py-1 bg-gray-200 rounded">← Prev</button>
            </form>

            <div class="text-lg font-semibold">{{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</div>

            <form method="GET" class="flex items-center gap-2">
                <input type="hidden" name="month" value="{{ $nextMonth }}">
                <button type="submit" class="px-3 py-1 bg-gray-200 rounded" {{ $disableNext ? 'disabled' : '' }}>Next →</button>
            </form>
        </div>

        <div class="grid grid-cols-7 gap-4 text-center border rounded p-4 bg-white mb-6">
            @foreach($calendarData as $date => $data)
                <div class="p-2 border rounded shadow {{ $data['status'] == 'Absent' ? 'bg-red-100' : 'bg-green-50' }}">
                    <strong>{{ \Carbon\Carbon::parse($date)->format('d M D') }}</strong><br>
                    Worked: {{ $data['worked_hours'] }}h<br>
                    OT: {{ $data['ot_hours'] }}h<br>
                    <span class="text-sm text-gray-600">Status: 
                        <span class="{{ $data['status'] == 'Absent' ? 'text-red-600' : 'text-green-600' }}">
                            {{ $data['status'] }}
                        </span>
                    </span>
                </div>
            @endforeach
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Salary Summary - {{ $summary['month'] }}</h3>
            <ul class="space-y-2 text-gray-700">
                <li><strong>Basic Salary:</strong> Rs. {{ number_format($summary['basic_salary'], 2) }}</li>
                <li><strong>Worked Hours:</strong> {{ $summary['worked_hours'] }} hrs</li>
                <li><strong>Overtime Hours:</strong> {{ $summary['ot_hours'] }} hrs</li>
                <li><strong>Absent Days:</strong> {{ $summary['absent_days'] }}</li>
                <li><strong>OT Pay:</strong> Rs. {{ number_format($summary['ot_pay'], 2) }}</li>
                <li><strong>Absent Deduction:</strong> Rs. {{ number_format($summary['absent_deduction'], 2) }}</li>
                <li><strong>Late Deduction:</strong> Rs. {{ number_format($summary['late_deduction'], 2) }}</li>
                <li><strong>Final Salary:</strong>
                    <span class="text-green-700 font-bold">Rs. {{ number_format($summary['total_pay'], 2) }}</span>
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>
