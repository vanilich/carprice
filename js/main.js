(function() {
	reset();

	function updateTable() {
		$.post({
			url: 'table',
			method: 'POST',
			data: data,
			beforeSend: function() {
				$('.js-apply, .js-reset').attr('disabled', true);
				$('.js-apply i').show();

			},

			complete: function() {

			},

			success: function(data) {
				$('.js-table-container').html(data);

				$('.js-apply, .js-reset').attr('disabled', false);
				$('.js-apply i').hide();
			}
		})
	}

	function reset() {
		window.data = {};

		window.data['mark'] = 0;
		window.data['model'] = 0;
		window.data['shop'] = [];
		window.data['city'] = [];
	}

	$(document).ready(function() {
		updateTable();
	});

	// Выбор марки авто
	$('.js-select-mark').change(function() {
		var id = $(this).val();

		window.data['mark'] = id;

		var str = '<option value="0">Любая</option>';
		$.ajax({
			method: 'GET',
			url: 'model/' + id,
			success: function(data) {
				for(var item in data) {
					$('.js-select-model').html('');

					var id = data[item]['id'];
					var name = data[item]['name'];

					str = str + '<option value="' + id + '">' + name + '</option>';
				}

				$('.js-select-model').html(str);
			}			
		})
	});

	// Выбор модели авто
	$('.js-select-model').change(function() {
		var id = $(this).val();

		window.data['model'] = id;
	});

	// Выбор магазина
	$('input[name="shop"]').click(function() {
		var values = [];
		$('input[name="shop"]:checked').each(function() {
			values.push( $(this).val() );
		});

		window.data['shop'] = values;
	});

	// Выбор города
	$('input[name="city"]').click(function() {
		var values = [];
		$('input[name="city"]:checked').each(function() {
			values.push( $(this).val() );
		});

		window.data['city'] = values;
	});	

	$('.js-apply').click(function() {
		updateTable();
	});

	$('.js-reset').click(function() {
		$('.js-select-model').html('<option value="0">Любая</option>');

		$('input[type=checkbox]').prop('checked',false);

		reset();
		updateTable();
	});	
})();