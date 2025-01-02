<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BgpRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'circuit_id',
        'circuit_speed',
        'request_status',
        'token',
        'router_table',
        'asn',
        'as_set',
        'multihop',
        'md5_session',
        'not_owner_as',
        'tech_name1',
        'tech_phone1',
        'tech_mail1',
        'tech_name2',
        'tech_phone2',
        'tech_mail2',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'multihop' => 'boolean',
        'not_owner_as' => 'boolean',
    ];

    public function prefixes(): HasMany
    {
        return $this->hasMany(Prefix::class);
    }
}
