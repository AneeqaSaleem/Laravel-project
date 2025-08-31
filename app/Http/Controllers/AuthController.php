<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the user registration page.
     *
     * This method simply returns the registration view (auth.register)
     * so the user can see the registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     *
     * - Validates user input (name, email, password, optional profile picture).
     * - If a profile picture is uploaded, it generates a unique filename,
     *   validates the file, creates a `public/profiles` folder if it doesn't exist,
     *   and moves the uploaded file into it.
     * - Creates a new user in the database with hashed password.
     * - Logs in the newly created user.
     * - Redirects to the products index page with a success message.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $profileImage = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $profileImage = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!$file->isValid()) {
                return back()->withErrors(['profile_picture' => 'Invalid file uploaded.'])->withInput();
            }

            $profilesPath = public_path('profiles');
            if (!file_exists($profilesPath)) {
                mkdir($profilesPath, 0755, true);
            }

            try {
                $file->move($profilesPath, $profileImage);
            } catch (\Exception $e) {
                $profileImage = null;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $profileImage,
        ]);

        Auth::login($user);

        return redirect()->route('products.index')->with('success', 'Registration successful!');
    }

    /**
     * Show the user login page.
     *
     * This method returns the login view (auth.login)
     * so the user can enter their credentials.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     *
     * - Validates email and password from the request.
     * - Attempts authentication using Laravel's Auth facade.
     * - If successful, regenerates the session and redirects
     *   to the products index page with a success message.
     * - If authentication fails, it returns back with an error
     *   indicating invalid credentials.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('products.index')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle user logout.
     *
     * - Logs out the currently authenticated user.
     * - Invalidates the session and regenerates CSRF token
     *   for security purposes.
     * - Redirects to the login page with a success message.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.show')->with('success', 'You have been logged out successfully!');
    }

    /**
     * Update the authenticated user's password.
     *
     * - Validates current and new passwords.
     * - Verifies that the provided current password matches
     *   the one stored in the database.
     * - If valid, updates the password by hashing the new one.
     * - Returns back with a success message.
     * - If current password is incorrect, shows an error.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
