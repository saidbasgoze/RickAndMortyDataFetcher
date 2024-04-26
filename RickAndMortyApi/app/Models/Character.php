<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location;  
use App\Models\Episode;   

class Character extends Model
{

    //To get more than one data.(mass assignable)
    protected $fillable = ['id', 'name', 'status', 'species', 'type', 'gender', 'image', 'origin_id', 'location_id', 'url', 'created'];

    public function origin()
    {
        //One to Many relationship with Location table
        return $this->belongsTo(Location::class, 'origin_id');
    }

    public function location()
    {
        //One to Many relationship with Location table
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function episodes()
    {
        //Many to Many relationship with Episode table
        return $this->belongsToMany(Episode::class);
    }
}