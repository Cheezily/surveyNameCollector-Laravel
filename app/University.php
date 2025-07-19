<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    public function instructors() {
      return $this->hasMany(Instructor::class);
    }

    public function survey() {
      return $this->belongsTo(Survey::class);
    }
}
