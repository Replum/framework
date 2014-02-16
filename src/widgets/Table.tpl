<div id="{$id}" class="nexxesSimpleWidget">
<table class="table table-bordered table-condensed table-hover table-striped">
	<thead>
		<tr>
			{foreach $datasource->fields() AS $field}
				<th>
					<a class="nexxesSimpleWidgetLink" href="{$request->link($widget, 'sort', $field, 'order', (($field == $sort) && ($order == 'asc') ? 'desc' : 'asc'))}">
						{$datasource->fieldName($field)}
					</a>
				</th>
			{/foreach}
		</tr>
	</thead>
	
	<tbody>
		{foreach $datasource AS $entry}
		<tr data-nexxes-id="{$entry->id}">
			{foreach $datasource->fields() AS $field}
					{assign "value" $entry}
					{assign "parts" explode(".", $field)}
					
					{foreach $parts as $part}
							{assign "value" $value->{$part}}
					{/foreach}
					<td>{$value}</td>
			{/foreach}
		</tr>
		{/foreach}
	</tbody>
</table>
</div>
