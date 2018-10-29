<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];


    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsToMany(User::class)->withPivot('is_owner', 'can_write')->withTimestamps();
    }

    /**
     * Get all of the cards for the board.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
