<?php
/**
 * 
 */

namespace JetApplication;

use Jet\DataModel;
use Jet\DataModel_Definition;
use Jet\DataModel_IDController_Passive;
use Jet\DataModel_Related_1toN;
use Jet\Locale;
use Jet\Form_Field;
use Jet\Form_Definition;

/**
 *
 */
#[DataModel_Definition(
	name: 'category_localized',
	database_table_name: 'category_localized',
	parent_model_class: Category::class,
	id_controller_class: DataModel_IDController_Passive::class
)]
class Category_Localized extends DataModel_Related_1toN
{

	/**
	 * @var int
	 */ 
	#[DataModel_Definition(
		related_to: 'main.id',
		is_key: true
	)]
	protected int $category_id = 0;

	/**
	 * @var ?Locale
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_LOCALE,
		is_id: true,
		is_key: true
	)]
	protected ?Locale $locale = null;

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Titulek:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte',
			Form_Field::ERROR_CODE_INVALID_FORMAT => 'Prosím zadejte'
		]
	)]
	protected string $title = '';

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 9999999
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_TEXTAREA,
		label: 'Popis:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $description = '';

	/**
	 * @return string
	 */
	public function getArrayKeyValue() : string
	{
		return $this->locale->toString();
	}

	/**
	 * @return int
	 */
	public function getCategoryId() : int
	{
		return $this->category_id;
	}

	/**
	 * @param Locale|string $value
	 */
	public function setLocale( Locale|string $value ) : void
	{
		if( !( $value instanceof Locale ) ) {
			$value = new Locale( (string)$value );
		}
		
		$this->locale = $value;
	}

	/**
	 * @return Locale
	 */
	public function getLocale() : Locale
	{
		return $this->locale;
	}

	/**
	 * @param string $value
	 */
	public function setTitle( string $value ) : void
	{
		$this->title = $value;
	}

	/**
	 * @return string
	 */
	public function getTitle() : string
	{
		return $this->title;
	}

	/**
	 * @param string $value
	 */
	public function setDescription( string $value ) : void
	{
		$this->description = $value;
	}

	/**
	 * @return string
	 */
	public function getDescription() : string
	{
		return $this->description;
	}
}
