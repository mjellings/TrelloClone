<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'board_id', 'name', 'content',
    ];

    /**
     * Get the board that the card belongs to.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
