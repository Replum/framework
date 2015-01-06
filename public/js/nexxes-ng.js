var nexxes = nexxes || {};

nexxes.widgets = {
	/**
	 * Contains a list of actions to perform
	 * @type {Event[]}
	 */
	eventQueue: [],
	
	/**
	 * If an event is executed and has not returned yet, it is stored here
	 * 
	 * @type {Event}
	 */
	currentEvent: null,
	
	/**
	 * The last action executed, to prevent duplicates
	 * 
	 * @type {Event}
	 */
	lastEvent: null,
	
	/**
	 * Default event<->server backend action handler
	 * @param {Event} event
	 */
	defaultHandler: function(event) {
		// Ignore events on elements without an id
		if (!event.currentTarget.id || (event.currentTarget.id === "")) { return; }
		
		// Do not issue action click action, only remote action
		event.preventDefault();
		
		nexxes.widgets.lastEvent = event;
		nexxes.widgets.eventQueue.push(event);
		nexxes.widgets._executeActions();
	},
	
	/**
	 * Handler for form element change events
	 * @param {Event} event
	 */
	changeHandler: function(event) {
		// Ignore duplicates
		if (nexxes.widgets.lastEvent && (nexxes.widgets.lastEvent === event)) {
			//console.log('Skipping duplicate, ', event.type);
			return;
		}
		
		// Fix for datepicker which fires onchange 3x
		if (
			nexxes.widgets.lastEvent
			&& (nexxes.widgets.lastEvent.type === event.type)
			&& (event.type === 'change')
			&& (nexxes.widgets.lastEvent.target === event.target)
			&& ($(event.target).data('provide') === 'datepicker')
			&& ((nexxes.widgets.lastEvent.timeStamp+300) > event.timeStamp)
		) {
			//console.log('Skipping duplicate datepicker event: ', event.type, event.timeStamp, nexxes.widgets.lastEvent.timeStamp);
			event.stopPropagation();
			return;
		}
		
		nexxes.widgets.lastEvent = event;
		nexxes.widgets.eventQueue.push(event);
		nexxes.widgets._executeActions();
	},
	
	/**
	 * Handle submit events
	 * @param {Event} event
	 */
	submitHandler: function(event) {
		event.preventDefault();
		
		nexxes.widgets.lastEvent = event;
		nexxes.widgets.eventQueue.push(event);
		nexxes.widgets._executeActions();
	},
	
	_executeActions: function() {
		// Action pending, do nothing
		if (nexxes.widgets.currentEvent !== null) {
			//console.log("A current action is pending, doing nothing.");
			return;
		}
		
		// No action queued, nothing to do
		if (nexxes.widgets.eventQueue.length === 0) {
			//console.log("Queue is empty, doing nothing.");
			return;
		}
		
		nexxes.widgets.currentEvent = nexxes.widgets.eventQueue.shift();
		console.log(nexxes.widgets.currentEvent);
		
		params = [];
		
		if (nexxes.widgets.currentEvent.type === "submit") {
			params = $(nexxes.widgets.currentEvent.target).serializeArray();
		} else if (nexxes.widgets.currentEvent.target.type && ((nexxes.widgets.currentEvent.target.type === "radio") || (nexxes.widgets.currentEvent.target.type === "checkbox"))) {
			params.push( { name: "nexxes_checked", value: nexxes.widgets.currentEvent.target.checked } );
		} else if ((nexxes.widgets.currentEvent.target.value !== null) && (nexxes.widgets.currentEvent.target.value !== undefined)) {
			params.push( { name: "nexxes_value", value: nexxes.widgets.currentEvent.target.value } );
		}
		
		params.push( { name: "nexxes_pid", value: document.body.id } );
		params.push( { name: "nexxes_event", value: nexxes.widgets.currentEvent.type } );
		params.push( { name: "nexxes_source", value: nexxes.widgets.currentEvent.currentTarget.id } );
		
		//console.log("Executing action with parameters: ", params);
		
		$.post(document.URL, params, nexxes.widgets._handleResponse);
	},
	
	_handleResponse: function(data) {
		console.log(data);
		
		for (var i=0; i<data.length; i++) {
			if (data[i].nexxes_action === "replace") {
				console.log("Issuing replace action", $("#" + data[i].nexxes_target));
				$("#" + data[i].nexxes_target).replaceWith(data[i].nexxes_data);
			}
			
			else {
				var fn = nexxes.methods[data[i].nexxes_action];
				if (typeof fn === 'function') {
					console.log('Executing method "' + data[i].nexxes_action + '" with ', data[i].nexxes_params);
					fn.apply(null, data[i].nexxes_params);
				} else {
					console.log('Invalid method "' + data[i].nexxes_action + '"');
				}
			}
		}
		
		nexxes.widgets.refresh();
		
		nexxes.widgets.currentEvent = null;
		nexxes.widgets._executeActions();
	},
	
	refresh: function() {
		$('[data-toggle~=tooltip]').tooltip();
		$('[data-toggle~=popover]').popover();
		// Display forced popovers that are not already visible (avoid flickering)
		$('[data-toggle~=popover][data-trigger=manual][data-visible=always]').filter(':not([aria-describedby])').popover('show');
		// Emulate autofocus of input elements
		$('[autofocus=autofocus]').select().removeAttr('autofocus');
	},
	
	init: function() {
		nexxes.widgets.refresh();
		$(document).on('click',    '*[data-handler~="click"]', nexxes.widgets.defaultHandler);
		$(document).on('dblclick', '*[data-handler~="dblclick"]', nexxes.widgets.defaultHandler);
		$(document).on('change',   'input, textarea, select', nexxes.widgets.changeHandler);
		$(document).on('submit',   'form', nexxes.widgets.submitHandler);
	}
};

nexxes.methods = {
	modalShow: function(selector) {
		$(selector).modal('show');
	},
	modalHide: function(selector) {
		$(selector).modal('hide');
	},
	error: function(data) {
		alert('Ein Fehler ist aufgetreten, bitte laden Sie die Seite neu.');
		console.log(data);
	},
	redirect: function(url) {
		window.location = url;
	}
};


$(document).ready(function() {
	nexxes.widgets.init();
	
	timer = $('#logoutCounter');
	console.log(timer);
	remaining = 15*60;
	callback = function() {
		timer.html("" + Math.floor(remaining / 60) + ':' + ("0" + (remaining % 60)).substr(-2));
		remaining--;
	};
	
	window.setInterval(callback, 1000);
});