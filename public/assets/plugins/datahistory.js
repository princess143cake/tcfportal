/* Created by Raul */


$(function() {
	$('.repetitive').each(function() {
		field = $(this).attr('name').replace('edit_', '');
		form = $(this).closest('form').attr('id');
		$(this).attr('onfocus', 'return getDataHistory("'+field+'", "'+form+'")');
	});
});

function getDataHistory(field, form) {
	$.ajax({
		type: 'post',
		url: 'api/getDataHistory',
		data: {
			field: field
		},
		success: function(response) {
			$( ".repetitive" ).autocomplete({
	      		source: response,
	      		appendTo: '#'+form
		    });
		}
	});
}
	
function getRepetitive()
{
	repetitive = [];
	$('.repetitive').each(function() {
		field = $(this).attr('name').replace('edit_', '');
		value = $(this).val();

		repetitive.push({
			field: field,
			value: value
		});

	});

	return repetitive;
}

