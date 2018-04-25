@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<script type="text/javascript">
    function editBox() {
		var fd = new FormData();
        var idboxs = $('#idboxs').val();
		var title = $('#title-box').val();
		var content = $('#write-box').val();

        fd.append('idboxs', idboxs);
		fd.append('title', title);
		fd.append('content', content);
		$.each($('#form-publish').serializeArray(), function(a, b) {
		   	fd.append(b.name, b.value);
		});

		$.ajax({
		  	url: '{{ url("/box/save/editing") }}',
			data: fd,
			processData: false,
			contentType: false,
			type: 'post',
			beforeSend: function() {
				open_progress('Editing your box...');
			}
		})
		.done(function(data) {
		   	if (data == "failed") {
		   		opAlert('open', 'failed to edit your box, the data still seem with previous content.');
		   		close_progress();
		   	} else {
		   		$('#title-box').val('');
				$('#write-box').val('');
				close_progress();
				window.location = '{{ url("/box/") }}'+'/'+data;
		   	}
		   	//console.log(data);
		})
		.fail(function(data) {
		  	opAlert('open', "there is an error, please try again.");
		   	//console.log(data.responseJSON);
		})
		.always(function() {
			close_progress();
		});

		return false;
	}
    $(document).ready(function() {
        $('#write-box').keyup(function(event) {
			var length = $(this).val().length;
			$('#desc-lg').html(length);
			
		});
    });
</script>
@foreach ($box as $bx)
<form id="form-publish" method="post" action="javascript:void(0)" enctype="multipart/form-data" onsubmit="editBox()">
	<div class="sc-header">
		<div class="sc-place pos-fix">
			<div class="col-700px">
				<div class="sc-grid sc-grid-3x">
					<div class="sc-col-1">
						<button class="btn btn-circle btn-primary-color btn-focus" onclick="goBack()" type="button">
							<span class="fa fa-lg fa-arrow-left"></span>
						</button>
					</div>
					<div class="sc-col-2">
						<h3 class="ttl-head ttl-sekunder-color">Edit Box</h3>
					</div>
					<div class="sc-col-3 txt-right">
						<input type="submit" name="save" class="btn btn-main-color" value="Save" id="btn-publish">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="compose" id="create">
		<div class="main col-700px">
			<div class="create-body edit">
				<div class="create-mn">
                    <div class="create-block">
                        <div>
                            <input type="hidden" name="idboxs" id="idboxs" value="{{ $bx->idboxs }}" required="true">
                        </div>
                        <div class="block-field place-tags">
                            <div class="pan">
                                <div class="left">
                                    <p class="ttl">Box Title</p>
                                </div>
                                <div class="right"></div>
                            </div>
                            <div class="block-field">
                                <input type="text" name="title" id="title-box" class="tg txt txt-main-color txt-box-shadow" placeholder="Title" value="{{ $bx->title }}" required="true">
                            </div>
                        </div>
                        <div class="block-field">
                            <div class="pan">
                                <div class="left">
                                    <p class="ttl">Box Description</p>
                                </div>
                                <div class="right">
                                    <div class="count">
                                        <span id="desc-lg">0</span>/250
                                    </div>
                                </div>
                            </div>
                            <textarea name="write-box"
                            id="write-box"
                            class="txt edit-text txt-main-color txt-box-shadow ctn ctn-main ctn-sans-serif"
                            maxlength="250"
                            placeholder="Description">{{ $bx->description }}</textarea>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</form>
@endforeach
@endsection