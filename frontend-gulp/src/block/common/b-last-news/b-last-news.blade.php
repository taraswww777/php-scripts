@block('b-last-news')

<?php
/**
 * @var array $posts
 * @var WP_Post $postItem
 */
?>

@if($newsList)
	<div class="@blockName()">
		@foreach($newsList as $newsItem)
			<div class="@elem('item')">
			<a class="@elem('item-link')" href="{{$newsItem['LINK']}}">
				@if($newsItem['IMAGE_URL'])
					<div class="@elem('item-wrapper-img')">
						<img class="@elem(item-img)" src="{{$postItem['IMAGE_URL']}}">
					</div>
				@endif
				<div class="@elem('item-wrapper-info')">
					<div class="@elem('item-title')">{{$newsItem['NAME']}}</div>
				</div>
			</a>
			</div>
		@endforeach
	</div>
@endif
