<div {$widget->renderCommonAttributes()}>
	{foreach $widget->widgets() AS $child}
		{$child->renderHTML()}
	{/foreach}
</div>