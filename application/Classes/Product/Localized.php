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
	name: 'product_localized',
	database_table_name: 'product_localized',
	parent_model_class: Product::class,
	id_controller_class: DataModel_IDController_Passive::class
)]
class Product_Localized extends DataModel_Related_1toN
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
	 * @var ?Locale
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_LOCALE,
		is_id: true,
		is_key: true
	)]
	protected ?Locale $locale = null;
	
	/**
	 * @var bool
	 */
	#[DataModel_Definition(
		type: DataModel::TYPE_BOOL,
		is_key: true
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_CHECKBOX
	)]
	protected bool $is_active = false;

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Název:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte'
		]
	)]
	protected string $name = '';

	/**
	 * @var string
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 9999999
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_WYSIWYG,
		label: 'Popis:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $description = '';

	/**
	 * @var float
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_FLOAT,
		is_key: true
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_FLOAT,
		label: 'Cena:',
		is_required: false,
		error_messages: [
		]
	)]
	protected float $price = 0.0;

	/**
	 * @var float
	 */ 
	#[DataModel_Definition(
		type: DataModel::TYPE_FLOAT
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_SELECT,
		label: 'Sazba DPH:',
		is_required: false,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím vyberte',
			Form_Field::ERROR_CODE_INVALID_VALUE => 'Prosím vyberte'
		]
	)]
	protected float $vat_rate = 0.0;

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
	public function getProductId() : int
	{
		return $this->product_id;
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
	public function setName( string $value ) : void
	{
		$this->name = $value;
	}

	/**
	 * @return string
	 */
	public function getName() : string
	{
		return $this->name;
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

	/**
	 * @param bool $value
	 */
	public function setIsActive( bool $value ) : void
	{
		$this->is_active = $value;
	}

	/**
	 * @return bool
	 */
	public function getIsActive() : bool
	{
		return $this->is_active;
	}

	/**
	 * @param float $value
	 */
	public function setPrice( float $value ) : void
	{
		$this->price = $value;
	}

	/**
	 * @return float
	 */
	public function getPrice() : float
	{
		return $this->price;
	}

	/**
	 * @param float $value
	 */
	public function setVatRate( float $value ) : void
	{
		$this->vat_rate = $value;
	}

	/**
	 * @return float
	 */
	public function getVatRate() : float
	{
		return $this->vat_rate;
	}
}
