<?php
namespace JetApplication;

use Jet\Data_DateTime;
use Jet\DataModel;
use Jet\DataModel_Definition;
use Jet\DataModel_IDController_AutoIncrement;
use Jet\Form_Definition;
use Jet\Form_Field;
use Jet\Locale;
use JetApplication\Order\Traits\Order_Traits_DeliveryMethods;
use JetApplication\Order\Traits\Order_Traits_PaymentMethods;
use JetApplication\Order\Traits\Order_Traits_Process;


#[DataModel_Definition(
	name: 'order',
	database_table_name: 'orders',
	id_controller_class: DataModel_IDController_AutoIncrement::class,
	id_controller_options: [
		'id_property_name' => 'id'
	]
)]
class Order extends DataModel {
	use Order_Traits_DeliveryMethods;
	use Order_Traits_PaymentMethods;
	use Order_Traits_Process;

	#[DataModel_Definition(
		type: DataModel::TYPE_ID_AUTOINCREMENT,
		is_id: true,
	)]
	protected int $id = 0;
	
	#[DataModel_Definition(
		type: DataModel::TYPE_LOCALE,
		is_key: true,
	)]
	protected ?Locale $locale = null;

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 100,
		is_key: true,
	)]
	protected string $ip_address = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_DATE_TIME
	)]
	protected ?Data_DateTime $date_purchased = null;

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255,
		is_key: true
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_EMAIL,
		label: 'e-mail:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte e-mail',
			Form_Field::ERROR_CODE_INVALID_FORMAT => 'Prosím zadejte platný e-mail'
		]
	)]
	protected string $email = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255,
		is_key: true
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Telefon:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte telefon',
			Form_Field::ERROR_CODE_INVALID_FORMAT => 'Prosím zadejte platný telefon'
		]
	)]
	protected string $phone = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Firma:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $billing_company_name = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 50
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'IČO:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $billing_company_id = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 50
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'DIČ:',
		is_required: false,
		error_messages: [
		]
	)]
	protected string $billing_company_vat_id = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Jméno:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte jméno'
		]
	)]
	protected string $billing_first_name = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Příjmení:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte příjmení'
		]
	)]
	protected string $billing_surname = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Ulice a číslo:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte adresu'
		]
	)]
	protected string $billing_address_street_no = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Město / obec:',
		is_required: true,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte město / obec'
		]
	)]
	protected string $billing_address_town = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'PSČ:',
		is_required: false,
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte PSČ'
		]
	)]
	protected string $billing_address_zip = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	protected string $billing_address_country = '';


	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Firma:',
		error_messages: [
		]
	)]
	protected string $delivery_company_name = '';


	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Jméno:',
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte Vaše jméno'
		]
	)]
	protected string $delivery_first_name = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Příjmení:',
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte příjmení'
		]
	)]
	protected string $delivery_surname = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Ulice a číslo:',
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte adresu'
		]
	)]
	protected string $delivery_address_street_no = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'Město / obec:',
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte město / obec'
		]
	)]
	protected string $delivery_address_town = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_INPUT,
		label: 'PSČ:',
		error_messages: [
			Form_Field::ERROR_CODE_EMPTY => 'Prosím zadejte PSČ'
		]
	)]
	protected string $delivery_address_zip = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 255
	)]
	protected string $delivery_address_country = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 65536
	)]
	protected string $special_requirements = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_BOOL
	)]
	#[Form_Definition(
		type: Form_Field::TYPE_CHECKBOX,
		label: 'Adresa dodání se liší od fakturační adresy',
		is_required: false,
		error_messages: [
		]
	)]
	protected bool $different_delivery_address = false;

	#[DataModel_Definition(
		type: DataModel::TYPE_BOOL
	)]
	protected bool $company_order = false;

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 50,
		is_key: true
	)]
	protected string $delivery_method_code = '';

	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 50,
		is_key: true
	)]
	protected string $payment_method_code = '';
	
	#[DataModel_Definition(
		type: DataModel::TYPE_STRING,
		max_len: 100,
		is_key: true
	)]
	protected string $status_code = '';

	/**
	 * @var Order_Item[]
	 */
	#[DataModel_Definition(
		type: DataModel::TYPE_DATA_MODEL,
		data_model_class: Order_Item::class
	)]
	protected array $items = [];
	
	public function getLocale(): Locale
	{
		return $this->locale;
	}
	
	public function setLocale( Locale $locale ): void
	{
		$this->locale = $locale;
	}

	public function getId() : int
	{
		return $this->id;
	}


	public function getIpAddress() : string
	{
		return $this->ip_address;
	}

	public function setIpAddress( string $ip_address ) : void
	{
		$this->ip_address = $ip_address;
	}

	public function getDatePurchased() : Data_DateTime
	{
		return $this->date_purchased;
	}

	public function setDatePurchased( Data_DateTime $date_purchased ) : void
	{
		$this->date_purchased = $date_purchased;
	}

	public function getEmail() : string
	{
		return $this->email;
	}

	public function setEmail( string $email ) : void
	{
		$this->email = $email;
	}

	public function getPhone() : string
	{
		return $this->phone;
	}

	public function setPhone( string $phone ) : void
	{
		$this->phone = $phone;
	}

	public function getBillingCompanyName() : string
	{
		return $this->billing_company_name;
	}

	public function setBillingCompanyName( string $billing_company_name ) : void
	{
		$this->billing_company_name = $billing_company_name;
	}

	public function getBillingCompanyId() : string
	{
		return $this->billing_company_id;
	}

	public function setBillingCompanyId( string $billing_company_id ) : void
	{
		$this->billing_company_id = $billing_company_id;
	}

	public function getBillingCompanyVatId() : string
	{
		return $this->billing_company_vat_id;
	}

	public function setBillingCompanyVatId( string $billing_company_vat_id ) : void
	{
		$this->billing_company_vat_id = $billing_company_vat_id;
	}

	public function getBillingFirstName() : string
	{
		return $this->billing_first_name;
	}

	public function setBillingFirstName( string $billing_first_name ) : void
	{
		$this->billing_first_name = $billing_first_name;
	}

	public function getBillingSurname(): string
	{
		return $this->billing_surname;
	}

	public function setBillingSurname( string $billing_surname ): void
	{
		$this->billing_surname = $billing_surname;
	}

	public function getBillingAddressStreetNo() : string
	{
		return $this->billing_address_street_no;
	}

	public function setBillingAddressStreetNo( string $billing_address_street_no ) : void
	{
		$this->billing_address_street_no = $billing_address_street_no;
	}

	public function getBillingAddressTown() : string
	{
		return $this->billing_address_town;
	}

	public function setBillingAddressTown( string $billing_address_town ) : void
	{
		$this->billing_address_town = $billing_address_town;
	}

	public function getBillingAddressZip() : string
	{
		return $this->billing_address_zip;
	}

	public function setBillingAddressZip( string $billing_address_zip ) : void
	{
		$this->billing_address_zip = $billing_address_zip;
	}

	public function getBillingAddressCountry() : string
	{
		return $this->billing_address_country;
	}

	public function setBillingAddressCountry( string $billing_address_country ) : void
	{
		$this->billing_address_country = $billing_address_country;
	}

	public function getDeliveryCompanyName(): string
	{
		return $this->delivery_company_name;
	}

	public function setDeliveryCompanyName( string $delivery_company_name ): void
	{
		$this->delivery_company_name = $delivery_company_name;
	}



	public function getDeliveryFirstName() : string
	{
		return $this->delivery_first_name;
	}

	public function setDeliveryFirstName( string $delivery_first_name ) : void
	{
		$this->delivery_first_name = $delivery_first_name;
	}

	/**
	 * @return string
	 */
	public function getDeliverySurname(): string
	{
		return $this->delivery_surname;
	}

	/**
	 * @param string $delivery_surname
	 */
	public function setDeliverySurname( string $delivery_surname ): void
	{
		$this->delivery_surname = $delivery_surname;
	}

	public function getDeliveryAddressStreetNo() : string
	{
		return $this->delivery_address_street_no;
	}

	public function setDeliveryAddressStreetNo( string $delivery_address_street_no ) : void
	{
		$this->delivery_address_street_no = $delivery_address_street_no;
	}

	public function getDeliveryAddressTown() : string
	{
		return $this->delivery_address_town;
	}

	public function setDeliveryAddressTown( string $delivery_address_town ) : void
	{
		$this->delivery_address_town = $delivery_address_town;
	}

	public function getDeliveryAddressZip() : string
	{
		return $this->delivery_address_zip;
	}

	public function setDeliveryAddressZip( string $delivery_address_zip ) : void
	{
		$this->delivery_address_zip = $delivery_address_zip;
	}

	public function getDeliveryAddressCountry() : string
	{
		return $this->delivery_address_country;
	}

	public function setDeliveryAddressCountry( string $delivery_address_country ) : void
	{
		$this->delivery_address_country = $delivery_address_country;
	}

	public function getSpecialRequirements() : string
	{
		return $this->special_requirements;
	}

	public function setSpecialRequirements( string $special_requirements ) : void
	{
		$this->special_requirements = $special_requirements;
	}

	public function isDifferentDeliveryAddress(): bool
	{
		return $this->different_delivery_address;
	}

	public function setDifferentDeliveryAddress( bool $different_delivery_address ) : void
	{
		$this->different_delivery_address = $different_delivery_address;
	}

	public function isCompanyOrder() : bool
	{
		return $this->company_order;
	}

	public function setCompanyOrder( bool $company_order ) : void
	{
		$this->company_order = $company_order;
	}

	public function getDeliveryMethodCode() : string
	{
		return $this->delivery_method_code;
	}
	
	public function setDeliveryMethodCode( string $delivery_method_code ) : void
	{
		if($this->getDeliveryMethod($delivery_method_code)) {
			$this->delivery_method_code = $delivery_method_code;
		}
	}

	public function getPaymentMethodCode() : string
	{
		return $this->payment_method_code;
	}

	public function setPaymentMethodCode( string $payment_method_code ) : void
	{
		if($this->getPaymentMethod( $payment_method_code )) {
			$this->payment_method_code = $payment_method_code;
		}
		
	}

	public function getTotalPrice() : float
	{
		$price = 0;
		foreach($this->getItems() as $item) {
			$price+=$item->getTotalPrice();
		}
		return $price;
	}
	
	public function getProductPrice() : float
	{
		$price = 0;
		foreach($this->getItems() as $item) {
			if($item->getType()==Order_Item::ITEM_TYPE_PRODUCT) {
				$price+=$item->getTotalPrice();
			}
		}
		return $price;
	}

	public function getDeliveryPrice() : float
	{
		$price = 0;
		foreach($this->getItems() as $item) {
			if($item->getType()==Order_Item::ITEM_TYPE_DELIVERY) {
				$price+=$item->getTotalPrice();
			}
		}
		return $price;
	}

	public function getPaymentPrice() : float
	{
		$price = 0;
		foreach($this->getItems() as $item) {
			if($item->getType()==Order_Item::ITEM_TYPE_PAYMENT) {
				$price+=$item->getTotalPrice();
			}
		}
		return $price;
	}

	/**
	 * @return Order_Item[]
	 */
	public function getItems() : iterable
	{
		return $this->items;
	}

	public function addItem( Order_Item $item ) : void
	{
		$this->items[] = $item;
	}

	public function getStatusCode() : string
	{
		return $this->status_code;
	}

	public function setStatusCode( string $status_code ) : void
	{
		$this->status_code = $status_code;
	}
	
	
	public static function get( int $id ) : static|null
	{
		return static::load( $id );
	}
	
	/**
	 * @return Order[]
	 */
	public static function getList() : iterable
	{
		$where = [];

		return static::fetchInstances( $where );
	}
	
}