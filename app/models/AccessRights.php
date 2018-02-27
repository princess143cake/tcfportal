<?php

/**
* Outbound Model
*/
class AccessRights extends Eloquent
{
    protected $table = 'access_rights';

    public $timestamps = false;

    protected $fillable = ['id',
                           'title',
                           'action'];
}
