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
      return $this->hasManyThrough(Instructor::class, University::class);
    }

    public function participants() {
      $participants = [];
      $instructors = $this->instructors();

      foreach($instructors as $instructor) {
        $participants[] = $instructor->participants;
      }
      
      return $participants;
      //return $this->hasManyThrough(Participant::class, Instructor::class);
    }
}
