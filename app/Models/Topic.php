<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'classroom_id', 'user_id'
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

    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class);
    }
}
