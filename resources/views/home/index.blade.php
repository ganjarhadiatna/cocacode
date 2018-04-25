@extends('layout.index')
@section('title',$title)
@section('path', $path)
@section('content')
<div>
	@if (count($topStory) == 0)
		@include('main.post-empty')	
	@else
		<div class="post">
			@foreach ($topStory as $story)
				@include('main.post')
			@endforeach
		</div>
		{{ $topStory->links() }}
	@endif
</div>
@endsection