

var MessageDialog = (function() {
    "use strict";
	var $time    = Date.now();
	var $body = $('body');
    var $this = {};
	
	var template =
			'<div aria-hidden="true" class="modal modal-va-middle fade" id="ui_dialog_message" role="dialog" tabindex="-1">' +
				'<div class="modal-dialog modal-xs">' +
					'<div class="modal-content">' +
						'<div class="modal-heading">' +
							'<p class="modal-title"></p>' +
						'</div>' +
						'<div class="modal-inner">' +
							'<p class="h5 margin-top-sm text-black-hint modal-body"></p>' +
						'</div>' +
						'<div class="modal-footer">' +
							'<p class="text-right">' +
								'<a class="btn btn-flat btn-brand waves-attach" data-dismiss="modal" id="confirm-button">Confirm</a>'+
								'<a class="btn btn-flat btn-brand-accent waves-attach" data-dismiss="modal">Cancel</a>'+
							'</p>' +
						'</div>' +
					'</div>' +
				'</div>' +
			'</div>';
	
	$this.init = function(options){
		if (options.id && typeof options.id !=='undefined') {
			$this.modal_id = options.id;
		}else{
			$this.modal_id = 'ui_dialog_message';
		}
		
		$this.dialog = $('#' + $this.modal_id);
		$($this.dialog).find("#confirm-button").hide();
		
	};
	
    $this.show = function(options) {
		$this.showConfirm = false;
		$this.pop(options);  
	};
	$this.confirm = function(options) {
		$this.showConfirm = true;
		$this.pop(options);  
	};
	
	$this.pop = function(options) {
		$this.init(options);
		$($this.dialog).find(".modal-title").html(options.title);
		$($this.dialog).find(".modal-body").html(options.message);
		if($this.showConfirm === true){
			$($this.dialog).find("#confirm-button").show();
		}else{
			//$($this.modal).find("#confirm-button").hide();
		}
		$this.dialog.modal('show');
		
		/*
		if($this.showConfirm === true){
			if (options.callback && !$.isFunction(options.callback)) {
				throw new Error("alert requires callback property to be a function when provided");
			}
			
			$($this.modal,'#confirm-btn').on('click', function(event) {
				$this.modal.modal('hide');
				if(typeof options.callback == 'function'){
					options.callback.call($this.modal);
				}
			});		
		}
		*/
	};
		
		
	/* Check if  '#ui_dialog_message' id */
	if($('#ui_dialog_message').length){		
	}else{
		/* create dialog */
		$body.append(template);
	}
	
	function defaultCallback(target){
		window.location = $(target).attr('href');
    }
    return $this;
}());

MessageDialog.init({id:'ui_dialog_message'});
