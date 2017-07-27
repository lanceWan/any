<?php
return [
	// 自定义用户名
	'username' => 'username',
	// 默认主题
	'theme' => 'inspinia',
	// 创建 service 文件配置
	'command' => [
		// service 目录名称
		'namespace' => 'Services\\',
	],
	// id加密配置
	'encrypt' => [
		'main' => true,
		'permission' => true,
		'role' => true,
		'user' => true,
	]
];