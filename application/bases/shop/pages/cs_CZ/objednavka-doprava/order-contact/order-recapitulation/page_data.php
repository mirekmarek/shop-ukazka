<?php
return [
	'id' => 'order-recapitulation',
	'name' => 'Objednávka - rekapitulace',
	'is_active' => true,
	'SSL_required' => false,
	'title' => 'Objednávka - rekapitulace',
	'icon' => '',
	'menu_title' => 'Objednávka - rekapitulace',
	'breadcrumb_title' => 'Objednávka - rekapitulace',
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
			'controller_action' => 'recapitulation',
			'parameters' => [
			],
			'is_cacheable' => false,
			'output_position' => '__main__',
			'output_position_order' => 1,
		],
	],
];
