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

      $universities = University::with(['instructors', 'instructors.participants'])
        ->where('survey_id', $this->id)->get();
      
      foreach($universities as $university) {
        foreach($university->instructors as $instructor) {
          foreach($instructor->participants as $participant) {
            $participants[] = $participant;
          }
        } 
      }

      return $participants;
    }
}
