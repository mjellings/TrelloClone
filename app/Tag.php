<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function card() {
        return $this->belongsToMany(Card::class);
    }
}
