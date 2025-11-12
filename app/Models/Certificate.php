<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function notes()
    {
        return $this->morphMany(Note::class, 'model');
    }
}
