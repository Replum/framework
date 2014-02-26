<ul {$widget->renderCommonAttributes()} style="margin-right: 20px">
	{foreach $widget->widgets() AS $child}
		<li>{$child->renderHTML()}</li>
	{/foreach}
</ul>