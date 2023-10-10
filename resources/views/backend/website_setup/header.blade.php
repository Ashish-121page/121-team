@extends('backend.layouts.main') 
@section('title', 'Website Header')
@section('content')
<!-- push external head elements to head -->
@push('head')

	<link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/plugins/summernote/dist/summernote-bs4.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">

@endpush
    @php
        $breadcrumb_arr = [
            ['name'=>'Website Setting', 'url'=> "javascript:void(0);", 'class' => ''],
            ['name'=>'Header', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
    @endphp
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Website Header')}}</h5>
                            {{-- <span>{{ __('This setting will be automatically updated in your website.')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
					<div>
						{{-- <a style="margin-left: 80px;" class="btn btn-icon btn-sm btn-outline-success" href="#" data-toggle="modal" data-target="#siteModal"><i
                            class="fa fa-info"></i></a> --}}
							@include('backend.include.breadcrumb')
					</div>
                </div>
				@include('backend.setting.sitemodal',['title'=>"How to use",'content'=>"You need to create a unique code and call the unique code with paragraph content helper."])
            </div>
        </div>  
		<div class="row">
			<div class="col-md-8 mx-auto">
				<div class="card">
					<div class="card-header">
						<h6 class="mb-0">{{ ('Header Setting') }}</h6>
					</div>
					<div class="card-body">
						<form action="{{ route('panel.website_setting.header.store')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="group_name" value="{{ 'website_header' }}">
							<div class="form-group row">
								<label for="logo" class="col-sm-3 col-form-label">{{ __('Frontend Logo')}}</label>
								<div class="col-sm-8">
									<input type="file" name="frontend_logo" class="file-upload-default">
									<div class="input-group col-xs-12">
										<input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo">
										<span class="input-group-append">
											<button class="file-upload-browse btn btn-success" type="button">{{ __('Upload')}}</button>
										</span>
									</div>
									<div class="file-preview">
										<img src="{{ getSetting('frontend_logo') ? asset('storage/frontend/logos/'.getSetting('frontend_logo')) : '' }}" class="" width="150" style="object-fit: contain; width: 350px; height: 150px" />
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-from-label">{{ ('Frontend White Logo') }}</label>
								<div class="col-md-8">
									<input type="file" name="frontend_white_logo" class="file-upload-default">
									<div class="input-group col-xs-12">
										<input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo">
										<span class="input-group-append">
										<button class="file-upload-browse btn btn-success" type="button">{{ __('Upload')}}</button>
										</span>
									</div>
									<div class="file-preview">
										<img src="{{ getSetting('frontend_white_logo') ? asset('storage/frontend/logos/'.getSetting('frontend_white_logo')) : '' }}" class="" width="150" style="object-fit: contain; width: 350px; height: 150px" />
									</div>
								</div>
							</div>
							{{-- <div class="border-top pt-3">
								<label class="">{{('Header Nav Menu')}}</label>
								<form class="form-inline repeater">
									<div data-repeater-list="group-a">
										<div data-repeater-item class="d-flex mb-2">
											<label class="sr-only" for="inlineFormInputGroup1">{{ __('Users')}}</label>
											<div class="form-group mb-2 mr-sm-2 mb-sm-0">
												<input type="text" class="form-control" placeholder="Name">
											</div>
											<div class="form-group mb-2 mr-sm-2 mb-sm-0">
												<input type="email" class="form-control" placeholder="Email">
											</div>
											<div class="form-group mb-2 mr-sm-2 mb-sm-0">
												<input type="tel" class="form-control" placeholder="Phone No">
											</div>
											<button data-repeater-delete type="button" class="btn btn-danger btn-icon ml-2" ><i class="ik ik-trash-2"></i></button>
										</div>
									</div>
									<button data-repeater-create type="button" class="btn btn-success btn-icon ml-2 mb-2"><i class="ik ik-plus"></i></button>
								</form>
							</div> --}}
							<div class="text-right">
								<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

    </div>
    
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
      
		<script>
			$('.repeater').repeater({
				//  alert('s');
      // (Optional)
      // "defaultValues" sets the values of added items.  The keys of
      // defaultValues refer to the value of the input's name attribute.
      // If a default value is not specified for an input, then it will
      // have its value cleared.
      defaultValues: {
        'text-input': 'foo'
      },
      // (Optional)
      // "show" is called just after an item is added.  The item is hidden
      // at this point.  If a show callback is not given the item will
      // have $(this).show() called on it.
      show: function() {
        $(this).slideDown();
      },
      // (Optional)
      // "hide" is called when a user clicks on a data-repeater-delete
      // element.  The item is still visible.  "hide" is passed a function
      // as its first argument which will properly remove the item.
      // "hide" allows for a confirmation step, to send a delete request
      // to the server, etc.  If a hide callback is not given the item
      // will be deleted.
      hide: function(deleteElement) {
        if (confirm('Are you sure you want to delete this element?')) {
          $(this).slideUp(deleteElement);
        }
      },
      // (Optional)
      // Removes the delete button from the first list item,
      // defaults to false.
      isFirstItemUndeletable: true
    });
		</script>
    @endpush
@endsection
