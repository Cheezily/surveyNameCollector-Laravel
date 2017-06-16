<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function universities() {
      return $this->hasMany(University::class);
    }

    public function instructors() {
      return $this->hasMany(Instructor::class);
    }

    public function participants() {
      return $this->hasManyThrough(Participant::class, Instructor::class);
    }
}
