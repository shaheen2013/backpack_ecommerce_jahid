<?php
namespace App\Models\Traits;
use App\Scopes\UserDataList;

trait AddAuthUser{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserDataList);
        static::saving(function ($query) {
            $query->created_by = 3 ;
        });
    }
}
