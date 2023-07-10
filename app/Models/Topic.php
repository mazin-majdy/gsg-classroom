<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    /*
    Default Values
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $connection = 'mysql';

    protected $table = 'topics';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;
*/
    public $timestamps = false;
}
