<form method="POST" action="{$request->link()}" {$widget->renderCommonAttributes()}>
	{if count($widget->errors) || ($widget->errortitle != "")}
	<div class="alert alert-danger alert-dismissable col-lg-12">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{if ($widget->errortitle != "")}
			<h4>{$widget->errortitle|escape}</h4>
		{/if}
		{foreach $widget->errors AS $error_title => $error}
			<p>{if !is_int($error_title)}<strong>{$error_title|escape}</strong> {/if}{$error|escape}</p>
		{/foreach}
	</div>
	{/if}
	
	{if isset($widget->title) && $widget->title}
	<fieldset>
		<legend>{$widget->title|escape}</legend>
	{/if}
	
		{$widget->renderChildrenHTML()}
	
	{if isset($widget->title) && $widget->title}
		</fieldset>
	{/if}	
</form>
