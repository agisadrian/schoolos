<?php

namespace App\Http\Controllers;

use App\Models\ClassMember;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = SchoolClass::query();

        /*
        |--------------------------------------------------------------------------
        | Batasi kelas berdasarkan role
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'admin') {
            $query->whereHas(
                'members',
                function ($memberQuery) use ($user) {
                    $memberQuery->where(
                        'user_id',
                        $user->id
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($classQuery) use ($search) {
                $classQuery
                    ->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'code',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Data kelas
        |--------------------------------------------------------------------------
        */

        $classes = $query
            ->with([
                'members' => function ($memberQuery) use ($user) {
                    $memberQuery->where('user_id', $user->id);
                },
            ])
            ->withCount([
                'members',
                'subjects',
                'assignments',
                'announcements',
            ])
            ->latest()
            ->paginate(9)
            ->withQueryString();


        return view(
            'classes.index',
            compact('classes')
        );
    }


    public function show(SchoolClass $class)
    {
        $class->load([
            'members.user',
        ]);

        return view(
            'classes.show',
            compact('class')
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:100',
                'unique:school_classes,code',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);


        SchoolClass::create($validated);


        return redirect()
            ->route('classes.index')
            ->with(
                'success',
                'Kelas berhasil dibuat.'
            );
    }


    public function showJoin()
    {
        return view('classes.join');
    }


    public function join(Request $request)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:100',
            ],
        ]);


        $class = SchoolClass::whereRaw(
            'UPPER(code) = ?',
            [strtoupper(trim($validated['code']))]
        )->first();

        if (!$class) {
            return back()
                ->withInput()
                ->withErrors([
                    'code' =>
                        'Kode kelas tidak ditemukan.',
                ]);
        }


        $user = Auth::user();

        $existingMembership = $class->members()
            ->where('user_id', $user->id)
            ->first();

        if ($existingMembership) {
            if ($existingMembership->status === 'pending') {
                return redirect()
                    ->route('classes.index')
                    ->with(
                        'success',
                        'Permintaan gabung kamu ke kelas ' .
                        $class->name .
                        ' masih menunggu persetujuan admin/guru.'
                    );
            }

            return redirect()
                ->route('classes.show', $class)
                ->with(
                    'success',
                    'Anda sudah menjadi anggota kelas ini.'
                );
        }


        // Satu akun siswa hanya boleh terdaftar
        // (atau sedang mengajukan) di 1 kelas saja.
        // Guru dan admin boleh berada di banyak kelas.
        if ($user->role === 'student') {
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
                        'code' =>
                            'Akun siswa hanya boleh terdaftar di ' .
                            '1 kelas. Kamu sudah tergabung atau ' .
                            'sedang mengajukan di kelas lain.',
                    ]);
            }
        }


        ClassMember::create([
            'class_id' => $class->id,
            'user_id' => $user->id,
            'role' => $user->role,
            'status' => 'pending',
        ]);


        return redirect()
            ->route('classes.index')
            ->with(
                'success',
                'Permintaan gabung kelas ' . $class->name .
                ' berhasil dikirim. Menunggu persetujuan ' .
                'admin/guru sebelum kamu bisa mengakses kelas ini.'
            );
    }
}