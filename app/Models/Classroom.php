<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Observers\ClassroomObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    public static string $disk = 'public';
    protected $fillable = [
        'name', 'section', 'subject', 'room', 'theme', 'cover_image_path', 'code',

    ];

    // for accessor
    protected $appends = [
        'cover_image_url'
    ];

    protected $hidden = [
        'cover_image_path',
        'deleted_at'
    ];

    protected static function booted()
    {
        static::observe(ClassroomObserver::class);
        // static::addGlobalScope('user', function (Builder $query) {
        //     $query->where('classrooms.user_id', '=', Auth::id())->orWhereRaw('classrooms.id in (select classroom_id from classroom_user where user_id = ?)', [
        //         Auth::id()
        //     ]);
        //     // or exists(select 1 from classroom_user where classroom_id = classrooms.id and user_id = ?)
        // });

        // Listener
        // Creating, Created, Updating, Updated, Saving, Saved,
        // Deleting, Deleted, Restoring, Restored, ForceDeleting,
        // ForceDeleted, Retrieved
        // static::creating(function (Classroom $classroom) {
        //     $classroom->code = Str::random(8);
        //     $classroom->user_id = Auth::id();
        // });

        // static::forceDeleted(function(Classroom $classroom){
        //     static::deleteCoverImage($classroom->cover_image_path);
        // });

        // static::deleted(function(Classroom $classroom){
        //     $classroom->status = 'deleted';
        //     $classroom->save();
        // });

        // static::restored(function(Classroom $classroom){
        //     $classroom->status = 'active';
        //     $classroom->save();
        // });
    }

    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {

        return $this->belongsToMany(
            User::class,        // Related model
            'classroom_user',   // Pivot table
            'classroom_id',     // FK for current model in the pivot table
            'user_id',          // FK for related model in pivot table
            'id',               // PK for current mode
            'id'                // PK for related model
        )->withPivot(['role', 'created_at']);
    }

    public function teachers()
    {
        return $this->users()->wherePivot('role', '=', 'teacher');
    }

    public function students()
    {
        return $this->users()->wherePivot('role', '=', 'student');
    }

    public function streams()
    {
        return $this->hasMany(Stream::class)->latest();
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

    public function join($user_id, $role = 'student')
    {

        $exists = $this->users()->where('id', '=', $user_id)->exists();
        if ($exists) {
            throw new Exception('User already joined the classroom');
        }

        return $this->users()->attach($user_id, [
            'role' => $role,

            'created_at' => now(),
        ]); // INSERT

        // return  DB::table('classroom_user')->insert([
        //     'classroom_id' => $this->id,
        //     'user_id' => $user_id,
        //     'role' => $role,
        //     'created_at' => now()
        // ]);
    }

    // get{AttributeName}Attribute
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    // $classroom->cover_image_url
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image_path) {
            return Storage::disk('public')->url($this->cover_image_path);
        } else {
            return 'https://placehold.co/800x300';
        }
    }

    public function getUrlAttribute()
    {
        return route('classrooms.show', $this->id);
    }
}
