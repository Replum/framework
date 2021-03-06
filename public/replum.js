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

        lastEvent = event;
        eventQueue.push(event);
        executeActions();
    };

    /**
     * Handler for form element change events
     * @param {Event} event
     */
    var changeHandler = function(event) {
        // Ignore duplicates
        if (lastEvent && (lastEvent === event)) {
            //console.log('Skipping duplicate, ', event.type);
            return;
        }

        // Fix for datepicker which fires onchange 3x
        if (
            lastEvent
            && (lastEvent.type === event.type)
            && (event.type === 'change')
            && (lastEvent.target === event.target)
            && ($(event.target).data('provide') === 'datepicker')
            && ((lastEvent.timeStamp+300) > event.timeStamp)
        ) {
            //console.log('Skipping duplicate datepicker event: ', event.type, event.timeStamp, lastEvent.timeStamp);
            event.stopPropagation();
            return;
        }

        lastEvent = event;
        eventQueue.push(event);
        executeActions();
    };

    /**
     * Handle submit events
     * @param {Event} event
     */
    var submitHandler = function(event) {
        event.preventDefault();

        lastEvent = event;
        eventQueue.push(event);
        executeActions();
    };

    var executeActions = function() {
        // Action pending, do nothing
        if (currentEvent !== null) {
            //console.log("A current action is pending, doing nothing.");
            return;
        }

        // No action queued, nothing to do
        if (eventQueue.length === 0) {
            //console.log("Queue is empty, doing nothing.");
            return;
        }

        currentEvent = eventQueue.shift();
        console.log("Handle current event: ", currentEvent);

        var params = [];

        if (currentEvent.type === "submit") {
            var formData = $(currentEvent.target).serializeArray();

            for (var i=0; i<formData.length; i++) {
                var dataEntry = formData[i], n1, n2;
                [n1, n2] = dataEntry.name.split('[', 2);
                params.push( { name: DATA_PARAMETER_NAME + "[" + n1 + "]" + (n2 !== undefined ? '[' + n2 : ''), value: dataEntry.value });
            }
        } else if (currentEvent.target.type && ((currentEvent.target.type === "radio") || (currentEvent.target.type === "checkbox"))) {
            params.push( { name: CHECKED_PARAMETER_NAME, value: currentEvent.target.checked } );
        } else if ((currentEvent.target.value !== null) && (currentEvent.target.value !== undefined)) {
            params.push( { name: VALUE_PARAMETER_NAME, value: currentEvent.target.value } );
        }

        params.push( { name: PAGE_ID_PARAMETER_NAME, value: document.documentElement.id } );
        params.push( { name: EVENT_PARAMETER_NAME, value: currentEvent.type } );
        params.push( { name: SOURCE_PARAMETER_NAME, value: currentEvent.currentTarget.id } );

        //console.log("Executing action with parameters: ", params);
        $.post(document.URL, params).always(handleResponse);
    };

    var handleResponse = function(data) {
        console.log("HandleResponse: ", data);

        var reply = (data.constructor === Array ? data : data.responseJSON);

        for (var i=0; i<reply.length; i++) {
            if (reply[i][ACTION_PARAMETER_NAME] === "error") {
                var element = document.getElementById('replum-error-msg');
                if (element === null) {
                    element = document.createElement('div');
                    element.id = 'replum-error-msg';
                    document.body.appendChild(element);
                }

                var errorMsg = '';

                for (var j=0; j<reply[i][PARAMS_PARAMETER_NAME].length; j++) {
                    errorMsg += reply[i][PARAMS_PARAMETER_NAME][j] + "\n";
                }

                element.innerHTML = '<pre>' + errorMsg + '</pre>';
            }

            else if (reply[i][ACTION_PARAMETER_NAME] === "replace") {
                console.log("Issuing replace action", $("#" + reply[i][TARGET_PARAMETER_NAME]));
                $("#" + reply[i][TARGET_PARAMETER_NAME]).replaceWith(reply[i][DATA_PARAMETER_NAME]);
            }

            else {
                var fn = methods[reply[i][ACTION_PARAMETER_NAME]];
                if (typeof fn === 'function') {
                    console.log('Executing method "' + reply[i][ACTION_PARAMETER_NAME] + '" with ', reply[i][PARAMS_PARAMETER_NAME]);
                    fn.apply(null, reply[i][PARAMS_PARAMETER_NAME]);
                } else {
                    console.log('Invalid method "' + reply[i][ACTION_PARAMETER_NAME] + '"');
                }
            }
        }

        refresh();

        currentEvent = null;
        executeActions();
    };

    var refresh = function() {
        $('[data-toggle~=tooltip]').tooltip();
        //$('[data-toggle~=popover]').popover();
        // Display forced popovers that are not already visible (avoid flickering)
        //$('[data-toggle~=popover][data-trigger=manual][data-visible=always]').filter(':not([aria-describedby])').popover('show');
        // Emulate autofocus of input elements
        //$('[autofocus=autofocus]').select().removeAttr('autofocus');
    };

    refresh();
    $(document).on('click',    '*[data-handler~="click"]', defaultHandler);
    $(document).on('dblclick', '*[data-handler~="dblclick"]', defaultHandler);
    $(document).on('change',   'input[type!="file"], textarea, select', changeHandler);
    $(document).on('submit',   'form', submitHandler);
});
