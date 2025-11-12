<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'stream_name',
        'property_id',
        'issue_date',
        'next_due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'date',
        'next_due_date' => 'date',
    ];


    public function notes()
    {
        return $this->morphMany(Note::class, 'model');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
