<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cronlogs extends Model
{
   	protected $table = 'cron_logs';
    protected $primaryKey = 'cron_logs_id';
   
    
    
    //public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'log_error',
    ];

	
}
