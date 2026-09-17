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
            ->approved()
            ->with('user')
            ->orderBy('role')
            ->orderBy('created_at')
            ->get();

        $pendingMembers = $class->members()
            ->pending()
            ->with('user')
            ->orderBy('created_at')
            ->get();

        $memberIds = $class->members()
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
                'pendingMembers',
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

        // Satu akun siswa hanya boleh terdaftar di 1 kelas.
        if ($validated['role'] === 'student') {
            $hasOtherClass = ClassMember::where(
                'user_id',
                $user->id
            )
                ->where('class_id', '!=', $class->id)
                ->exists();

            if ($hasOtherClass) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'user_id' =>
                            'Siswa ini sudah terdaftar di kelas ' .
                            'lain. Satu akun siswa hanya boleh ' .
                            'berada di 1 kelas.',
                    ]);
            }
        }

        ClassMember::create([
            'class_id' => $class->id,
            'user_id' => $user->id,
            'role' => $validated['role'],
            'status' => 'approved',
        ]);

        return redirect()
            ->route('members.index', $class)
            ->with(
                'success',
                'Anggota berhasil ditambahkan ke kelas.'
            );
    }

    public function approve(
        SchoolClass $class,
        ClassMember $member
    ) {
        if ($member->class_id !== $class->id) {
            abort(404);
        }

        // Pengaman tambahan: kalau ternyata siswa ini
        // sudah lebih dulu approved di kelas lain (misal
        // ada 2 pengajuan pending dari sebelum aturan
        // 1 siswa = 1 kelas berlaku), jangan sampai lolos.
        if ($member->role === 'student') {
            $approvedElsewhere = ClassMember::where(
                'user_id',
                $member->user_id
            )
                ->where('class_id', '!=', $class->id)
                ->where('status', 'approved')
                ->exists();

            if ($approvedElsewhere) {
                return back()->withErrors([
                    'member' =>
                        'Siswa ini sudah aktif di kelas lain. ' .
                        'Tolak dulu pengajuan ini kalau memang ' .
                        'ingin memindahkan siswa tersebut.',
                ]);
            }
        }

        $member->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('members.index', $class)
            ->with(
                'success',
                $member->user->name .
                ' berhasil disetujui bergabung ke kelas.'
            );
    }

    public function reject(
        SchoolClass $class,
        ClassMember $member
    ) {
        if ($member->class_id !== $class->id) {
            abort(404);
        }

        $name = $member->user->name;

        $member->delete();

        return redirect()
            ->route('members.index', $class)
            ->with(
                'success',
                'Permintaan gabung dari ' . $name . ' ditolak.'
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