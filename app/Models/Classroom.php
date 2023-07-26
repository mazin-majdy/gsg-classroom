<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    public static string $disk = 'public';
    protected $fillable = [
        'name', 'section', 'subject', 'room', 'theme', 'cover_image_path', 'code',

    ];

    protected static function booted()
    {
        static::addGlobalScope('user', function (Builder $query) {
            $query->where('user_id', '=', Auth::id());
        });

    }

    // default
    public function getRouteKeyName()
    {
        return 'id';
    }
    public static function uploadCoverImage($file)
    {
        $path = $file->store('/covers', [
            'disk' => 'public'
        ]);
        return $path;
    }
    public static function deleteCoverImage($path)
    {
        if ($path && Storage::disk(Classroom::$disk)->exists($path)) {
            return Storage::disk(Classroom::$disk)->delete($path);
        }
    }

    // local scopes

    public function scopeActive(Builder $query)
    {
        $query->where('status', '=', 'active');
    }

    public function scopeRecent(Builder $query)
    {
        $query->orderBy('updated_at', 'DESC');
    }

    public function scopeStatus(Builder $query, $status)
    {
        $query->where('status', '=', $status);
    }
}
