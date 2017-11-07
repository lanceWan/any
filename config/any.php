<?php
return [
	// 默认分页数量
	'pagination' 	=> 15,
	// 根 namespace
	'rootNamespace' => 'App\\',
	// repository 目录配置
	'paths' => [
		
		'model' 		=> 'Models',
		
		'repositories' 	=> 'Repositories/Eloquent',
		
		'criteria' 		=> 'Repositories/Criteria',
		
		'presenters' 	=> 'Repositories/Presenters',
		
		'triats' 		=> 'Repositories/Traits',
		
		'services' 		=> 'Services',

	]
];