<?php
namespace JetApplication;

use Jet\Tr;

trait Order_PaymentMethod_Trait {
	protected Order $order;
	
	public function setOrder( Order $order ) : void
	{
		$this->order = $order;
	}
	
	protected function _( string $text, array $data=[] ) : string
	{
		return Tr::_(
			text: $text,
			data: $data,
			dictionary: Order::PAYMENT_MODULE_NAME_PREFIX.$this->getCode(),
			locale: $this->order->getLocale()
		);
	}
	
	public function getCode() : string
	{
		return substr(
			0,
			strlen( Order::PAYMENT_MODULE_NAME_PREFIX ),
			$this->getModuleManifest()->getName()
		);
	}
	
	public function getVATRate(): float
	{
		return VAT::getDefaultVATRate( $this->order->getLocale() );
	}
}