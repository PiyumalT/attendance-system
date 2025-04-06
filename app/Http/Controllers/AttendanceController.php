<?php
namespace App\Http\Controllers;

use App\Models\SignIn;
use App\Models\SignOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function showAttendanceForm()
    {
        $user = Auth::user();

        // Assume shift starts at 9:00 AM
        $shiftStart = '09:00';
        $shiftEnd = '17:00'; // Assume shift ends at 5:00 PM
        $now = now();

        // Get the latest sign-in record
        $latestSignIn = SignIn::where('user_id', $user->id)
            ->latest()
            ->first();

        // Check if the user has signed out after the latest sign-in
        $hasSignedOut = $latestSignIn
            ? SignOut::where('sign_in_id', $latestSignIn->id)->exists()
            : true;

        // Determine which form to show (sign-in or sign-out)
        $nextAction = (!$latestSignIn || $hasSignedOut) ? 'in' : 'out';

        // Attendance status message
        $statusMessage = match ($nextAction) {
            'in' => 'You can sign in.',
            'out' => 'You are currently signed in. Please sign out.',
        };

        // Late logic
        $isLate = false;
        $isShortLeave = false;
        if ($nextAction === 'in' && $now->format('H:i') > $shiftStart) {
            $isLate = true;
            $statusMessage = 'You are late!';
        }
        // Check if the user is on short leave
        elseif ($nextAction === 'out' && $shiftEnd > $now->format('H:i')) {
            $isShortLeave = true;
            $statusMessage = 'You are on short leave.';
        }

        return view('attendance.attendance-form', compact(
            'nextAction', 'statusMessage', 'isLate', 'shiftStart' , 'shiftEnd', 'isShortLeave'
        ));
    }

    public function storeSignIn(Request $request)
    {
        $request->validate(['notes' => 'nullable|string|max:255']);

        // check if user already signed in , by checking the latest sign-in record , but not signed out

        $userId = Auth::id();
        $latestSignIn = SignIn::where('user_id', $userId)
            ->latest()
            ->first();
        $hasSignedOut = $latestSignIn
            ? SignOut::where('sign_in_id', $latestSignIn->id)->exists()
            : true;
        if ($latestSignIn && !$hasSignedOut) {
            // User has already signed in and not signed out
            // Redirect to the attendance form with an error message
            return redirect()->route('attendance.create')->with('error', 'You are already signed in.');
        }

        // Check sign in time and set status on_time', 'late', 'absent', 'before'
        $shiftStart = '09:00';
        $now = now()->format('H:i');
        $status = 'on_time';
        if ($now > $shiftStart) {
            $status = 'late';
        }
        // if one hour before the shift start
        elseif ($now < date('H:i', strtotime($shiftStart) - 3600)) {
            $status = 'before';
        }
        // if 5 hours after the shift start
        elseif ($now > date('H:i', strtotime($shiftStart) + 3600*5)) {
            $status = 'absent';
        }

        // Create a new SignIn record
        $signIn = SignIn::create([
            'user_id' => Auth::id(),
            'status' => $status,
            'timestamp' => now(),
            'notes' => $request->notes,
        ]);

        // Redirect to receipt page after successful sign-in
        return redirect()->route('attendance.receipt', ['sign_in' => $signIn->id])->with('success', 'Signed in successfully.');
    }

    public function storeSignOut(Request $request)
    {
        $request->validate(['notes' => 'nullable|string|max:255']);

        $userId = Auth::id();
        $signIn = SignIn::where('user_id', $userId)
            ->latest()
            ->first();

        // Ensure the sign-in exists and hasn't been signed out already
        if ($signIn && !SignOut::where('sign_in_id', $signIn->id)->exists()) {

            // Check sign out time and set status on_time', 'early', 'absent' , 'over_time'
            $shiftEnd = '17:00'; // Assume shift ends at 5:00 PM
            $now = now()->format('H:i');
            $status = 'on_time';
            $overtime = false;
            if ($now < $shiftEnd) {
                $status = 'early';
            } elseif ($now > date('H:i', strtotime($shiftEnd) + 3600)) {
                $status = 'over_time';
                $overtime = true;
            }

            // Create the SignOut record
            $signOut = SignOut::create([
                'user_id' => $userId,
                'status' => $status,
                'timestamp' => now(),
                'sign_in_id' => $signIn->id,
                'notes' => $request->notes,
            ]);

            // Redirect to receipt page after successful sign-out
            return redirect()->route('attendance.receipt', [
                'sign_in' => $signIn->id,
                'sign_out' => $signOut->id
            ])->with('success', 'Signed out successfully.');
        }

        return redirect()->route('attendance.create')->with('error', 'No active sign-in found.');
    }

    public function showReceipt($sign_in, $sign_out = null)
    {
        $signIn = SignIn::find($sign_in);
        $signOut = $sign_out ? SignOut::find($sign_out) : null;

        if (!$signIn) {
            return redirect()->route('attendance.create')->with('error', 'Invalid sign-in record.');
        }

        $user = Auth::user();

        return view('attendance.attendance-receipt', compact('signIn', 'signOut', 'user'));
    }

    public function view(Request $request)
    {
        $query = SignIn::with(['user', 'signOut']);
    
        // Filter by date range
        if ($request->from_date) {
            $query->whereDate('timestamp', '>=', $request->from_date);
        } else {
            $query->whereDate('timestamp', now()->toDateString()); // Default: today
        }
    
        if ($request->to_date) {
            $query->whereDate('timestamp', '<=', $request->to_date);
        }
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Check if the user has the 'view_attendance' permission
        if (!$user->can('view_attendance')) {
            // If the user does not have permission, filter only their own data
            $query->where('user_id', $user->id);
        }
    
        // If the user has the 'view_attendance' permission, check for the search query
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
    
        // Get the filtered attendances
        $attendances = $query->latest()->get();

        $attendances->transform(function ($attendance) {
            return [
                'user_name' => $attendance->user->name,
                'user_email' => $attendance->user->email,
                'sign_in_time' => $attendance->timestamp,
                'sign_in_status' => $attendance->status,
                'sign_out_time' => optional($attendance->signOut)->timestamp,
                'sign_out_status' => optional($attendance->signOut)->status,
                'notes' => $attendance->notes . ' ' . optional($attendance->signOut)->notes,
                'worked_mins' =>($attendance->signOut && $attendance->timestamp)
                    ? Carbon::parse($attendance->timestamp)->diffInMinutes(Carbon::parse($attendance->signOut->timestamp))
                    : null,

                'overtime' => ($attendance->signOut && $attendance->signOut->status === 'over_time')
                    ? Carbon::parse($attendance->signOut->timestamp)->diffInMinutes(Carbon::createFromTimeString('17:00'))
                    : null,
            ];
        });

        return view('attendance.view', compact('attendances'));
    }

}
