;(function ($) {
    'use strict';
    
	$.plugin('nnwebEmotionDices', {
		defaults: {
			dicesSelector: '.nnweb_emotion_dices'
		},
		init: function() {
			var me = this;
			me.applyDataAttributes();
	
			me._on(me.$el, 'mouseenter', $.proxy(me.onMouseEnter, me));
			me._on(me.$el, 'mouseleave', $.proxy(me.onMouseLeave, me));
			$.publish('plugin/nnwebEmotionDices/onInit', [ me ]);
		},
		destroy: function() {
			me._destroy();
		},
		onMouseEnter: function(event) {
			this.addClass( $(event.target), {x: event.pageX, y: event.pageY}, 'in' );
			$.publish('plugin/nnwebEmotionDices/onMouseEnter', [ this ]);
		},
		onMouseLeave: function(event) {
			this.addClass( $(event.target), {x: event.pageX, y: event.pageY}, 'out' );
			$.publish('plugin/nnwebEmotionDices/onMouseEnter', [ this ]);
		},
		addClass: function(obj, pos, state) {
			var direction = this.determineDirection(obj, pos),
			class_suffix = "";
	
			$(obj).removeClass('in-top in-bottom in-left in-right out-top out-bottom out-left out-right');
			
			switch (direction) {
				case 0 : class_suffix = '-top'; break;
				case 1 : class_suffix = '-right'; break;
				case 2 : class_suffix = '-bottom'; break;
				case 3 : class_suffix = '-left'; break;
			}
			
			$(obj).addClass(state + class_suffix);
		},
		determineDirection: function(obj, pos) {
			var w = obj.width(),
				h = obj.height(),
				x = (pos.x - obj.offset().left - (w/2)) * (w > h ? (h/w) : 1),
				y = (pos.y - obj.offset().top	- (h/2)) * (h > w ? (w/h) : 1);
	
			return Math.round((((Math.atan2(y,x) * (180/Math.PI)) + 180)) / 90 + 3) % 4;
		}
	});
	
	$(function() {
        StateManager.addPlugin('.nnweb_emotion_dices', 'nnwebEmotionDices');
        
        $.subscribe('plugin/swEmotionLoader/onLoadEmotionFinished', function () {
			window.StateManager.updatePlugin('.nnweb_emotion_dices', 'nnwebEmotionDices');
		});
    });
	
})(jQuery);