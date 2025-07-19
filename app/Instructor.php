<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    public function university() {
      return $this->belongsTo(University::class);
    }

    public function participants() {
      return $this->hasMany(Participant::class);
    }
}
