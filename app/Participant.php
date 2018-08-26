<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public function instructor() {
        return $this->belongsTo(Instructor::class);
    }
}
