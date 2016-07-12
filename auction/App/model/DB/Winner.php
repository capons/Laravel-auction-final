<?php

namespace App\model\DB;


use Illuminate\Database\Eloquent\Model;

class Winner extends Model {

    public $timestamps = false;
    public $table = 'winners';
    protected $fillable = array('promise_id','bid','winner_id','if_email');

}