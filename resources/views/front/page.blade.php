@extends('front.layout')


@section('content')
<section>
	<div class="container">
		<!-- MultiStep Form -->
		<div id="msform">
			<h1>{{ $page->title }}</h1>
			<hr/>
			<h2>{!! $page->excerpt !!}</h2>

			<div class="page-desc" >
				<img src="{{ Voyager::image($page->image) }}"  />
				{!! $page->body !!}
			</div>
		</div>
	</div>
</section>

@endsection