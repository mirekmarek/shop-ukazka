<?php
return [
	'id' => 'order-finish',
	'name' => 'Děkujeme za objednávku',
	'is_active' => true,
	'SSL_required' => false,
	'title' => 'Děkujeme za objednávku',
	'icon' => '',
	'menu_title' => 'Děkujeme za objednávku',
	'breadcrumb_title' => 'Děkujeme za objednávku',
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
