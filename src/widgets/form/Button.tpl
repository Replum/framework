<button
	type="{$widget->type|default:"text"}"
	class="btn btn-default{if isset($widget->tooltip)} tooltip-show{/if}"
	{if isset($widget->tooltip)}
		data-toggle="tooltip"
		data-placement="{$widget->placement|default:"bottom"}"
		title="{$widget->tooltip}"
	{/if}
>
	{if $widget->value|is_a:'\nexxes\iWidget'}{$widget->value->renderHTML()}{else}{$widget->value}{/if}
</button>&nbsp;