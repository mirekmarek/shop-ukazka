<?php
/**
 *
 * @copyright 
 * @license  
 * @author  
 */

namespace JetApplicationModule\Catalog\Admin\Categories;


use Jet\Data_Listing_Filter_Search;

class Listing_Filter_Search extends Data_Listing_Filter_Search {

	/**
	 *
	 */
	public function generateWhere(): void
	{
		if($this->search) {
			$search = '%'.$this->search.'%';
			$this->listing->addWhere([
				'internal_name *'   => $search,
			]);
		}
	}
}