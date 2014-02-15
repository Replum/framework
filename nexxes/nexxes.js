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
		var widgetID = widget.id;

		$(link).one("click", function() {
			var url = link.href + '&wid=' + widgetID + ' #' + widgetID + ' > *';
			$('#' + widgetID).load(url, nexxes.simpleWidget.init);
			return false;
		});
	},
	
	_workForm: function() {
		var form = this;
		var widgetID = form.id;
		
		$(form).one("submit", function() {
			var url = form.action + '&wid=' + widgetID + ' #' + widgetID + ' > *';
			$(this).load(url, $(this).serializeArray(), nexxes.simpleWidget.init);
			return false;
		});
	},
	
	/**
	 * Initializier function to re-enable SimpleWidget after page load
	 */
	init: function() {
		if (this instanceof HTMLFormElement) {
			$(this).each(nexxes.simpleWidget._workForm);
		} else {
			$(this).find('form').andSelf().find('form.nexxesSimpleWidget').each(nexxes.simpleWidget._workForm);
		}
		$(this).find('a.nexxesSimpleWidgetLink').each(nexxes.simpleWidget._workLink);
	}
};

// Enable SimpleWidget on page load
$(document).ready(nexxes.simpleWidget.init);
