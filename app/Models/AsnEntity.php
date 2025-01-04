<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsnEntity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'bgp_request_id',
        'asn',
        'as_set',
        'tech_name',
        'tech_phone',
        'tech_mail',
        'asn_entity_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'bgp_request_id' => 'integer',
        'asn' => 'integer',
        'asn_entity_id' => 'integer',
    ];

    public function asnEntity(): BelongsTo
    {
        return $this->belongsTo(AsnEntity::class);
    }

    public function bgpRequest(): BelongsTo
    {
        return $this->belongsTo(BgpRequest::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AsnEntity::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(AsnEntity::class, 'parent_id');
    }

    public function prefixes(): HasMany
    {
        return $this->hasMany(Prefix::class);
    }
}
