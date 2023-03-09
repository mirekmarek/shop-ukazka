<?php

namespace JetApplication;

use Jet\Data_Text;
use Jet\Data_Tree_Node;

class Category_MenuItem extends Data_Tree_Node
{
	
	public function getURL() : string
	{
		if($this->is_root) {
			return Application_Shop::getCatalogPage()->getURL();
			
		}
		
		return Application_Shop::getCatalogPage()->getURL(
			path_fragments: [$this->getURLPath()]
		);
	}
	
	public function getURLPath() : string
	{
		return str_replace(' ', '-', Data_Text::removeAccents( $this->label )).'-c-'.$this->id;
	}
	
}