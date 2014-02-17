<table {$widget->renderCommonAttributes()}>
	<thead>
		<tr>
			{foreach $datasource->fields() AS $field}
				<th>
					<a class="nexxesSimpleWidgetLink" href="{$request->link($widget, 'sort', $field, 'order', (($field == $sort) && ($order == 'asc') ? 'desc' : 'asc'))}">
						{$datasource->fieldName($field)}
					{if ($widget->sort == $field)}
						<span class="glyphicon glyphicon-arrow-{if $widget->order == "desc"}down{else}up{/if}"></span>
					{/if}
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
					<td>
						{if $value instanceof '\DateTimeInterface'}
							{$value->format('Y-m-d H:i:s')}
						{else}
							{$value}
						{/if}
					</td>
			{/foreach}
		</tr>
		{/foreach}
	</tbody>
	
	{if count($datasource)>$widget->rowsPerPage}
		{assign var="pages" value=$widget->pages()}
		<tfoot>
			<tr>
				<td colspan="{count($datasource->fields())}" class="text-center">
					<ul class="pagination pull-left">
						{if ($widget->page === 1)}
							<li class="disabled"><span><span class="glyphicon glyphicon-chevron-left" style="margin-right: -5px;"></span><span class="glyphicon glyphicon-chevron-left"></span></span></li>
							<li class="disabled"><span><span class="glyphicon glyphicon-chevron-left"></span></span></li>
						{else}
							<li><a class="nexxesSimpleWidgetLink" href="{$request->link($widget, 'page', 1)}"><span class="glyphicon glyphicon-chevron-left" style="margin-right: -5px;"></span><span class="glyphicon glyphicon-chevron-left"></span></a></li>
							<li><a class="nexxesSimpleWidgetLink" href="{$request->link($widget, 'page', ($widget->page - 1))}"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
							
						{/if}
					</ul>
					
					<ul class="pagination">
						{if $widget->page > 4}
								<li><span>...</span></li>
							{/if}
						
						{for $page=max(1, $widget->page-3) to min($pages, ($widget->page + 3))}
							<li{if $page==$widget->page} class="active"{/if}><a class="nexxesSimpleWidgetLink" href="{$request->link($widget, 'page', $page)}">{$page}</a></li>
						{/for}
						
						{if ($widget->page + 3) < $pages}
								<li><span>...</span></li>
							{/if}
					</ul>
					
					<ul class="pagination pull-right">
						{if ($widget->page == $pages)}
							<li class="disabled"><span><span class="glyphicon glyphicon-chevron-right"></span></span></li>
							<li class="disabled"><span><span class="glyphicon glyphicon-chevron-right" style="margin-right: -5px;"></span><span class="glyphicon glyphicon-chevron-right"></span></span></li>
						{else}
							<li><a class="nexxesSimpleWidgetLink" href="{$request->link($widget, 'page', ($widget->page + 1))}"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
							<li><a class="nexxesSimpleWidgetLink" href="{$request->link($widget, 'page', $pages)}"><span class="glyphicon glyphicon-chevron-right" style="margin-right: -5px;"></span><span class="glyphicon glyphicon-chevron-right"></span></a></li>
						{/if}
					</ul>
				</td>
			</tr>
		</tfoot>
	{/if}
</table>