<?php

namespace nexxes\widgets\pagedef\structure;

return (new Widget(\nexxes\widgets\WidgetCompositeTraitMock::class))->add(
	(new Slot(\nexxes\widgets\html\Text::class, 'slot1', false))->add(
		new Property('class', 'class1')
	), (new Slot(\nexxes\widgets\html\Text::class, 'slot2', false))->add(
		new Property('class', 'class2')
	), (new Slot(\nexxes\widgets\html\Text::class, 'slot3', true))->add(
		new Property('class', 'class3')
	), (new Slot(\nexxes\widgets\html\Text::class, 'slot3', true))->add(
		new Property('class', 'class4')
	)
);
