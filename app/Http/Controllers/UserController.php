<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['admin', 'voter'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['admin', 'voter'])],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function loginAs(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Store original admin ID in session if needed (optional)
        session(['admin_id' => auth()->id()]);

        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'You are now logged in as ' . $user->name);
    }

    public function downloadTemplate()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=user_import_template.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Name', 'Email', 'Role', 'Password'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Sample row
            fputcsv($file, ['John Doe', 'john@example.com', 'voter', 'password123']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $filePath = $file->getRealPath();

        $fileHandle = fopen($filePath, 'r');
        $header = fgetcsv($fileHandle); // Skip header

        $importedCount = 0;
        $errors = [];

        while (($row = fgetcsv($fileHandle)) !== FALSE) {
            if (count($row) < 4)
                continue;

            $name = $row[0];
            $email = $row[1];
            $role = strtolower($row[2]);
            $password = $row[3];

            // Basic validation for role
            if (!in_array($role, ['admin', 'voter'])) {
                $role = 'voter';
            }

            // Check if user already exists
            if (User::where('email', $email)->exists()) {
                $errors[] = "User with email {$email} already exists.";
                continue;
            }

            try {
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'role' => $role,
                    'password' => Hash::make($password),
                ]);
                $importedCount++;
            } catch (\Exception $e) {
                $errors[] = "Error importing {$email}: " . $e->getMessage();
            }
        }

        fclose($fileHandle);

        $message = "Successfully imported {$importedCount} users.";
        if (count($errors) > 0) {
            $message .= " Encounered " . count($errors) . " errors.";
            return redirect()->route('admin.users.index')->with('success', $message)->with('import_errors', $errors);
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }
}
