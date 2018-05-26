(function() {

})();

// Flash messaging feature
(function() {
	// Вывод мгновенного сообщения
	window.showMessage = function(msg, type, duration = 3000) {
		var message = $('<div/>', {
		    class: 'flash-message flash-message--' + type,
		    text: msg
		});

		$(message).appendTo('body');

		setTimeout(function() {
			$(message).fadeOut(400);
		}, duration);
	}

	// usage
	window.showMessage('message', 'default');
})();