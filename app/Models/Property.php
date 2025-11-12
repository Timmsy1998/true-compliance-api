<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function notes()
    {
        return $this->morphMany(Note::class, 'model');
    }
}
