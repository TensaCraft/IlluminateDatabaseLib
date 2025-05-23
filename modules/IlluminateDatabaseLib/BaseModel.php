<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class BaseModel extends Model
{
    protected static function booted(): void
    {
        parent::booted();
        static::automaticallyEagerLoadRelationships();
        Carbon::setLocale(defined('LANGUAGE') ? LANGUAGE : 'en_UK');
    }
}
