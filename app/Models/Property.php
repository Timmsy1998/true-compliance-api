<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organisation',
        'property_type',
        'parent_property_id',
        'uprn',
        'address',
        'town',
        'postcode',
        'live',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'live' => 'boolean',
    ];

    public function notes()
    {
        return $this->morphMany(Note::class, 'model');
    }

    public function parentProperty()
    {
        return $this->belongsTo(Property::class, 'parent_property_id');
    }

    public function childProperties()
    {
        return $this->hasMany(Property::class, 'parent_property_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
