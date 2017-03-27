$(function() {
	
	$('#commentform1, #commentform2').submit(function( e ) {
		e.preventDefault();
		$.ajax({
			headers: {
				Accept : "application/json"
			},
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: $(this).serialize(),
			error: function( data ) {
				$(this).prepend('<p>Echec</p>');
			},
			success: function( data ) {
				console.log(data);
				//$('#commentList').append(data);
			}
			
		});
	});
	
});