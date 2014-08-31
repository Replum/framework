<?php

return [
	'properties' => [
		'title' => 'A simple test page',
	],

	'children' => [
		[
			'class' => 'WidgetContainer',
			'properties' => [
				'class' => 'row',
			],
			'children' => [
				[
					'class' => 'WidgetContainer',
					'properties' => [
						'class' => 'col-lg-3',
					],
					'children' => [
						[
							'class' => 'Text',
							'properties' => [
								'type' => 'h2',
								'text' => 'This is the menu title',
							],
						],
					],
				],
				[
					'class' => 'WidgetContainer',
					'properties' => [
						'class' => 'col-lg-9',
					],
					'children' => [
						[
							'class' => 'Text',
							'properties' => [
								'type' => 'h2',
								'text' => 'This is the main content',
							],
						],
						[
							'class' => 'Text',
							'properties' => [
								'type' => 'p',
								'text' => 'This is just some lirum larum text, bla blubb whatever.',
							],
						],
					],
				],
			]
		]
	],
];
