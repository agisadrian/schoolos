<?php

namespace App\Http\Controllers;

use App\Models\ClassMember;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassMemberController extends Controller
{
    public function index(SchoolClass $class)
    {
        $members = $class->members()
            ->with('user')
            ->orderBy('role')
            ->orderBy('created_at')
            ->get();

        $memberIds = $members
            ->pluck('user_id')
            ->toArray();

        $users = User::whereNotIn('id', $memberIds)
            ->orderBy('name')
            ->get();

        return view(
            'members.index',
            compact(
                'class',
                'members',
                'users'
            )
        );
    }

    public function store(
        Request $request,
        SchoolClass $class
    ) {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'role' => [
                'required',
                Rule::in([
                    'student',
                    'teacher',
                    'admin',
                ]),
            ],
        ]);

        $user = User::findOrFail(
            $validated['user_id']
        );

        // Satu user tidak boleh masuk kelas
        // lebih dari satu kali.
        $alreadyMember = $class->members()
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyMember) {
            return back()
                ->withInput()
                ->withErrors([
                    'user_id' =>
                        'User tersebut sudah menjadi anggota kelas.',
                ]);
        }

        // Role kelas harus konsisten
        // dengan role utama user.
        if ($validated['role'] !== $user->role) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' =>
                        'Role kelas harus sama dengan role akun user.',
                ]);
        }

        ClassMember::create([
            'class_id' => $class->id,
            'user_id' => $user->id,
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('members.index', $class)
            ->with(
                'success',
                'Anggota berhasil ditambahkan ke kelas.'
            );
    }

    public function destroy(
        SchoolClass $class,
        ClassMember $member
    ) {
        // Pastikan member benar-benar milik kelas
        // yang sedang dibuka.
        if ($member->class_id !== $class->id) {
            abort(404);
        }

        $member->delete();

        return redirect()
            ->route('members.index', $class)
            ->with(
                'success',
                'Anggota berhasil dihapus dari kelas.'
            );
    }
}