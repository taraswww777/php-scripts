@block('%block-name%')
@if($why)
	@foreach($why as $whyItem)
	<section class="@blockName()">
		<h2 class="@elem('title')">{{$whyItem['archive-product:why:title']}}</h2>
		@if($whyItem['archive-product:why:answers'])
			<div class="@elem('answers')">
				@foreach($whyItem['archive-product:why:answers'] as $answersItem)
					<div class="@elem('answers-item')">
						@if($answersItem['archive-product:why:answers-icon'])
						<span class="@elem('answers-item-icon',$answersItem['archive-product:why:answers-icon'])"></span>
						@endif
						<p class="@elem('answers-item-text')">{{$answersItem['archive-product:why:answers-text']}}</p>
					</div>
				@endforeach
			</div>
		@endif
	</section>
	@endforeach
@endif
