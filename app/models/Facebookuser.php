<?php

class Facebookuser extends Eloquent{

	protected $table = 'facebookusers';

     public function facebookprofiles()
    {
        return $this->hasMany('Facebookprofile');
    }
}

?>