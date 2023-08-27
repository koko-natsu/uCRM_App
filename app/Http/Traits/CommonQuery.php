<?php

namespace App\Http\Traits;

trait CommonQuery
{

    public static function getAllObjects()
    {
        return (new static)
            ->orderByDesc('created_at')
            ->get();
    }
}

