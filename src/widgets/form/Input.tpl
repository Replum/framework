<div class="form-group{if isset($widget->status) && $widget->status != ""} has-{$widget->status}{/if}">
	<label for="{$id}" class="col-lg-4 control-label">
		{if isset($widget->tooltip)}<span class="tooltip-show" data-toggle="tooltip" title="{$widget->tooltip}">{/if}
			{$widget->caption}
		{if isset($widget->tooltip)}</span>{/if}
	</label>
	<div class="col-lg-8">
		<input id="{$id}"
					 class="form-control {if count($widget->classes)}{implode(' ', $widget->classes)}{/if}"
					 type="{$widget->type|default:"text"}"
					 name="{$id}|value"
					 value="{$widget->value|default:""|escape}"
					 size="{$widget->size|default:20}"
					 {if isset($widget->placeholder)}placeholder="{$widget->placeholder|escape}"{/if}
		/>
	</div>
</div>