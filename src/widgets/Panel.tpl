<div {$widget->renderCommonAttributes()}>
	{foreach $widget->head AS $child}
		<div class="panel-heading">
			{$child->renderHTML()}
		</div>
	{/foreach}
	
	{assign var="inPanelBody" value=false}
	{foreach $widget->widgets() AS $child}
		{if $child instanceof "nexxes\widgets\iPanelChild" || in_array('panel-body', $child->classes)}
			{if $inPanelBody}
				{assign var="inPanelBody" value=false}
				</div>
			{/if}
			
			{$child->renderHTML()}
		{else}
			{if !$inPanelBody}
				{assign var="inPanelBody" value=true}
				<div class="panel-body">
			{/if}
				{$child->renderHTML()}
		{/if}
	{/foreach}
	
	{if $inPanelBody}
		{assign var="inPanelBody" value=false}
		</div>
	{/if}
	
	{if count($widget->foot) > 0}
		<div class="panel-footer">
			{foreach $widget->foot AS $child}
				{$child->renderHTML()}
			{/foreach}
		</div>
	{/if}
</div>