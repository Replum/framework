<div class="form-group">
	<label for="{$id}" class="col-lg-4 control-label">
		{if isset($widget->tooltip)}<span class="tooltip-show" data-toggle="tooltip" title="{$widget->tooltip}">{/if}
			{$widget->caption}
		{if isset($widget->tooltip)}</span>{/if}
	</label>
	
	<div class="col-lg-8">
		<select id="{$id}" name="{$id}|value" class="form-control">
			{foreach $widget->values AS $key => $value}
				<option value="{$key}"{if isset($widget->value) && ($widget->value == $key)} selected="selected"{/if}>{$value}</option>
			{/foreach}
		</select>
	</div>
</div>