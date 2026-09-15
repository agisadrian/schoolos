<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($query) use ($search) {
                $query->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $search . '%'
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Role
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('role') &&
            in_array(
                $request->role,
                [
                    'student',
                    'teacher',
                    'admin',
                ]
            )
        ) {
            $query->where(
                'role',
                $request->role
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'users.index',
            compact('users')
        );
    }


    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'role' => [
                'required',
                Rule::in([
                    'student',
                    'teacher',
                    'admin',
                ]),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        User::create([
            'name' => $validated['name'],

            'email' => strtolower(
                trim($validated['email'])
            ),

            'role' => $validated['role'],

            'password' => Hash::make(
                $validated['password']
            ),
        ]);


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Akun berhasil dibuat.'
            );
    }


    public function edit(User $user)
    {
        return view(
            'users.edit',
            compact('user')
        );
    }


    public function update(
        Request $request,
        User $user
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'users',
                    'email'
                )->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'student',
                    'teacher',
                    'admin',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        $user->name =
            $validated['name'];

        $user->email =
            strtolower(
                trim($validated['email'])
            );

        $user->role =
            $validated['role'];


        if (
            !empty(
                $validated['password']
            )
        ) {
            $user->password =
                Hash::make(
                    $validated['password']
                );
        }


        $user->save();


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Akun berhasil diperbarui.'
            );
    }


    public function destroy(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent Self Delete
        |--------------------------------------------------------------------------
        */

        if ($user->id === Auth::id()) {
            return back()
                ->withErrors([
                    'user' =>
                        'Anda tidak dapat menghapus akun sendiri.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Deleting User With Class Membership
        |--------------------------------------------------------------------------
        */

        if (
            $user->classMembers()->exists()
        ) {
            return back()
                ->withErrors([
                    'user' =>
                        'User tidak dapat dihapus karena masih terdaftar di kelas.',
                ]);
        }


        $user->delete();


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Akun berhasil dihapus.'
            );
    }
}