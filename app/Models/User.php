<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, HasLocalePreference
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    // protected function email()
    // {
    //     return Attribute::make(
    //         get: fn ($value) => strtoupper($value),
    //         set: fn ($value) => strtolower($value)
    //     );
    // }


    public function classrooms()
    {

        return $this->belongsToMany(
            Classroom::class,        // Related model
            'classroom_user',       // Pivot table
            'user_id',              // FK for current model in the pivot table
            'classroom_id',         // FK for related model in pivot table
            'id',                  // PK for current mode
            'id'                   // PK for related model
        )->withPivot(['role', 'created_at']);
    }

    public function createdClassrooms()
    {
        return $this->hasMany(Classroom::class, 'user_id');
    }

    public function classworks()
    {
        return $this->belongsToMany(Classwork::class)
            ->using(ClassworkUser::class)
            ->withPivot(['grade', 'status', 'submitted_at', 'created_at']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function receivedMessages()
    {
        return $this->morphMany(Message::class, 'recipient');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }


    // في حال كان عندي الايميل مش ستاندرد بضطر اعمل الفنكشن هاي
    // public function routeNotificationForMail($notification = null)
    // {
    //     return $this->email_address;
    // }
    public function routeNotificationForVonage($notification = null)
    {
        return '972592691590';
    }
    public function routeNotificationForHadara($notification = null)
    {
        return '972592691590';
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'Notifications.' . $this->id;
    }

    public function preferredLocale()
    {
        return $this->profile->locale;
    }
}
