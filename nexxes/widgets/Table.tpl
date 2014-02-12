<div class="nexxes-widget-ajax" id="{$id}">
<table class="table table-bordered table-condensed table-hover table-striped">
	<thead>
		<tr>
			{foreach $datasource->fields() AS $field}
				<th><a href="?{$id}|sort={$field}{if (($field == $sort) && ($order == 'asc'))  }&{$id}|order=desc{/if}">{$datasource->fieldName($field)}</a></th>
			{/foreach}
		</tr>
	</thead>
	
	<tbody>
		{foreach $datasource AS $entry}
		<tr data-nexxes-id="{$entry->id}">
			{foreach $datasource->fields() AS $field}
				<td>
					{assign "value" $entry}
					{assign "parts" explode(".", $field)}
					
					{foreach $parts as $part}
							{assign "value" $value->{$part}}
					{/foreach}
					{$value}
				</td>
			{/foreach}
		</tr>
		{/foreach}
	</tbody>
</table>
</div>
