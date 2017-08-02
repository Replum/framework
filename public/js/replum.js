$(function() {
    const EVENT_PARAMETER_NAME = 'replum_event';
    const PAGE_ID_PARAMETER_NAME = 'replum_pid';
    const SOURCE_PARAMETER_NAME = 'replum_source';
    const VALUE_PARAMETER_NAME = 'replum_value';
    const CHECKED_PARAMETER_NAME = 'replum_checked';
    const ACTION_PARAMETER_NAME = 'replum_action';
    const PARAMS_PARAMETER_NAME = 'replum_params';
    const TARGET_PARAMETER_NAME = 'replum_target';
    const DATA_PARAMETER_NAME = 'replum_data';

    var that = this;

    /*
     * Contains a list of actions to perform
     * @type {Event[]}
     */
    var eventQueue = [];

    /**
     * If an event is executed and has not returned yet, it is stored here
     *
     * @type {Event}
     */
    var currentEvent =  null;

    /**
     * The last action executed, to prevent duplicates
     *
     * @type {Event}
     */
    var lastEvent = null;

    var methods = {
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

    /**
     * Default event<->server backend action handler
     * @param {Event} event
     */
    var defaultHandler = function(event) {
        // Ignore events on elements without an id
        if (!event.currentTarget.id || (event.currentTarget.id === "")) { return; }

        // Do not issue action click action, only remote action
        event.preventDefault();

        that.lastEvent = event;
        that.eventQueue.push(event);
        that.executeActions();
    };

    /**
     * Handler for form element change events
     * @param {Event} event
     */
    var changeHandler = function(event) {
        // Ignore duplicates
        if (that.lastEvent && (that.lastEvent === event)) {
            //console.log('Skipping duplicate, ', event.type);
            return;
        }

        // Fix for datepicker which fires onchange 3x
        if (
            that.lastEvent
            && (that.lastEvent.type === event.type)
            && (event.type === 'change')
            && (that.lastEvent.target === event.target)
            && ($(event.target).data('provide') === 'datepicker')
            && ((that.lastEvent.timeStamp+300) > event.timeStamp)
        ) {
            //console.log('Skipping duplicate datepicker event: ', event.type, event.timeStamp, that.lastEvent.timeStamp);
            event.stopPropagation();
            return;
        }

        that.lastEvent = event;
        that.eventQueue.push(event);
        that.executeActions();
    };

    /**
     * Handle submit events
     * @param {Event} event
     */
    var submitHandler = function(event) {
        event.preventDefault();

        that.lastEvent = event;
        that.eventQueue.push(event);
        that.executeActions();
    };

    var executeActions = function() {
        // Action pending, do nothing
        if (that.currentEvent !== null) {
            //console.log("A current action is pending, doing nothing.");
            return;
        }

        // No action queued, nothing to do
        if (that.eventQueue.length === 0) {
            //console.log("Queue is empty, doing nothing.");
            return;
        }

        that.currentEvent = that.eventQueue.shift();
        console.log(that.currentEvent);

        params = [];

        if (that.currentEvent.type === "submit") {
            params = $(that.currentEvent.target).serializeArray();
        } else if (that.currentEvent.target.type && ((that.currentEvent.target.type === "radio") || (that.currentEvent.target.type === "checkbox"))) {
            params.push( { name: CHECKED_PARAMETER_NAME, value: that.currentEvent.target.checked } );
        } else if ((that.currentEvent.target.value !== null) && (that.currentEvent.target.value !== undefined)) {
            params.push( { name: VALUE_PARAMETER_NAME, value: that.currentEvent.target.value } );
        }

        params.push( { name: PAGE_ID_PARAMETER_NAME, value: document.body.id } );
        params.push( { name: EVENT_PARAMETER_NAME, value: that.currentEvent.type } );
        params.push( { name: SOURCE_PARAMETER_NAME, value: that.currentEvent.currentTarget.id } );

        //console.log("Executing action with parameters: ", params);
        $.post(document.URL, params, that.handleResponse);
    };

    var handleResponse = function(data) {
        console.log(data);

        if (data.constructor === Array) {
            for (var i=0; i<data.length; i++) {
                if (data[i][ACTION_PARAMETER_NAME] === "replace") {
                    console.log("Issuing replace action", $("#" + data[i][TARGET_PARAMETER_NAME]));
                    $("#" + data[i][TARGET_PARAMETER_NAME]).replaceWith(data[i][DATA_PARAMETER_NAME]);
                }

                else {
                    var fn = that.methods[data[i][ACTION_PARAMETER_NAME]];
                    if (typeof fn === 'function') {
                        console.log('Executing method "' + data[i][ACTION_PARAMETER_NAME] + '" with ', data[i][PARAMS_PARAMETER_NAME]);
                        fn.apply(null, data[i][PARAMS_PARAMETER_NAME]);
                    } else {
                        console.log('Invalid method "' + data[i][ACTION_PARAMETER_NAME] + '"');
                    }
                }
            }

            that.refresh();
        }

        that.currentEvent = null;
        that.executeActions();
    };

    var refresh = function() {
        $('[data-toggle~=tooltip]').tooltip();
        $('[data-toggle~=popover]').popover();
        // Display forced popovers that are not already visible (avoid flickering)
        $('[data-toggle~=popover][data-trigger=manual][data-visible=always]').filter(':not([aria-describedby])').popover('show');
        // Emulate autofocus of input elements
        $('[autofocus=autofocus]').select().removeAttr('autofocus');
    };

    that.refresh();
    $(document).on('click',    '*[data-handler~="click"]', that.defaultHandler);
    $(document).on('dblclick', '*[data-handler~="dblclick"]', that.defaultHandler);
    $(document).on('change',   'input, textarea, select', that.changeHandler);
    $(document).on('submit',   'form', that.submitHandler);
});
