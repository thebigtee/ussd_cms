jQuery(function() {
	jQuery('.datepicker1').datetimepicker({
		pickTime: false,
		useCurrent: false,
		useStrict: true,
		format: 'DD-MM-YYYY'
	});
	jQuery('.datetimepicker1').datetimepicker({
		pickTime: true,
		useCurrent: false,
		useStrict: true,
		format: 'DD-MM-YYYY hh:mm A'
	});

	// hide selects that only have one choice
	/*jQuery.each(jQuery('select'), function(i, e) {
		var OptionCount = jQuery(e).find("option").length;

		if (OptionCount > 1) {
			jQuery(e).show();
			jQuery(e).parent().show();
		} else {
			jQuery(e).hide();
			jQuery(e).parent().hide();
		}
	});*/

	// tooltips
	jQuery('input, textarea, select').each(function(index, element){
		jQuery(element).attr('placeholder', jQuery(element).attr('title'));
	});
	// jQuery(document).tooltip({ selector: 'input, textarea, select, button', 'placement': 'top' });
	jQuery(document).tooltip({'selector': 'input, textarea, select, button, span, a', 'placement': 'top', 'container': 'body', 'html': true});

	// refresh buttons
	jQuery('.ajaxRefresh')
	.click(function(){
		var ajaxTarget = jQuery(this).attr('target');
		var ajaxAction = jQuery(ajaxTarget).attr('action');
		var data = {
			'action': ajaxAction
		};

		ajaxRequest(ajaxTarget, data);
	});

	// page load ajax grab
	jQuery('.ajaxBlock')
	.each(function(index, element){
		var ajaxTarget = '#' + jQuery(element).attr('id');
		var ajaxAction = jQuery(ajaxTarget).attr('action');
		var data = {
			'action': ajaxAction
		};

		ajaxRequest(ajaxTarget, data);
	});

	// Ajax form submit
	jQuery(".ajaxform").submit(function(e) {
		e.preventDefault(); //STOP default action

		var ajaxTarget = jQuery(this).parents('.ajaxBlock').attr('id');
		var ajaxAction = jQuery(this).parents('.ajaxBlock').attr('action');

		jQuery.ajax({
			// url: "/" + jQuery('#' + ajaxTarget).attr('controller') + "/process",
			// url : formURL,
			type: "POST",
			data : jQuery(this).serializeArray(),
			beforeSend: function(){
				// display loading overlay
				jQuery('#' + ajaxTarget + ' .overlay').show();
				jQuery('#' + ajaxTarget + ' .result').hide();
			},
			complete: function(){
				ajaxRequest('#' + ajaxTarget, {'action':ajaxAction});
			},
			success:function(data, textStatus, jqXHR) {
				//data: return data from server
			},
			error: function(jqXHR, textStatus, errorThrown) {
				//if fails
			}
		});
	});
});

/* function to be used in loading ajax data */
function ajaxRequest(ajaxTarget, data) {
	// request data
	jQuery.ajax({
		// url: "/" + jQuery(ajaxTarget).attr('controller') + "/process",
		type: "POST",
		data: data,
		beforeSend: function(){
			// display loading overlay
			jQuery(ajaxTarget + ' .overlay').show();
			jQuery(ajaxTarget + ' .result').hide();
		},
		complete: function(){
			// hide loading overlay
			jQuery(ajaxTarget + ' .overlay').hide();
		},
		success: function(jsonData){
			if (jsonData.error == '1') {
				// display message
				if (jsonData.msg != undefined && jsonData.msg != '') {
					// jQuery(ajaxTarget + ' .result').html('<p class="alert alert-danger">' + jsonData.msg + '</p>');
					jQuery(ajaxTarget + ' .result').html(jsonData.msg);
					jQuery(ajaxTarget + ' .result').show();
				}
			} else {
				// display message
				if (jsonData.msg != undefined && jsonData.msg != '') {
					// jQuery(ajaxTarget + ' .result').html('<p class="alert alert-success">' + jsonData.msg + '</p>');
					jQuery(ajaxTarget + ' .result').html(jsonData.msg);
					jQuery(ajaxTarget + ' .result').show();
				}

				// data
				jQuery(ajaxTarget + ' .data').show();

				// function name and parameters to pass
				// find object
				var fn = window[jsonData.fn];
				// is object a function?
				if (typeof fn === "function") {
					fn(jsonData, ajaxTarget);
				}
			}
		},
		error: function(){
			// display message
			jQuery(ajaxTarget + ' .result').html('<p class="alert alert-danger">Unable to retrive data, please reload!</p>');
			jQuery(ajaxTarget + ' .result').show();

			// data
			jQuery(ajaxTarget + ' .data').hide();
		},
		dataType: 'json'
	});
}

function toggleSelectOptions(objTarget, nameCurrent, nameSelected, selected, arrayCompare) {
	if (selected > 0) { // added to avoid error when not set
		jQuery(objTarget + ' option').css('display', 'none');

		jQuery.each(jQuery(objTarget + ' option'), function(i, e) {
			var current = jQuery(e).attr('value');
			if (current == '') {
				jQuery(e)
					.css('display', '');
				jQuery(e)
					.attr('selected', 'selected');
			}

			for (var i = arrayCompare.length - 1; i >= 0; i--) {
				if (arrayCompare[i][nameCurrent] == current) {
					if (arrayCompare[i][nameSelected] == selected) {
						jQuery(e)
							.css('display', '');
						jQuery(e)
							.removeAttr('selected');
					}
				}
			}
		});
	}
}


/*!
 * IE10 viewport hack for Surface/desktop Windows 8 bug
 * Copyright 2014-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

// See the Getting Started docs for more information:
// http://getbootstrap.com/getting-started/#support-ie10-width

(function () {
  'use strict';

  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style')
    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    )
    document.querySelector('head').appendChild(msViewportStyle)
  }

})();
