<div {$widget->renderCommonAttributes()}>
	{foreach $widget->head AS $child}
		<div class="panel-heading">
			{$child->renderHTML()}
		</div>
	{/foreach}
	
	{foreach $widget->widgets() AS $child}
		{if $child instanceof "nexxes\widgets\iPanelChild"}
			{$child->renderHTML()}
		{else}
			<div class="panel-body">
				{$child->renderHTML()}
			</div>
		{/if}
	{/foreach}
	
	{foreach $widget->foot AS $child}
		<div class="panel-footer">
			{$child->renderHTML()}
		</div>
	{/foreach}
</div>