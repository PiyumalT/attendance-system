<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Show the form to create a new user
    public function create()
    {
        $roles = Role::all();  // Fetch all roles (you can limit this if necessary)
        return view('users.create', compact('roles'));
    }

    // Store the newly created user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'exists:roles,name'],  // Ensure the role exists
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign the selected role
        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
}
