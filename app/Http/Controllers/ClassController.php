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

        $alreadyMember = $class->members()
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyMember) {
            return redirect()
                ->route('classes.show', $class)
                ->with(
                    'success',
                    'Anda sudah menjadi anggota kelas ini.'
                );
        }


        ClassMember::create([
            'class_id' => $class->id,
            'user_id' => $user->id,
            'role' => $user->role,
        ]);


        return redirect()
            ->route('classes.show', $class)
            ->with(
                'success',
                'Berhasil bergabung ke kelas ' . $class->name . '.'
            );
    }
}