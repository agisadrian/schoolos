<?php

namespace App\Http\Middleware;

use App\Models\SchoolClass;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassAccessMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        $class = $request->route('class');

        if (!$class instanceof SchoolClass) {
            abort(404);
        }

        // Admin boleh mengakses semua kelas.
        if ($user->role === 'admin') {
            return $next($request);
        }

        // User biasa hanya boleh mengakses kelas
        // jika dirinya terdaftar sebagai anggota kelas
        // DAN keanggotaannya sudah disetujui (approved).
        $membership = $class->members()
            ->where('user_id', $user->id)
            ->first();

        if (!$membership) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        if ($membership->status === 'pending') {
            abort(
                403,
                'Permintaan gabung kelas kamu masih menunggu ' .
                'persetujuan admin/guru.'
            );
        }

        return $next($request);
    }
}