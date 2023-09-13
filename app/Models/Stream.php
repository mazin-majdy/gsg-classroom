<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stream extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'classroom_id', 'user_id', 'content', 'link',
    ];

    protected static function booted()
    {

        // HasUuids trait بتغني عن السطرين هدول
        // static::creating(function (Stream $stream) {
        //     $stream->id = Str::uuid();
        // });
    }
    public function uniqueIds()
    {
        // في حال بدي استخدم uuid لكزا عمود بكتب اسماءهم هان
        return [
            'id'
        ];
    }

    public function getUpdatedAtColumn()
    {
    }


    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
