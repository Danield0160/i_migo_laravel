<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Event extends Model
{

    protected $appends = [
        'asistentes',
        'tags'
    ];


    public function getAsistentesAttribute()
    {
        $count = DB::table('event_users')->where('event_id', $this->id)->count();
        return $count;
    }
    public function getTagsAttribute(){
        $tags = DB::table('event_tags')
        ->selectRaw('GROUP_CONCAT(event_tags.tag_id SEPARATOR ",") AS tags')
        ->where('event_id', $this->id)
        ->get()[0]->tags;
        return $tags;
    }



    use HasFactory;
    public static function obtainNearEvents($latCentral,$lngCentral,$distancia)
    {
        DB::select("SET sql_mode = '';");
        return self::select('events.*')
        // ->selectRaw('GROUP_CONCAT(event_tags.tag_id SEPARATOR ",") AS tags')
        // ->selectRaw('photos.imagePath as imagen')
        // ->selectRaw('GROUP_CONCAT(tags.category_name SEPARATOR ",") AS tags')
        ->selectRaw('1.6*3959 * ACOS(
            COS(RADIANS(lat)) * COS(RADIANS(?)) * COS(RADIANS(? - lng)) +
            SIN(RADIANS(lat)) * SIN(RADIANS(?))
        ) AS distancia', [$latCentral, $lngCentral, $latCentral ])
        // ->leftJoin("event_tags","events.id","=","event_tags.event_id")
        // ->leftJoin("photos","photos.id","=","imagen_id")
        // ->join("tags","tags.id", "=","event_tags.tag_id")
        ->havingRaw('distancia < ?',[$distancia])
        ->groupBy("events.id")
        ->get();
    }



    public static function obtainMyCreatedEvents(){
        return self::select("events.*")
        ->where("events.creator_id","=",Auth::user()->id)
        ->get();
    }

    public static function obtainMyJoinedEvents(){
        return self::select("events.*")
        ->rightJoin("event_users","events.id","=","event_users.event_id")
        ->where("event_users.user_id","=",Auth::user()->id)
        ->get();
    }

}
