@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						@if (Auth::user())
							<persone-details imdb_id="{{ $video['imdb_id'] }}" user_token="{{ Auth::user()->api_token }}"></persone-details>
						@else
							<persone-details imdb_id="{{ $video['imdb_id'] }}" user_token="Null"></persone-details>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
