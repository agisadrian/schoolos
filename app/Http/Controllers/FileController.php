<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Material;
use App\Models\SchoolClass;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function material(
        SchoolClass $class,
        Material $material
    ) {
        if ($material->class_id !== $class->id) {
            abort(404);
        }

        if (!$material->file_path) {
            abort(404);
        }

        return $this->downloadFile(
            $material->file_path,
            $material->file_name
        );
    }

    public function assignment(
        SchoolClass $class,
        Assignment $assignment
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        if (!$assignment->file_path) {
            abort(404);
        }

        return $this->downloadFile(
            $assignment->file_path,
            $assignment->file_name
        );
    }

    public function submission(
        SchoolClass $class,
        Assignment $assignment,
        Submission $submission
    ) {
        if ($assignment->class_id !== $class->id) {
            abort(404);
        }

        if ($submission->assignment_id !== $assignment->id) {
            abort(404);
        }

        if (
            Auth::user()->role === 'student' &&
            $submission->user_id !== Auth::id()
        ) {
            abort(403);
        }

        if (!$submission->file_path) {
            abort(404);
        }

        return $this->downloadFile(
            $submission->file_path,
            $submission->file_name
        );
    }

    private function downloadFile(
        string $path,
        ?string $fileName
    ) {
        $disk = Storage::disk('public');

        if (!$disk->exists($path)) {
            abort(404);
        }

        $fullPath = $disk->path($path);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        return response()->download(
            $fullPath,
            $fileName ?: basename($path)
        );
    }
}