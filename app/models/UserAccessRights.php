<?php

/**
* Outbound Model
*/
class UserAccessRights extends Eloquent
{
    protected $table = 'user_access_rights';

    public $timestamps = false;

    protected $fillable = ['action_rights_id',
                           'user_id',
                           'grant'];
}
