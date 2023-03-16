<?php
/**
 * 
 */

namespace JetApplication;

use Jet\DataModel;
use Jet\DataModel_Definition;
use Jet\DataModel_IDController_Passive;
use Jet\DataModel_Related_1toN;
use Jet\DataModel_Query;

/**
 *
 */
#[DataModel_Definition(
	name: 'product_category',
	database_table_name: 'product_category',
	parent_model_class: Product::class,
	id_controller_class: DataModel_IDController_Passive::class,
	relation: [
		'related_to_class_name' => Category::class,
		'join_by_properties' => [
			'category_id' => 'id'
		],
		'join_type' => DataModel_Query::JOIN_TYPE_LEFT_OUTER_JOIN
	]
)]
class Product_Category extends DataModel_Related_1toN
{

	/**
	 * @var int
	 */ 
	#[DataModel_Definition(
		related_to: 'main.id',
		is_key: true
	)]
	protected int $product_id = 0;

	/**
	 * @var int
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_INT,
		is_id: true,
		is_key: true
	)]
	protected int $category_id = 0;

	/**
	 * @return string
	 */
	public function getArrayKeyValue() : string
	{
		return $this->category_id;
	}

	/**
	 * @return int
	 */
	public function getProductId() : int
	{
		return $this->product_id;
	}

	/**
	 * @param int $value
	 */
	public function setCategoryId( int $value ) : void
	{
		$this->category_id = $value;
	}

	/**
	 * @return int
	 */
	public function getCategoryId() : int
	{
		return $this->category_id;
	}
	
	public function __toString(): string
	{
		return $this->category_id;
	}
}
