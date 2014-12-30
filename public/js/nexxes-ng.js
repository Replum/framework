var nexxes = nexxes || {};

/**
 * Simple container to hold action information
 * 
 * @param {string} event Name of the action to perform
 * @param {HTMLElement} source Element that caused the action
 * @param {array} params Key=>Value pairs with current element values
 */
function nexxesWidgetAction(event, source, params) {
	this.event = event;
	this.source = source;
	this.params = params;
}

nexxes.widgets = {
	/**
	 * Contains a list of actions to perform
	 * @type Array
	 */
	actionQueue: [],
	
	/**
	 * If an action is executed and has not returned yet, it is stored here
	 * @type type
	 */
	currentAction: null,
	
	/**
	 * The last action executed, to prevent duplicates
	 */
	lastAction: null,
	
	/**
	 * Default event<->server backend action handler
	 * 
	 * @param Event event
	 */
	handler: function(event) {
		// Ignore events on elements without an id
		if (!event.currentTarget.id || (event.currentTarget.id === "")) { return; }
		
		//event.stopPropagation();
		
		if (event.type === "submit") {
			console.log('Submit event: ', event.currentTarget);
			data = $(event.currentTarget).serializeArray();
			event.preventDefault();
		} else {
			data = [];
		}
		
		action = new nexxesWidgetAction(event.type, event.currentTarget, data);
		
		if (nexxes.widgets.lastAction && (nexxes.widgets.lastAction.event === action.event) && (nexxes.widgets.lastAction.source === action.source)) {
			console.log('Skipping duplicate event: ', action.event, action.source);
			event.stopPropagation();
			return;
		}
		
		nexxes.widgets.lastAction = action;
		nexxes.widgets.actionQueue.push(action);
		nexxes.widgets._executeActions();
	},
	
	_executeActions: function() {
		// Action pending, do nothing
		if (this.currentAction !== null) {
			console.log("A current action is pending, doing nothing.");
			return;
		}
		
		// No action queued, nothing to do
		if (this.actionQueue.length === 0) {
			console.log("Queue is empty, doing nothing.");
			return;
		}
		
		this.currentAction = this.actionQueue.shift();
		this.currentAction.params.push( { name: "nexxes_pid", value: document.body.id } );
		this.currentAction.params.push( { name: "nexxes_event", value: this.currentAction.event } );
		this.currentAction.params.push( { name: "nexxes_source", value: this.currentAction.source.id } );
		if (this.currentAction.source.type && ((this.currentAction.source.type === "radio") || (this.currentAction.source.type === "checkbox"))) {
			this.currentAction.params.push( { name: "nexxes_checked", value: this.currentAction.source.checked } );
		}
		else if ((this.currentAction.source.value !== null) && (this.currentAction.source.value !== undefined)) {
			this.currentAction.params.push( { name: "nexxes_value", value: this.currentAction.source.value } );
		}
		
		console.log("Executing action with parameters: ");
		console.log(this.currentAction.params);
		
		$.post(document.URL, this.currentAction.params, this._handleResponse);
	},
	
	_handleResponse: function(data) {
		console.log(data);
		
		for (var i=0; i<data.length; i++) {
			if (data[i].nexxes_action === "replace") {
				console.log("Issuing replace action");
				console.log($("#" + data[i].nexxes_target));
				//console.log($("#" + data[i].nexxes_target).replaceWith("<p>Test html</p>"));
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
		
		nexxes.widgets.currentAction = null;
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
		$(document).on('click dblclick', 'a[id], button[id], td[id]', nexxes.widgets.handler);
		$(document).on('change', 'input, textarea, select', nexxes.widgets.handler);
		$(document).on('submit', 'form', nexxes.widgets.handler);
	}
};

nexxes.methods = {
	modalShow: function(selector) {
		$(selector).modal('show');
	},
	modalHide: function(selector) {
		$(selector).modal('hide');
	},
	log: function(data) {
		console.log(data);
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
	
	console.log("Foobar");
	
	window.setInterval(callback, 1000);
});