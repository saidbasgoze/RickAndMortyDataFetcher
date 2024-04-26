<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

   //To get more than one data.(mass assignable)
   protected $fillable = ['id', 'name', 'air_date', 'episode', 'created'];

   
    public function characters()
    {
        //Many to Many relationship with Character table.These two creates third table.
        
        return $this->belongsToMany(Character::class);
    }
}