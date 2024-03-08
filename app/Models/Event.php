<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public static function obtenerEventosCercanos($latCentral,$lngCentral,$distancia)
    {
        // $latCentral = 28.9562;
        // $lngCentral = -13.5898;

        return self::select('nombre', 'lat', 'lng')
            ->selectRaw('ACOS(SIN(lat) * SIN(?) + COS(lat) * COS(?) * COS(? - lng)) * 6371 AS distancia', [$latCentral, $latCentral, $lngCentral])
            ->havingRaw('distancia < ?',[$distancia])
            ->get();
    }
}
//select nombre, lat, lng, abs(lat - 28.95)*111 as lat_distance, abs(lng - -13.58)*111 as lng_distance  from events where (abs(lat) - 29) <1 and (abs(lng) - 13) <1;

//select nombre, lat, lng, acos(sin(lat)*sin(28.9562)+cos(lat)*cos(28.9562)*cos(-13.5898-lng))*6371 as distancia from events where (abs(lat) - 29) <1 and (abs(lng ) - 13) <1;