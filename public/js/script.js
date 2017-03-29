$( function() {
	
	$( '.js-form-comment' ).submit( function( e ) {
		e.preventDefault();
		var $this        = $( this );
		var contentvalue = $( "[name='content']", this ).val().trim();
		var authorvalue  = $( "[name='author']", this ).val();
		if ( authorvalue === undefined ) {
			authorvalue = "something";
		}
		else {
			authorvalue = authorvalue.trim();
		}
		var formserialize = $( this ).serialize();
		$( 'input[type="submit"]', $( '.js-form-comment' ) ).prop( 'disabled', true );
		$.each( $( this ).serializeArray(), function( k, v ) {
			console.log( v );
			if ( v.value == "" ) {
				console.log( $( this ) );
				$( '[name="' + v.name + '"]', $this ).after( 'Fail' );
			}
		} );
		if ( contentvalue.length != 0 && authorvalue.length != 0 ) {
			$( "[name='content'], [name='author']", this ).val( '' );
			var rand = 1 + Math.floor( Math.random() * 100 );
			$.ajax( {
				type     : $( this ).attr( 'method' ),
				url      : $( this ).attr( 'data-action' ),
				data     : formserialize,
				error    : function( data, status, error ) {
					console.log( data, status, error );
					if ( data.status == 0 ) {
						$this.parent().prepend( $( '<p class="msg-flash' + rand + '">' + data.statusText + '</p>' ).hide().fadeIn() );
						setTimeout( function() {
							$( '.msg-flash' + rand ).fadeOut( '400', function() {
								$( this ).remove();
							} );
						}, 3000 );
					}
					else {
						$.each( data.responseJSON.content.errors, function( key, value ) {
							$this.parent().prepend( $( '<p class="msg-flash' + rand + '">' + value + '</p>' ).hide().fadeIn() );
						} );
						$this.parent().prepend( $( '<h4 class="msg-flash' + rand + '">Erreur :</h4>' ).hide().fadeIn() );
						setTimeout( function() {
							$( '.msg-flash' + rand ).fadeOut( '400', function() {
								$( this ).remove();
							} );
						}, 3000 );
					}
				},
				success  : function( data ) {
					addComment( data.content.comment, data.content.comment_author, data.content.routes );
					$( '#commentList' )
						.prepend( $( '<p class="msg-flash' + rand + '">Commentaire ajouté</p>' ).hide().fadeIn() )
						.append( $( '<p class="msg-flash' + rand + '">Commentaire ajouté</p>' ).hide().fadeIn() );
					setTimeout( function() {
						$( '.msg-flash' + rand ).fadeOut( '400', function() {
							this.remove();
						} );
					}, 3000 );
				},
				complete : function( data ) {
					$( 'input[type="submit"]', $( '.js-form-comment' ) ).prop( 'disabled', false );
				}
			} );
		}
		$( 'input[type="submit"]', $( '.js-form-comment' ) ).prop( 'disabled', false );
	} );
	
	$( '#commentList' ).on( "click", ".js-delete-comment", function( e ) {
		e.preventDefault();
		var rand = 1 + Math.floor( Math.random() * 100 );
		$.ajax( {
			type    : 'POST',
			url     : $( this ).attr( 'data-action' ),
			error   : function( data ) {
				$( '#commentList' )
					.prepend( $( '<p class="msg-flash' + rand + '">' + data.responseJSON.content.errors + '</p>' ).hide().fadeIn() )
					.append( $( '<p class="msg-flash' + rand + '">' + data.responseJSON.content.errors + '</p>' ).hide().fadeIn() );
				$( "fieldset[data-id=" + data.responseJSON.content.comment_id + "]" ).remove();
				setTimeout( function() {
					$( '.msg-flash' + rand ).fadeOut( '400', function() {
						this.remove();
					} );
				}, 3000 );
			},
			success : function( data ) {
				deleteComment( data.content.comment_id, rand );
			}
			
		} );
	} );
	
	function addComment( comment, author, routes ) {
		console.log('addComment');
		var linksHTML   = ' - ' + '<a href="{{comment_update_route}}">{{comment_update}}</a> | ' + '<a href="{{comment_delete_route}}" class="js-delete-comment" data-action="{{comment_delete_route_json}}">{{comment_delete}}</a> ';
		var commentHTML = '<fieldset data-id="{{comment_id}}">' + '<legend>Posté par <strong>{{comment_author}}</strong> le {{comment_date}}' + '{{links}}' + '</legend>' + '<p class="comment content">{{comment_content}}</p> ' + '</fieldset>';
		var date        = new Date( comment.dateadd.date );
		var datestring  = ("0" + date.getDate()).slice( -2 ) + '/' + ("0" + date.getMonth()).slice( -2 ) + '/' + date.getFullYear() + ' à ' + ("0" + date.getHours()).slice( -2 ) + 'h' + ("0" + date.getMinutes()).slice( -2 );
		commentHTML     = commentHTML.replace( '{{comment_id}}', comment.id );
		commentHTML     = commentHTML.replace( '{{comment_author}}', comment.author ? comment.author : author );
		commentHTML     = commentHTML.replace( '{{comment_date}}', datestring );
		commentHTML     = commentHTML.replace( '{{comment_content}}', comment.content );
		if ( routes.length != 0 ) {
			commentHTML = commentHTML.replace( '{{links}}', linksHTML );
			commentHTML = commentHTML.replace( '{{comment_update}}', routes.update_text );
			commentHTML = commentHTML.replace( '{{comment_update_route}}', routes.update );
			commentHTML = commentHTML.replace( '{{comment_delete}}', routes.delete_text );
			commentHTML = commentHTML.replace( '{{comment_delete_route}}', routes.delete );
			commentHTML = commentHTML.replace( '{{comment_delete_route_json}}', routes.delete_json );
		}
		else {
			commentHTML = commentHTML.replace( '{{links}}', '' );
		}
		if ( $( '#commentList' ).children().length == 0 ) {
			$( '#commentList' ).fadeIn();
			$( '.js-form-comment' ).last().parent().fadeIn();
			$( '.nocomment' ).fadeOut();
		}
		$( '#commentList' ).append( commentHTML );
	}
	
	function updateComment( comment ) {
		console.log('upadteComment');
		$( "fieldset[data-id=" + comment.id + "]" ).find('.comment.content').replaceWith( comment.content ).hide().fadeIn();
		var date        = new Date( comment.dateupdate.date );
		var datestring  = ("0" + date.getDate()).slice( -2 ) + '/' + ("0" + date.getMonth()).slice( -2 ) + '/' + date.getFullYear() + ' à ' + ("0" + date.getHours()).slice( -2 ) + 'h' + ("0" + date.getMinutes()).slice( -2 );
		$( "fieldset[data-id=" + comment.id + "]" ).find('legend').append( datestring ).hide().fadeIn();
	}
	
	function deleteComment( comment, rand ) {
		console.log('deleteComment');
		$( "fieldset[data-id=" + comment + "]" ).replaceWith( $( '<p class="msg-flash' + rand + '">Commentaire supprimé</p>' ).hide().fadeIn() );
		setTimeout( function() {
			$( '.msg-flash' + rand ).fadeOut( '400', function() {
				this.remove();
			} );
			var commentList = $( '#commentList' );
			if ( commentList.children( '[data-id]' ).length == 0 ) {
				commentList.fadeOut( '400', function() {
					commentList.addClass( 'hidden' );
				} );
				var jsform = $( '.js-form-comment' );
				jsform.last().parent().fadeOut( '400', function() {
					jsform.last().parent().addClass( 'hidden' );
				} );
				var nocomment = $( '.nocomment' );
				nocomment.fadeIn( '400', function() {
					nocomment.removeClass( 'hidden' );
				} );
			}
		}, 3000 );
	}
	
	setInterval( function() {
		var $e = $('#commentList');
		var data = {};
		data.ids = $e.children().map( function() {
			return $( this ).data( 'id' )
		} ).toArray();
		data.date = $e.data('update');
		$.ajax( {
			type    : 'POST',
			url     : $e.data( 'action' ),
			data    : data,
			error   : function( data ) {
				
			},
			success : function( data ) {
				refreshComment( data.content );
			}
			
		} );
	}, 15000 );
	function refreshComment( content ) {
		insertComment_a(content.comment_new_a, content.comment_new_author_a, content.route_a);
		updateComment_a(content.comment_update_a);
		deleteComment_a(content.comment_delete_a);
		var dateupdate = new Date();
		$('#commentList').data('update', dateupdate.valueOf());
	}
	function insertComment_a( comment_a, comment_author_a, route_a ) {
		$(comment_a).each(function( k, v ) {
			addComment(v, comment_author_a[v.id], route_a[v.id])
		})
	}
	function updateComment_a( comment_a ) {
		$(comment_a).each(function( k, v ) {
			updateComment(v);
		})
	}
	function deleteComment_a( comment_a ) {
		$(comment_a).each(function( k, v ) {
			deleteComment(v, k);
		})
	}
} );