<div class="frame-post">
	<div class="mid">
		<div class="bot-tool">
			<div class="nts">
				<button class="zoom btn btn-circle btn-sekunder-color btn-no-border" onclick="pictZoom({{ $story->idstory }})">
					<span class="fas fa-lg fa-search-plus"></span>
				</button>
			</div>
			<div class="bok">
				@if (is_int($story->is_save))
					<button class="btn btn-circle btn-main-color btn-no-border"
						id="bookmark-{{ $story->idstory }}" 
						title="Remove from box?" 
						onclick="removeBookmark('{{ $story->is_save }}','{{ $story->idstory }}')">
						<span class="fas fa-lg fa-bookmark" id="ic"></span>
					</button>
				@else
					<button class="btn btn-circle btn-main-color btn-no-border" 
						id="bookmark-{{ $story->idstory }}"
						title="Save to box?" 
						onclick="opSave('open','{{ $story->idstory }}')">
						<span class="far fa-lg fa-bookmark" id="ic"></span>
					</button>
				@endif
			</div>
		</div>
		<div class="mid-tool">
			<a href="{{ url('/design/'.$story->idstory) }}">
				<div class="cover"></div>
				<img src="{{ asset('/story/thumbnails/'.$story->cover) }}" alt="pict" id="pict-{{ $story->idstory }}" key="{{ $story->idstory }}">
			</a>
		</div>
	</div>
	<div class="desc ctn-main-font">
		{{ $story->description }}
	</div>
</div>