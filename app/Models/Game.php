<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    // This protects our database by only allowing these specific columns to be written to
    protected $fillable = ['title', 'studio_name', 'status', 'cover_image'];

    // The Relationship: A Game has many Characters
    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}
