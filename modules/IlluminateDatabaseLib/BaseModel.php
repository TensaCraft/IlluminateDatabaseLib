<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class BaseModel extends Model
{
    /**
     * Set Carbon locale on boot.
     */
    protected static function booted(): void
    {
        parent::booted();
        Carbon::setLocale(defined('HTML_LANG') ? HTML_LANG : 'en');
    }

    public function created_ago(?string $column = 'created_at'): string
    {
        $date = $this->{$column};
        if (!$date instanceof Carbon) {
            try {
                $date = Carbon::parse($date);
            } catch (\Exception $e) {
                return '';
            }
        }
        return $date->diffForHumans();
    }

    public function updated_ago(?string $column = 'updated_at'): string
    {
        $date = $this->{$column};
        if (!$date instanceof Carbon) {
            try {
                $date = Carbon::parse($date);
            } catch (\Exception $e) {
                return '';
            }
        }
        return $date->diffForHumans();
    }
}
