<form method="POST" action="{$request->link()}" role="form" class="form-horizontal">
	{if isset($widget->title) && $widget->title}
	<fieldset>
		<legend>{$widget->title}</legend>
	{/if}
	
		{$widget->renderChildrenHTML()}
	
	{if isset($widget->title) && $widget->title}
		</fieldset>
	{/if}	
</form>
