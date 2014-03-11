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
		
		$(link).off("click");
		$(link).one("click", function() {
			nexxes.simpleWidget.startLoaderAnimation();
			var url = link.href + '&wid=' + widgetID + ' #' + widgetID + ' > *';
			$('#' + widgetID).load(url, nexxes.simpleWidget.init);
			return false;
		});
	},
	
	_workForm: function() {
		var form = this;
		var widgetID = form.id;
		
		$(form).off("submit");
		$(form).one("submit", function() {
			nexxes.simpleWidget.startLoaderAnimation();
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
		
		for (var i=0; i < nexxes.simpleWidget.suggests.length; ++i) {
			var suggestor = nexxes.simpleWidget.suggests[i];
			
			$(suggestor.selector).typeahead(null, {
				name: suggestor.name,
				source: suggestor.repo.ttAdapter(),
				autoselect: true,
				highlight: true,
				templates: suggestor.templates
			});
		}
		
		$('#pleaseWaitDialog').modal('hide');
	},
	
	suggests: [],
	
	registerSuggest: function(name, selector, source, template, suggestions) {
		var suggestor = {
			name: name,
			selector: selector,
			repo: new Bloodhound({
				datumTokenizer: function(d) { return d.tokens; },
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				limit: suggestions,
				prefetch: {
					url: source,
					ttl: 1,
					thumbprint: name + '-123'
				}
			}),
			templates: {
				suggestion: Handlebars.compile(template)
			}
		};
		suggestor.repo.initialize();
		this.suggests.push(suggestor);
	},
	
	startLoaderAnimation: function() {
		var pos = 1;
		var max = 130;
		var interval = setInterval(function() {
			if (pos == 1) {
				$('#pleaseWaitDialog').modal('show');
			}
			
			if (pos == max) {
				clearInterval(interval);
				$('#pleaseWaitDialog').modal('hide');
			}
			
			$('#pleaseWaitDialog div.progress-bar').css('width', '' + Math.ceil(pos/max*100) + '%');
			pos++;
		}, 500);
		
		$('#pleaseWaitDialog').on('hide.bs.modal', function (e) {
			clearInterval(interval);
		});
	}
};

// Enable SimpleWidget on page load
$(document).ready(nexxes.simpleWidget.init);
