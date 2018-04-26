<script type="text/javascript">
	function viewPost(idstory, title='') {
		var server_post = '{{ url("/box/") }}'+'/'+idstory+'/'+title;
		window.location = server_post;
	}
	function editPost(idstory) {
		var server_post = '{{ url("/box/") }}'+'/'+idstory+'/edit';
		window.location = server_post;
	}
	function organizedPost(idstory) {
		var server_post = '{{ url("/box/") }}'+'/'+idstory+'/designs';
		window.location = server_post;
	}
	function opQuestionPost(idstory) {
		opQuestion('open','Are you sure you want to delete this design ?', 'deletePost("'+idstory+'")');
	}
	function deletePost(idstory) {
		$.ajax({
			url: '{{ url("/box/delete") }}',
			type: 'post',
			data: {'idstory': idstory},
			beforeSend: function() {
				opQuestion('hide');
				open_progress('Deleting your design...');
			}
		})
		.done(function(data) {
			close_progress();
			if (data === 'success') {
				opAlert('open', 'This design has been deleted, to take effect try refresh this page.');
			} else {
				opAlert('open', 'Failed to delete this design.');
			}
		})
		.fail(function() {
			close_progress();
			opAlert('open', 'There is an error, please try again.');
		});
		
	}
	function opCommentPopup(stt, path, idcomment, title = '') {
		var id = '{{ Auth::id() }}';
		if (stt === 'open') {
			$('#'+path).show();
			if (id === iduser) {
				var menu = '<li onclick="opQuestion('+"'open'"+','+"'Delete this comment ?'"+','+"'deleteComment("+idcomment+")'"+')">Delete Comment</li>';
			} else {
				var menu = '<li onclick="opQuestion('+"'open'"+','+"'Delete this comment ?'"+','+"'deleteComment("+idcomment+")'"+')">Delete Comment</li>';
			}
			$('.content-popup .place-popup #val').html(menu);
		} else {
			$('#'+path).hide();
		}
	}
	function opPostPopup(stt, path, idstory, iduser, title = '') {
		var id = '{{ Auth::id() }}';
		if (stt === 'open') {
			$('#'+path).show();
			if (id === iduser) {
				var menu = '\
				<li onclick="organizedPost('+idstory+')">Organized Designs</li>\
				<li onclick="viewPost('+idstory+')">View Boxs</li>\
				<li onclick="editPost('+idstory+')">Edit Boxs</li>\
				<li onclick="opQuestionPost('+idstory+')">Delete Boxs</li>\
				';
			} else {
				var menu = '<li onclick="viewPost('+idstory+')">View Design<li>Report Design</li>';
			}
			$('.content-popup .place-popup #val').html(menu);
		} else {
			$('#'+path).hide();
		}
	}
	$(document).ready(function() {
		$('#menu-popup').on('click', function(event) {
			event.preventDefault();
			opPostPopup('close', 'menu-popup');
		});
	});
</script>
<div class="content-popup" id="menu-popup">
	<div class="place-popup">
		<ul>
		    <div id="val"></div>
		    <li class="btm" onclick="opPostPopup('close', 'menu-popup')">Exit</li>
		</ul>
	</div>
</div>