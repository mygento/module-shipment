define(
    [],
    function () {
        'use strict';
        return {
            getRules: function () {
                return {
                    'city': {
                        'required': true
                    }
                };
            }
        };
    }
);