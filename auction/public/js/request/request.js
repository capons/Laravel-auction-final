var main = (function () {
    doConstruct = function () {
        this.init_callbacks = [];
    };
    doConstruct.prototype = {
        add_init_callback : function (func) {
            if (typeof(func) == 'function') {
                this.init_callbacks.push(func);
                return true;
            }
            else {
                return false;
            }

        }
    };
    return new doConstruct;
})();
$(document).ready(function () {
    $.each(main.init_callbacks, function (index, func) {
        func();
    });
});
var main_function = (function () {
    var doConstruct = function () {
        main.add_init_callback(this.calendar_picker);
    };
    doConstruct.prototype = {
        //show calendar library and selec date
        //calendar library libs/calendar
        calendar_picker: function () {
            $('#filter-d-add').datepick({  //datapick calendar library -> public/js/calendar
                dateFormat: 'yyyy-mm-dd',
                altField: '#filter-date-add',
                altFormat: 'yyyy-mm-dd',
            });

        }
    };
    return new doConstruct;
})();