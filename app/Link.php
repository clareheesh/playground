<?php

namespace App;

class Link extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label', 'url'
    ];

    public function link() {
        return $this->belongsTo('App\Doll');
    }
}
