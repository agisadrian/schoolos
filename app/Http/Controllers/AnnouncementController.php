<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(SchoolClass $class)
    {
        $announcements = $class->announcements()
            ->with('creator')
            ->latest('published_at')
            ->latest()
            ->get();

        return view(
            'announcements.index',
            compact(
                'class',
                'announcements'
            )
        );
    }

    public function create(SchoolClass $class)
    {
        return view(
            'announcements.create',
            compact('class')
        );
    }

    public function store(
        Request $request,
        SchoolClass $class
    ) {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],
        ]);

        Announcement::create([
            'class_id' => $class->id,

            'created_by' => Auth::id(),

            'title' => $validated['title'],

            'content' => $validated['content'],

            'published_at' =>
                $validated['published_at']
                ?? now(),
        ]);

        return redirect()
            ->route(
                'announcements.index',
                $class
            )
            ->with(
                'success',
                'Pengumuman berhasil dibuat.'
            );
    }

    public function show(
        SchoolClass $class,
        Announcement $announcement
    ) {
        abort_unless(
            $announcement->class_id === $class->id,
            404
        );

        $announcement->load('creator');

        return view(
            'announcements.show',
            compact(
                'class',
                'announcement'
            )
        );
    }
}
