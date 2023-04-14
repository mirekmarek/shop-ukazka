<?php
namespace JetApplication;

interface Order_PaymentMethod_Interface {
	
	public function setOrder( Order $order ) : void;
	
	public function getCode() : string;
	
	public function isActive() : bool;
	
	public function getTitle() : string;
	
	public function getPrice() : float;
	
	public function getVATRate() : float;
	
	public function getPriority() : int;
	
	public function isDefault() : bool;
	
}