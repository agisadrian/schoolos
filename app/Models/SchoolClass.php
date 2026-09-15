<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(
            ClassMember::class,
            'class_id'
        );
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(
            Subject::class,
            'class_id'
        );
    }

    public function materials(): HasMany
    {
        return $this->hasMany(
            Material::class,
            'class_id'
        );
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(
            Assignment::class,
            'class_id'
        );
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(
            Schedule::class,
            'class_id'
        );
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(
            Announcement::class,
            'class_id'
        );
    }

    public function grades(): HasMany
    {
        return $this->hasMany(
            Grade::class,
            'class_id'
        );
    }
}