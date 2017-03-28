$(function() {
	
	$('.js-form-comment').submit(function( e ) {
		e.preventDefault();
		if ($("[name='content']").val().length != 0){
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('data-action'),
			data: $(this).serialize(),
			error: function( data, status, error ) {
				console.log(data);
				console.log(status);
				console.log(error);
				$('#commentList').prepend('<p id="flash">'+data.responseJSON.content.errors+'</p>').append('<p id="flash">'+data.responseJSON.content.errors+'</p>');
				setTimeout(function() {
					$('#flash').remove();
				}, 3000);
			},
			success: function( data ) {
				addComment(data.content.comment, data.content.comment_author, data.content.routes);
				$('#commentList').prepend('<p id="flash">Commentaire ajouté</p>').append('<p id="flash">Commentaire ajouté</p>');
				$("[name='content']").val('');
				setTimeout(function() {
					$('#flash').remove();
				}, 3000);
			}
			
		});
		}
	});
	
	$('.js-delete-comment').click(function( e ) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: $(this).attr('data-action'),
			error: function( data ) {
				$('#commentList').prepend('<p id="flash">'+data.responseJSON.content.errors+'</p>');
				$("fieldset[data-id=" + data.responseJSON.content.comment_id + "]").remove();
				setTimeout(function() {
					$('#flash').remove();
				}, 3000);
			},
			success: function( data ) {
				console.log(data);
				$("fieldset[data-id=" + data.content.comment_id + "]").replaceWith('<p id="flash">Commentaire supprimé</p>');
				setTimeout(function() {
					$('#flash').remove();
				}, 3000);
			}
			
		});
	});
	
	function addComment( comment, author, routes ) {
		var linksHTML = ' - ' +
			'<a href="{{comment_update_route}}">{{comment_update}}</a> | ' +
			'<a href="{{comment_delete_route}}" data-action="{{comment_delete_route_json}}">{{comment_delete}}</a> ';
		var commentHTML = '<fieldset data-id="{{comment_id}}">'+
			'<legend>Posté par <strong>{{comment_author}}</strong> le {{comment_date}}' +
			'{{links}}' +
			'</legend>' +
				'<p class="comment content">{{comment_content}}</p> ' +
				'</fieldset>';
		var date = new Date(comment.dateadd.date);
		var datestring = ("0"+date.getDate()).slice(-2)+'/'+("0"+date.getMonth()).slice(-2)+'/'+date.getFullYear()+' à '+("0"+date.getHours()).slice(-2)+'h'+("0"+date.getMinutes()).slice(-2);
		commentHTML = commentHTML.replace('{{comment_id}}', comment.id);
		commentHTML = commentHTML.replace('{{comment_author}}', comment.author ? comment.author : author);
		commentHTML = commentHTML.replace('{{comment_date}}', datestring);
		commentHTML = commentHTML.replace('{{comment_content}}', comment.content);
		if (routes) {
			commentHTML = commentHTML.replace('{{links}}', linksHTML);
			commentHTML = commentHTML.replace('{{comment_update}}', routes.update_text);
			commentHTML = commentHTML.replace('{{comment_update_route}}', routes.update);
			commentHTML = commentHTML.replace('{{comment_delete}}', routes.delete_text);
			commentHTML = commentHTML.replace('{{comment_delete_route}}', routes.delete);
			commentHTML = commentHTML.replace('{{comment_delete_route_json}}', routes.delete_json);
		}
		$('#commentList').append(commentHTML);
	}
	
});