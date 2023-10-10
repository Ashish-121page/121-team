
@extends('backend.layouts.main') 
@section('title', 'Website Pages')
@section('content')
@push('head')
	<link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush
    @php
       $breadcrumb_arr = [
            ['name'=>'Website Pages', 'url'=> "javascript:void(0);", 'class' => ''],
            ['name'=>'Edit Pages', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
    @endphp
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Page Information')}}</h5>
                            {{-- <span>{{ __('This setting will be automatically updated in your website.')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div> 
		<div class="row">
			<div class="col-md-12 mx-auto">
				<div class="card">
				
					<form class="p-4" action="{{ route('panel.website_setting.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="card-header px-0">
							<h6 class="fw-600 mb-0">{{ ('Page Content') }}</h6>
						</div>
						<div class="card-body px-0">
							<div class="form-group row">
								<label class="col-sm-2 col-from-label" for="name">{{('Title')}} <span class="text-danger">*</span> <i class="las la-language text-danger" title="{{('Translatable')}}"></i></label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Title" name="title" value="{{ @$page->title }}" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-from-label" for="name">{{('Slug')}} </label>
								<div class="col-sm-10">
									<div class="input-group d-block d-md-flex">
										<input type="text" class="form-control w-100 w-md-auto" id="slugInput" oninput="slugFunction()" placeholder="{{ ('Slug') }}" name="slug" value="{{ $page->slug }}" required>
										<div class="input-group-prepend"><span class="input-group-text flex-grow-1" style="overflow: auto" id="slugOutput">{{ url('/page/').'/'.$page->slug }} </span></div>
									</div>
									<small class="form-text text-muted">{{ ('Use character, number, hypen only') }}</small>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-from-label" for="name" required>{{('Add Content')}} <span class="text-danger">*</span></label>
								<div class="col-sm-10">
									<textarea
										class="aiz-text-editor form-control ckeditor"
										placeholder="Content.."
										data-buttons='[["font", ["bold", "underline", "italic", "clear"]],["para", ["ul", "ol", "paragraph"]],["style", ["style"]],["color", ["color"]],["table", ["table"]],["insert", ["link", "picture", "video"]],["view", ["fullscreen", "codeview", "undo", "redo"]]]'
										data-min-height="300"
										name="content"
										required
									>{{ @$page->content }}  </textarea>
								</div>
							</div>
							<div class="form-group row">
								<label required class="col-md-2 col-from-label">{{('Page Status')}}<span class="text-danger">*</span></label>
								<div class="col-md-9">
								  <label class="aiz-switch aiz-switch-success mb-0">
										<input type="checkbox" class="js-single" name="status" value="1" @if($page->status == 1) checked @endif>
								  </label>
								</div>
							  </div>
						</div>
				
						<div class="card-header px-0">
							<h6 class="fw-600 mb-0">{{ ('Seo Fields') }}</h6>
						</div>
						<div class="card-body px-0">
				
							<div class="form-group row">
								<label class="col-sm-2 col-from-label" for="name">{{('Meta Title')}}</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Title" name="page_meta_title" value="{{ @$page->page_meta_title }}">
								</div>
							</div>
				
							<div class="form-group row">
								<label class="col-sm-2 col-from-label" for="name">{{('Meta Description')}}</label>
								<div class="col-sm-10">
									<textarea class="resize-off form-control" placeholder="Description" name="page_meta_description">
										{{ @$page->page_meta_description }}
									</textarea>
								</div>
							</div>
				
							<div class="form-group row">
								<label class="col-sm-2 col-from-label" for="name">{{('Keywords')}}</label>
								<div class="col-sm-10">
									<textarea class="resize-off form-control" placeholder="Keyword, Keyword" name="page_keywords">
										{{ @$page->page_keywords }}
									</textarea>
									<small class="text-muted">{{ ('Separate with coma') }}</small>
								</div>
							</div>
				
							<div class="form-group row">
								<label for="logo" class="col-sm-2 col-form-label">{{ __('Meta Image')}}</label>
								<div class="col-sm-10">
									<input type="file" name="page_meta_image" class="file-upload-default" value="{{ $page->page_meta_image }}">
									<div class="input-group col-xs-12">
										<input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo">
										<span class="input-group-append">
										<button class="file-upload-browse btn btn-success" type="button">{{ __('Upload')}}</button>
										</span>
									</div>
									<div class="file-preview">
										<img src="{{ $page->page_meta_image ? asset('storage/backend/page/'.$page->page_meta_image) : '' }}" class="" width="150" style="object-fit: contain; width: 350px; height: 150px" />
									</div>
								</div>
							</div>
							
							<div class="text-right">
								<button type="submit" class="btn btn-primary">{{ ('Update Page') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

    </div>
    
    <!-- push external js -->
@endsection
@push('script')
	<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
	<script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
	<script>
		function slugFunction() {
				var x = document.getElementById("slugInput").value;
				document.getElementById("slugOutput").innerHTML = "{{ url('/page/') }}/" + convertToSlug(x);
			}
			function convertToSlug(Text)
			{
				return Text
					.toLowerCase()
					.replace(/ /g,'-')
					.replace(/[^\w-]+/g,'')
					;
			}
		$(window).on('load', function (){

			CKEDITOR.replace('content', options);
		});
		$('#website_pages').DataTable( {
        responsive: true
        } );
	</script>
	
@endpush