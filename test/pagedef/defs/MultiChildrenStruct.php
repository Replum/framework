<?php

namespace nexxes\widgets\pagedef\structure;

return (new Widget(\nexxes\widgets\PageTraitMock::class))->add(
	(new Child(\nexxes\widgets\html\Text::class))->add(
		new Property('class', 'class1')
	), (new Child(\nexxes\widgets\html\Text::class))->add(
		new Property('class', 'class2')
	), (new Child(\nexxes\widgets\html\Text::class))->add(
		new Property('class', 'class3')
	)
);
