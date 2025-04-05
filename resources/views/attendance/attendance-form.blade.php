<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Form') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-center mb-4">Hello, {{ auth()->user()->name }}!</h3>

            <div class="mb-4">
                <p class="text-lg">
                    {{ $statusMessage }}
                </p>
                @if ($isLate)
                    <p class="text-red-500">You are late! Your shift started at {{ $shiftStart }}.</p>
                @elseif ($isShortLeave)
                    <p class="text-orange-500">You may have a short leave based on the shift start time.</p>
                @endif
            </div>

            <form action="{{ route('attendance.' . ($nextAction === 'in' ? 'sign-in' : 'sign-out')) }}" method="POST">
                @csrf

                <input type="hidden" name="sign_type" value="{{ $nextAction }}">

                <!-- Notes -->
                <div class="mb-4">
                    <label for="notes" class="form-label text-sm font-medium text-gray-700">Notes (Optional)</label>
                    <textarea class="form-control w-full p-2 border border-gray-300 rounded-md" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" class="btn btn-primary px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        {{ $nextAction === 'in' ? 'Sign In' : 'Sign Out' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
