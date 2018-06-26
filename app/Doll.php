<?php

namespace App;

class Doll extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The custom attributes that should be accessible on the model.
     *
     * @var array
     */
    protected $appends = ['remaining'];

    /**
     * Get all of the links attached to a doll
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function links()
    {
        return $this->hasMany('App\Link');
    }


    /**
     * Get the difference between the actual and ideal stock, to calculate how many dolls are remaining
     *
     * @return int|mixed
     */
    public function getRemainingAttribute() {
        return $this->ideal > $this->stock ? $this->ideal - $this->stock : 0;
    }

}
