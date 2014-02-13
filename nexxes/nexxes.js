var nexxes = nexxes || {};

/**
 * Simple widget can ajaxify links (and forms, to come).
 * 
 * Links: widges that are wrapped inside <div class="nexxesSimpleWidget"></div>
 *        are searched for links with class nexxesSimpleWidgetLink.
 *        Clicks on these links then result in a load of the widget only
 *        which then replaces the former widgets html.
 */
nexxes.simpleWidget = {
	/**
	 * Internal function, works all links and ajaxifies them
	 */
	_workLink: function() {
		var link = this;
		var widget = $(link).closest('.nexxesSimpleWidget')[0];
		console.log(widget);
		var widgetID = widget.id;

		link.onclick = function() {
			var url = link.href + '&wid=' + widgetID + ' #' + widgetID + ' > :first-child';
			console.log(url);
			$('#' + widgetID).load(url, nexxes.simpleWidget.init);
			return false;
		};
	},
	
	/**
	 * Initializier function to re-enable SimpleWidget after page load
	 */
	init: function() {
		$('a.nexxesSimpleWidgetLink').each(nexxes.simpleWidget._workLink);
	}
};

// Enable SimpleWidget on page load
$(document).ready(nexxes.simpleWidget.init);
