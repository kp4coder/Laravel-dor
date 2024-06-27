@extends('front.layout')

@section('content')
<section>
	<div class="container">
		<!-- MultiStep Form -->
		<form id="msform" method="post" class="bookdor" name="bookdor" action="/book-dor">

			@csrf

			<!-- progressbar -->
			<ul id="progressbar">
				<li @if (!$errors->any()) class="active" @endif>Templates</li>
				<li>Measurements</li>
				<li>Extra Options</li>
				<li @if ($errors->any()) class="active" @endif >Summary</li>
			</ul>

			{{-- @if(session('success')) --}}
			<div role="alert" class="submitted-alert alert alert-success">
				<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="circle-check" class="svg-inline--fa fa-circle-check icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 32a224 224 0 1 1 0 448 224 224 0 1 1 0-448zm0 480A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM363.3 203.3c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0L224 297.4l-52.7-52.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l64 64c6.2 6.2 16.4 6.2 22.6 0l128-128z"></path></svg>
				<div class="alert-message submitted-alert-message">
					<strong>Success!</strong>
					<p class="mb-0" id="message">{{ session('success') }}</p>
				</div>
			</div>
			{{-- @endif --}}

			<!-- fieldsets -->
			<fieldset>
				<div class="row">
					@if (count($doorStyle)>0)
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">
								Style
							</div>
							<div class="card-body">
								@foreach($doorStyle as $dstyle)
								<div class="form-check custom-check-input form-check-inline">
									<input class="form-check-input" type="radio" name="style" id="{{ $dstyle->slug }}" value="{{ $dstyle->id }}" data-name="{{ $dstyle->name }}" data-value="{{ $dstyle->slug }}" {{ old('style') == $dstyle->name ? 'checked' : ($loop->first && !old('style') ? 'checked' : '') }}>
									<label class="form-check-label" for="{{ $dstyle->slug }}">
										<img src="{{ Voyager::image($dstyle->image) }}" alt="">
										<span>{{ $dstyle->name }}</span>
									</label>
							  	</div>
								@endforeach
							</div>
						</div>
					</div>
					@endif

					@if (count($doorType)>0)
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">
								Door Type
							</div>
							<div class="card-body">
								@foreach($doorType as $dtype)
								<div class="form-check custom-check-input form-check-inline">
									<input class="form-check-input" type="radio" name="door_type" id="{{ $dtype->slug }}" value="{{ $dtype->id }}" data-name="{{ $dtype->code }}" data-value="{{ $dtype->slug }}" {{ old('door_type') == $dtype->code ? 'checked' : ($loop->first && !old('door_type') ? 'checked' : '') }}>
									<label class="form-check-label" for="{{ $dtype->slug }}">
										<img src="{{ Voyager::image($dtype->image) }}" alt="">
										<span>{{ $dtype->name }}</span>
									</label>
								</div>
								@endforeach
							</div>
						</div>
					</div>
					@endif
				</div>

				@if (count($doorTemplate)>0)
				<div class="card">
					<div class="card-header">
						Templates
					</div>
					<div class="card-body">
						<div class="templates-card templates">
							@foreach($doorTemplate as $dtemplate)
							<div class="form-check custom-check-input form-check-inline {{ isset($dtemplate->doorStyle->slug) ? $dtemplate->doorStyle->slug : '' }} {{ isset($dtemplate->doorType->slug) ? $dtemplate->doorType->slug : '' }} ">
								<input class="form-check-input" type="radio" name="template" id="dt_{{$dtemplate->id}}" value="{{$dtemplate->id}}" data-measurements_field="{{$dtemplate->measurements_field}}" {{ $loop->first ? 'checked' : '' }}>
								<label class="form-check-label" for="dt_{{$dtemplate->id}}">
									<img src="{{ Voyager::image($dtemplate->image) }}" alt="">
								</label>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				@endif
				<input type="button" name="next" class="next action-button gotostep2" value="Next"/>
			</fieldset>
			<fieldset>	
				<div class="row">
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">
								Measurements
							</div>
							<div class="card-body" id="field_container">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="priview-img">
							<img alt="" class="messurements_preview" src="images/s2.png">
						</div>
					</div>
				</div>
				<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
				<input type="button" name="next" class="next action-button gotostep3" value="Next"/>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-md-6">
						@if(count($glassThickness)>0)
						<div class="card">
							<div class="card-header">
								Glass Thickness
							</div>
							<div class="card-body">
								@foreach($glassThickness as $gthickness)
								<div class="form-check custom-check-input form-check-inline">
									<input class="form-check-input" type="radio" name="thickness" value='{{ $gthickness->id }}' data-name='{{ $gthickness->name }}' data-value="thickness_{{ $gthickness->slug }}" id="thickness_{{ $gthickness->slug }}" {{ old('thickness') == $gthickness->name ? 'checked' : ($loop->first && !old('thickness') ? 'checked' : '') }}>
									<label class="form-check-label" for="thickness_{{ $gthickness->slug }}">
										<img src="{{ Voyager::image($gthickness->image) }}" alt="">
										<span>{{ $gthickness->name }}</span>
									</label>
								</div>
								@endforeach
							</div>
						</div>
						@endif

						@if(count($glassType)>0)
						<div class="card">
							<div class="card-header">
								Glass Type
							</div>
							<div class="card-body">
								<div class="card-type-boxs thicknesses">
									@foreach($glassType as $gtype)
										@php
											$gTypeClass = '';
											foreach($gtype->glassThickness as $gtypethickness):
												$gTypeClass.= ' thickness_' . $gtypethickness->slug;
											endforeach;
						                @endphp
									<div class="form-check custom-check-input form-check-inline {{ $gTypeClass }}">
										<input class="form-check-input" type="radio" name="glass_type" value="{{ $gtype->id }}" data-name="{{ $gtype->name }}"  data-value="{{ $gtype->slug }}" id="{{ $gtype->slug }}" {{ old('glass_type') == $gtype->name ? 'checked' : ($loop->first && !old('glass_type') ? 'checked' : '') }}>
										<label class="form-check-label" for="{{ $gtype->slug }}">
											<img src="{{ Voyager::image($gtype->image) }}" alt="">
											<span>{{ $gtype->name }}</span>
										</label>
									</div>
									@endforeach
								</div>
							</div>
						</div>
						@endif

						@if(count($hardwareFinish)>0)
						<div class="card">
							<div class="card-header">
								Hardware Finish
							</div>
							<div class="card-body">
								<div class="card-type-boxs">
									@foreach($hardwareFinish as $hfinish)
									<div class="form-check custom-check-input form-check-inline">
										<input class="form-check-input" type="radio" name="hardware" value='{{ $hfinish->id }}' data-name='{{ $hfinish->name }}' data-value="{{ $hfinish->slug }}" id="{{ $hfinish->slug }}" {{ old('hardware') == $hfinish->name ? 'checked' : ($loop->first && !old('hardware') ? 'checked' : '') }}>
										<label class="form-check-label" for="{{ $hfinish->slug }}">
											<img src="{{ Voyager::image($hfinish->image) }}" alt="">
											<span>{{ $hfinish->name }}</span>
										</label>
									</div> 
									@endforeach
								</div>	
							</div>
						</div>
						@endif

						@if(count($handle)>0)
						<div class="card">
							<div class="card-header">
								Handle
							</div>
							<div class="card-body">
								<div class="card-type-boxs handles">
									@foreach($handle as $hand)
										@php
											$hardwareSlugs = $hand->hardwareFinish->pluck('slug')->toArray();
                    						$hardwareClass = implode(' ', $hardwareSlugs);
										@endphp
									<div class="form-check custom-check-input form-check-inline {{ $hardwareClass }}">
										<input class="form-check-input" type="radio" name="handle" value='{{ $hand->id }}' data-name='{{ $hand->code }}' data-value="{{ $hand->slug }}" id="{{ $hand->slug }}" {{ old('handle') == $hand->code ? 'checked' : ($loop->first && !old('handle') ? 'checked' : '') }}>
										<label class="form-check-label" for="{{ $hand->slug }}">
											<img src="{{ Voyager::image($hand->image) }}" alt="">
										</label>
									</div>
									@endforeach
								</div>
							</div>
						</div>
						@endif
					</div>
					<div class="col-md-6">
						<input type="hidden" name="image_priview" id="image_priview" value="0" />
						<div class="priview-img glass_previews">
							<img class="glass_preview" src="images/s2.png" data-id="0" />
							@foreach($extraOptionImage as $image)
								<img alt="" src="{{ Voyager::image($image->image) }}" data-id="{{ $image->id }}" class="thickness_{{$image->glassThickness->slug}} {{$image->glassType->slug}} {{$image->hardwareFinish->slug}} {{$image->handle->slug}}" >
							@endforeach
						</div>
					</div>
				</div>
				<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
				<input type="button" name="next" class="next action-button gotostep4" value="Next"/>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">
								Summary
							</div>
							<div class="card-body">
								<table class="table">
									<tbody>
										<tr>
											<th>Style</th>
											<td><span id="style"></span></td>
										</tr>
										<tr>
											<th>Color</th>
											<td><span id="hardware"></span></td>
										</tr>
										<tr>
											<th>Handle</th>
											<td><span id="handle"></span></td>
										</tr>
										<tr>
											<th>Hinge</th>
											<td><span id="hinge"></span></td>
										</tr>
										<tr>
											<th>Glass Product</th>
											<td><span id="glass-product"></span></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="priview-img">
							<img alt="" class="dor_priview" src="images/s2.png">
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						Enter Your Details
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6 form-group">
								<label>Name</label>
								<input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
								@error('name') <span class="text-dager">{{ $message }}</span> @enderror
							</div>
							<div class="col-md-6 form-group">
								<label>Address</label>
								<input type="text" class="form-control" name="address" placeholder="Address" value="{{ old('address') }}">
								@error('address') <span class="text-dager">{{ $message }}</span> @enderror
							</div>
							<div class="col-md-6 form-group">
								<label>Phone</label>
								<input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone') }}">
								@error('phone') <span class="text-dager">{{ $message }}</span> @enderror
							</div>
							<div class="col-md-6 form-group">
								<label>City</label>
								<input type="text" class="form-control" name="city" placeholder="City" value="{{ old('city') }}">
								@error('city') <span class="text-dager">{{ $message }}</span> @enderror
							</div>
							<div class="col-md-6 form-group">
								<label>Email</label>
								<input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
								@error('email') <span class="text-dager">{{ $message }}</span> @enderror
							</div>
							<div class="col-md-6 form-group">
								<label>Zip</label>
								<input type="text" class="form-control" name="zip" placeholder="Zip" value="{{ old('zip') }}">
								@error('zip') <span class="text-dager">{{ $message }}</span> @enderror
							</div>
							<div class="col-md-12 form-group">
								<label>Comments</label>
								<textarea class="form-control" name="comments" placeholder="comments"> {{ old('comments') }}</textarea>
							</div>
						</div>
					</div>
				</div>
				<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
				<input type="Submit" name="Submit" class="submit action-button" value="Submit"/>
			</fieldset>
		</form>    	
	</div>
</section>

@endsection