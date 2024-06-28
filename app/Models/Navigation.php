<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Nestable;

class Navigation extends Model
{
    use Nestable;
    protected $parentField = 'parent_id';    

    public function parentId()
    {
        return $this->belongsTo(self::class);      
    }   
    
    public static function menu($prefix,$parent=NULL)
    {
		$menu[0]=self::select('*', 'title'.$prefix.' as title')
			->where('parent_id', $parent)
			->orderBy('ordernum', 'asc')
			->get();
			
		foreach ($menu[0] as $row)
		{
			$menu[$row->id]=self::select('*', 'title'.$prefix.' as title')
			->where('parent_id', $row->id)
			->orderBy('ordernum', 'asc')
			->get();			
		}	
		
		return $menu;
    } 
    
    public function isactive($activemenu,$subitems=false) 
    {
		
		if ($activemenu)
		{
			if ($activemenu['active']->id==$this->id)
				return true;

        	if($subitems) 
        	{	
				foreach ($subitems as $row2)
					if ($row2->isactive($activemenu)) return true; 
            	return false;
        	}  			
			
			return false;	
		}


		return false;
    }  
    
    
    public static function activemenu($page_id,$prefix,$menu_id=0)
    {
		if ($menu_id)
		{
			$out['active'] = self::select('id','parent_id','ordernum','title','image','imagemobile')
			->where('id', $menu_id)
			->first();		
		}
		elseif ($page_id)
		{
			$out['active'] = self::select('id','parent_id','ordernum','title','image','imagemobile')
			->where('page_id', $page_id)
			->first();
		}
		else
		{
			$url = parse_url($_SERVER['REQUEST_URI']);
			$urlarr=explode("/",$url['path']);
			if (count($urlarr)<2) $urlarr[1]='home';	
			if (!$urlarr[1]) return false;

			$out['active'] = self::select('id','parent_id','ordernum','title','image','imagemobile')
			->where('url', $urlarr[1])
			->whereNull('page_id')
			->first();
			
		}
		if (!$out['active']) return false;

		/*
		if ($out['active']->parent_id)
		{
			$page = self::select('title')
			->where('id', $out['active']->parent_id)
			->first();

			$pages = self::select('id')
			->where('parent_id', $out['active']->parent_id)->orderby('order')
			->get();
			
			$out['totals']=count($pages);
			$out['activepage']=0;
			$j=-1;
			foreach($pages as $pag)
			{
				$j++;
				if ($pag->id==$out['active']->id) $out['activepage']=$j;
			}

			$out['toptitle']=$page->title;
			
			//next
			$nextitem=self::where('order','>',$out['active']->order)->where('parent_id',$out['active']->parent_id)->orderby('order')->first();
			if (!$nextitem)
				$nextitem=self::where('parent_id',$out['active']->parent_id)->orderby('order')->first();

			if ($nextitem)
				$out['next']=$nextitem->getItemUrl();

			//before
			$beforeitem=self::where('order','<',$out['active']->order)->where('parent_id',$out['active']->parent_id)->orderby('order','desc')->first();
			if (!$beforeitem) $beforeitem=self::where('parent_id',$out['active']->parent_id)->orderby('order','desc')->first();
		
			if ($beforeitem)
				$out['before']=$beforeitem->getItemUrl();			
			
		}
		*/
		
		return $out;
    	
    }  
    
    public function pages()
    {
           return $this->hasOne('App\Page', 'id', 'page_id');
    }       
    
    
    public function getItemUrl($locale='nl') {

        if ($this->pages() && $this->pages()->first()) {
            $pg=$this->pages()->first();
            return "/".$pg->slug;
        } elseif ($this->url) {
            $url = $this->url;
            if (!$this->new_window) $url="/".$url;
            return $url;
        } else {

            return '';
        }
    }    
    
}
