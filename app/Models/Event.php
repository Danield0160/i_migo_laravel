<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;

    public static function obtenerEventosCercanos($latCentral,$lngCentral,$distancia)
    {
        DB::select("SET sql_mode = '';");
    return self::select('events.*')
    ->selectRaw('GROUP_CONCAT(event_tags.id_tag SEPARATOR ",") AS tags')
    ->selectRaw('photos.ruta as imagen')
    // ->selectRaw('GROUP_CONCAT(tags.categoria SEPARATOR ",") AS tags')
    ->selectRaw('1.6*3959 * ACOS(
        COS(RADIANS(lat)) * COS(RADIANS(?)) * COS(RADIANS(? - lng)) +
        SIN(RADIANS(lat)) * SIN(RADIANS(?))
    ) AS distancia', [$latCentral, $lngCentral, $latCentral ])
    ->leftJoin("event_tags","events.id","=","event_tags.id_evento")
    ->leftJoin("photos","photos.id","=","imagen_id")
    // ->join("tags","tags.id", "=","event_tags.id_tag")
    ->havingRaw('distancia < ?',[$distancia])
    ->groupBy("events.id")
    ->get();
    }
}
