/**
* jQuery Touchdown Plugin <https://github.com/samuelcotterall/Touchdown>
* 
* By Samuel Cotterall <http://samuelcotterall.com>
*/
(function($) {

	$.fn.Touchdown = function() {

		return this.each(function() {

			$this = $(this);
			
			var listDepth = $this.parents().length,
				anchor = $this.find('a'),
				title = 'Navigation',
				optionList;
			
			// Create a default `<option>` for the list - If this is missing, fall back to 'Select'
			if ($this.attr('title')) {
				title = $this.attr('title');
			} 
			
			optionList += '<option value="">' + title + '</option>';																	
			
			// Convert each anchor to an `<option>`
			for (var i=0; i < anchor.length; i++) {
				
				var a = $(anchor[i]), 										// Current <a>
					linkDepth = ((a.parents().length - listDepth) / 2) - 1, // Current <a>'s depth minus main list's depth divided by 2 (account for both <ul> and <li> parents) minus 1
					indent = '';											// Reset indent
					
				while (linkDepth > 0){										// Append a space for each level
					indent += '';
					linkDepth--;
				}

				optionList += '<option value="' + a.attr('href') + '">' + indent + a.text() + '</option>';				
			
			}

			// DOM manipulation
			$this.addClass('touchdown-list').after('<select class="touchdown"> ' + optionList +'</select>');

			// Event handler
			$this.next('select').change(function(){
				window.location = $(this).val();
			});

		});
		
	};
	
})(jQuery);
 
(function($) {

    $.fn.horizontalNav = function(options) {

        var opts = $.extend({}, $.fn.horizontalNav.defaults, options);
        return this.each(function() {

            function trueInnerWidth(element) {

                return element.innerWidth() - (parseInt(element.css("padding-left")) + parseInt(element.css("padding-right")));
            }
            function resizeTrigger(callback, delay) {

                delay = delay || 100;
                var resizeTimer;
                $(window).resize(function() {

                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {

                        callback();
                    }, delay);
                });
            }
            function _construct() {

                if (o.tableDisplay != 1 || $.browser.msie && parseInt($.browser.version, 10) <= 7) {

                    ul.css({

                        "float": "left"
                    });
                    li.css({

                        "float": "left",
                        width: "auto"
                    });
                    li_a.css({

                        "padding-left": 0,
                        "padding-right": 0
                    });
                    var ul_width = trueInnerWidth(ul), ul_width_outer = ul.outerWidth(!0), ul_width_extra = ul_width_outer - ul_width, full_width = trueInnerWidth(ul_wrap), extra_width = full_width - ul_width_extra - ul_width, li_padding = Math.floor(extra_width / li_count);
                    li.each(function(index) {

                        var li_width = trueInnerWidth($(this));
                        $(this).css({

                            width: li_width + li_padding + "px"
                        });
                    });
                    var li_last_width = trueInnerWidth(li_last) + (full_width - ul_width_extra - trueInnerWidth(ul));
                    if ($.browser.mozilla || $.browser.msie) li_last_width -= 1;
                    li_last.css({

                        width: li_last_width + "px"
                    });
                } else {

                    ul.css({

                        display: "table",
                        "float": "none",
                        width: "100%"
                    });
                    li.css({

                        display: "table-cell",
                        "float": "none"
                    });
                }
            }
            var $this = $(this), o = $.meta ? $.extend({}, opts, $this.data()) : opts;
            if ($this.is("ul")) var ul_wrap = $this.parent(); else var ul_wrap = $this;
            if ($(".clearHorizontalNav").length) ul_wrap.css({

                zoom: "1"
            }); else {

                ul_wrap.css({

                    zoom: "1"
                }).append('<div class="clearHorizontalNav">');
                $(".clearHorizontalNav").css({

                    display: "block",
                    overflow: "hidden",
                    visibility: "hidden",
                    width: 0,
                    height: 0,
                    clear: "both"
                });
            }
            var ul = $this.is("ul") ? $this : ul_wrap.find("> ul"), li = ul.find("> li"), li_last = li.last(), li_count = li.size(), li_a = li.find("> a");
            o.responsive === !0 && (o.tableDisplay != 1 || $.browser.msie && parseInt($.browser.version, 10) <= 7) && resizeTrigger(_construct, o.responsiveDelay);
            _construct();
        });
    };
    $.fn.horizontalNav.defaults = {

        responsive: !0,
        responsiveDelay: 100,
        tableDisplay: !0
    };
})(jQuery);