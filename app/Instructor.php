<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{


    public function survey() {
      return $this->belongsTo(Survey::class);
    }


    public function university() {
      return $this->belongsTo(University::class);
    }


    public function participants() {
      return $this->hasMany(Participant::class);
    }
}
