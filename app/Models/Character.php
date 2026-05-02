<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id', 'name', 'class_type', 'backstory', 'base_health', 'is_alive'
    ];

    // The Relationship: A Character belongs to a Game
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
