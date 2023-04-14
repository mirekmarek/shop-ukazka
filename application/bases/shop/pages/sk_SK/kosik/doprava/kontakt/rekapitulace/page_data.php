<?php
return [
	'id' => 'order-recapitulation',
	'name' => 'Rekapitulace',
	'is_active' => true,
	'SSL_required' => false,
	'title' => 'Rekapitulace',
	'icon' => '',
	'menu_title' => 'Rekapitulace',
	'breadcrumb_title' => 'Rekapitulace',
	'order' => 0,
	'is_secret' => false,
	'layout_script_name' => 'order',
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
