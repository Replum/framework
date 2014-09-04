<?php

namespace nexxes\widgets\pagedef\structure;

return (new Widget(\nexxes\widgets\PageTraitMock::class))->add(
	(new Child(\nexxes\widgets\html\Text::class))->add(
		new Property('class', 'testclass'),
		new Property('text', 'Test Text')
	)->ref('testref')
);
