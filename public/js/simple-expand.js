/*SIMPLE EXPAND*/
(function () {
    "use strict";

    function PlugIn() {

        var that = this;

        that.defaults = {
            'hideMode': 'fadeToggle',
            'defaultSearchMode': 'parent',
            'defaultTarget': '.content',
            'throwOnMissingTarget': true
        };

        that.settings = {};
        $.extend(that.settings, that.defaults);

        that.findLevelOneDeep = function (parent, filterSelector, stopAtSelector) {
            return parent.find(filterSelector).filter(function () {
                return !$(this).parentsUntil(parent, stopAtSelector).length;
            });
        };

        that.hideTargets = function (targets) {

            if (that.settings.hideMode === "fadeToggle") {
                targets.hide();
            } else if (that.settings.hideMode === "basic") {
                targets.hide();
            }

        };
        that.toggle = function (expander, targets) {
            if (expander.hasClass("expanded")) {
                expander.toggleClass("collapsed expanded");
            }
            else {
                expander.toggleClass("expanded collapsed");
            }

            if (that.settings.hideMode === "fadeToggle") {
                targets.fadeToggle(300);
            } else if (that.settings.hideMode === "basic") {
                targets.toggle();
            }
            return false;
        };

        that.findTargets = function (expander, searchMode, targetSelector) {
            var targets = [];
            if (searchMode === "absolute") {
                targets = $(targetSelector);
            }
            else if (searchMode === "relative") {
                targets = that.findLevelOneDeep(expander, targetSelector, targetSelector);
            }
            else if (searchMode === "parent") {

                var parent = expander.parent();
                do {
                    targets = that.findLevelOneDeep(parent, targetSelector, targetSelector);

                    if (targets.length === 0) {
                        parent = parent.parent();
                    }
                } while (targets.length === 0 && parent.length !== 0);
            }
            return targets;
        };

        that.activate = function (jquery, options) {
            $.extend(that.settings, options);
            jquery.each(function () {
                var expander = $(this);

                var targetSelector = expander.attr("data-expander-target") || that.settings.defaultTarget;
                var searchMode = expander.attr("data-expander-target-search") || that.settings.defaultSearchMode;

                var targets = that.findTargets(expander, searchMode, targetSelector);

                if (targets.length === 0) {
                    if (that.settings.throwOnMissingTarget) {
                        throw "simple-expand: Targets not found";
                    }
                    return this;
                }

                expander.removeClass("expanded").addClass("collapsed");

                that.hideTargets(targets);

                expander.click(function () {
                    return that.toggle(expander, targets);
                });
            });
        };
    }

    var instance = new PlugIn();

    $.fn.simpleexpand = function (options) {
        instance.activate(this, options);
        return this;
    };

    $.fn.simpleexpand.fn = instance;

} ());
