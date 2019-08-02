<?php

class Facebookprofile extends Eloquent {

	protected $table = 'facebookprofiles';

    public function facebookuser()
    {
        return $this->belongsTo('Facebookuser');
    }
}