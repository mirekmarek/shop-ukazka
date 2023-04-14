<?php
return [
	'id' => 'order-finish',
	'name' => 'Objednávka - dokončení',
	'is_active' => true,
	'SSL_required' => false,
	'title' => 'Objednávka - dokončení',
	'icon' => '',
	'menu_title' => 'Objednávka - dokončení',
	'breadcrumb_title' => 'Objednávka - dokončení',
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
			'controller_action' => 'finish',
			'parameters' => [
			],
			'is_cacheable' => false,
			'output_position' => '__main__',
			'output_position_order' => 1,
		],
	],
];
