<?php
namespace App\functions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Helper{
     public static function generateSlug(string $string, $model){
        $slug = Str::slug($string, '-');
        $original_slug = $slug;

        $exist = $model::where('slug', $slug)->first();

        $c = 1;
        while($exist){
            $slug = $original_slug.'-'.$c;
            $exist = $model::where('slug', $slug)->first();
            $c++;

        }
        return $slug;

    }
    public static function getDate($date){
        $date = date_create($date);
        return date_format($date, 'd/m/Y');
    }
}
