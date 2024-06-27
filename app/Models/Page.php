<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Page extends Model
{

    protected $translatable = ['title', 'slug', 'body'];

    /**
     * Statuses.
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * List of statuses.
     *
     * @var array
     */
    public static $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $guarded = [];

    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->author_id && Auth::user()) {
            $this->author_id = Auth::user()->getKey();
        }

        return parent::save();
    }


    /**
     * Scope a query to only include active pages.
     *
     * @param  $query  \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     *
    public function scopeActive($query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    } */

    public function get_meta_title() {
    	if ($this->metatitle) return $this->metatitle;
    	$title=setting('site.title');
    	if ($this->title) 
    	$title .= " - ".ucfirst(strtolower(str_replace("|"," ",strip_tags($this->title))));
    	return $title;
    }
    
    public function get_meta_description() {
    	if ($this->meta_description) return $this->meta_description;
    	$body=setting('site.description');
    	return strip_tags($body);
    }        
    
    public function get_meta_keywords() {
    	if ($this->meta_keywords) return $this->meta_keywords;
    	$body=setting('site.keywords');
    	return strip_tags($body);
    }           
    
}