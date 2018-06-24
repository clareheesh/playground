<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Validator;

class Model extends Eloquent
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The validation rules for this model.
     *
     * @var array
     */
    protected $rules = [];

    private $errors;

    public function validate($data) {
        $valid = Validator::make($data, $this->rules);

        if($valid->fails()) {
            $this->errors = $valid->errors();
            return false;
        }

        return true;
    }

    public function errors() {
        return $this->errors;
    }

}
