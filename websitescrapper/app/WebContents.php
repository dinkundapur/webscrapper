<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebContents extends Model {

    protected $table = 'web_contents';
    protected $primaryKey = 'web_contents_id';



    //public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'image_urls'
    ];

    /**
     * Created By : Dinesh
     * Purpose    : Returns all the news items
     * Created on : May 24 2018 
     */
    public static function getAllTitles() {
        return WebContents::all();
    }

    /**
     * Created By : Dinesh
     * Purpose    : Returns content of only one news
     * Created on : May 24 2018 
     */
    public static function getContentById($id) {
        return WebContents::where('web_contents_id', $id)->pluck('content')->first();
    }

}
