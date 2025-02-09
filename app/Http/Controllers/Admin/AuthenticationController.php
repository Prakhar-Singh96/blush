<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticationController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['message' => 'User does not exist']);
        }

        // Verify the password
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors(['message' => 'Invalid credentials']);
        }

        // Store user information in the session
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_type' => $user->user_type,
            'user_status' => $user->status
        ]);

        // Check the user type
        if ($user->user_type === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        } elseif ($user->user_type === 'student') {
            return redirect()->route('student.dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['message' => 'User type is not recognized']);
    }
}
