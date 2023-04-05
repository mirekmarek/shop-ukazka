<?php
return [
	'id' => 'shopping-cart',
	'name' => 'Košík',
	'is_active' => true,
	'SSL_required' => false,
	'title' => 'Košík',
	'icon' => '',
	'menu_title' => 'Košík',
	'breadcrumb_title' => 'Košík',
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
			'module_name' => 'ShoppingCart',
			'controller_name' => 'Main',
			'controller_action' => 'detail',
			'parameters' => [
			],
			'is_cacheable' => false,
			'output_position' => '__main__',
			'output_position_order' => 1,
		],
	],
];
