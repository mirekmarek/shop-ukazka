<?php
return [
	'id' => 'order',
	'name' => 'Objednávka',
	'is_active' => true,
	'SSL_required' => false,
	'title' => 'Objednávka - doprava a platba',
	'icon' => '',
	'menu_title' => 'Objednávka - doprava a platba',
	'breadcrumb_title' => 'Objednávka - doprava a platba',
	'order' => 0,
	'is_secret' => false,
	'layout_script_name' => 'default',
	'http_headers' => [
	],
	'parameters' => [
	],
	'meta_tags' => [
	],
	'contents' => [
		[
			'module_name' => 'Order.Form',
			'controller_name' => 'Main',
			'controller_action' => 'delivery_and_payment',
			'parameters' => [
			],
			'is_cacheable' => false,
			'output_position' => '__main__',
			'output_position_order' => 1,
		],
	],
];
