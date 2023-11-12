<?php

namespace App\Http\Traits;

trait CommonQuery
{

    public static function getAllObjects()
    {
        return (new static)
            ->orderBy('created_at')
            ->get();
    }
}

