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

        // return self::select('*')
        //     ->selectRaw('ACOS(SIN(RADIANS(lat)) * SIN(RADIANS(?)) + COS(RADIANS(lat)) * COS(RADIANS(?)) * COS(RADIANS(?) - lng)) * 6371 AS distancia', [$latCentral, $latCentral, $lngCentral])
        //     ->havingRaw('distancia < ?',[$distancia])
        //     ->get();

    return self::select('*')
    ->selectRaw('1.6*3959 * ACOS(
        COS(RADIANS(lat)) * COS(RADIANS(?)) * COS(RADIANS(? - lng)) +
        SIN(RADIANS(lat)) * SIN(RADIANS(?))
    ) AS distancia', [$latCentral, $lngCentral, $latCentral ])
    ->havingRaw('distancia < ?',[$distancia])
    ->get();
    }
}
//select nombre, lat, lng, abs(lat - 28.95)*111 as lat_distance, abs(lng - -13.58)*111 as lng_distance  from events where (abs(lat) - 29) <1 and (abs(lng) - 13) <1;

//select nombre, lat, lng, acos(sin(lat)*sin(28.9562)+cos(lat)*cos(28.9562)*cos(-13.5898-lng))*6371 as distancia from events where (abs(lat) - 29) <1 and (abs(lng ) - 13) <1;


// 3959*2*ATAN2(SQRT(1-(SIN((RADIANS(Latitude_2)-RADIANS(Latitude_1))/2)^2+COS(RADIANS(Latitude_1))*COS(RADIANS(Latitude_2))*SIN((RADIANS(Longitude_2)-RADIANS(Longitude_1))/2)^2)),SQRT(SIN((RADIANS(Latitude_2)-RADIANS(Latitude_1))/2)^2+COS(RADIANS(Latitude_1))*COS(RADIANS(Latitude_2))*SIN((RADIANS(Longitude_2)-RADIANS(Longitude_1))/2)^2))


// SELECT *, ( 3959 * acos( cos( radians(Lat1) ) * cos( radians( Lat2 ) ) * cos( radians(Lng2) - radians(Lng1) ) +
//      sin( radians(Lat1) ) * sin( radians(Lat2)))) AS distance FROM markers HAVING distance < 25 ORDER BY distance;