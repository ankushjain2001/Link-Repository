<?php

class Metadata extends Eloquent {

    protected $table = 'metadatas';
    protected $fillable = array('link','heading','category','description','photo','counter');

}