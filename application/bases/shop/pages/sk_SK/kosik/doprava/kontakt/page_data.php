<?php
return [
	'id' => 'order-contact',
	'name' => 'Kontakt',
	'is_active' => true,
	'SSL_required' => false,
	'title' => 'Kontakt',
	'icon' => '',
	'menu_title' => 'Kontakt',
	'breadcrumb_title' => 'Kontakt',
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
			'controller_action' => 'contact',
			'parameters' => [
			],
			'is_cacheable' => false,
			'output_position' => '__main__',
			'output_position_order' => 1,
		],
	],
];
