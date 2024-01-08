<?php
namespace App\Http\Traits;

use Carbon\Carbon;


trait Date
{
    public static function excerptDate(Carbon $date): string
    {
        list($excerpt_date, $_) = preg_split('/ /', $date);
        $excerpt_date = preg_replace('/-/', '/', $excerpt_date);
        return $excerpt_date;
    }
}
?>