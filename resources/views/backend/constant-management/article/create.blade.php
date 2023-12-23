@extends('backend.layouts.main') 
@section('title', 'Article')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Article', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Create New Article')}}</h5>
                            {{-- <span>{{ __('Add a new record for Article')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Add Article')}}</h3>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('panel.constant_management.article.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                                <label for="title" class="control-label">{{ 'Title' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="title" type="text" id="title" value="" placeholder="Enter Title" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                                <label for="category_id">{{ __('Category')}} <span class="text-danger">*</span> </label>
                                                <select required name="category_id" id="category_id" class="form-control select2">
                                                    <option value="" readonly>{{ __('Select Category')}}</option>
                                                    {{-- @php
                                                        $category = App\Models\Category::where('category_type_id','6')->get();
                                                    @endphp --}}
                                                    {{-- @foreach ($category as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                    @endforeach --}}
                                                    <option value="36">General</option> 
                                                    <option value="37">Blog</option> 


                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        
                                        <label class="col-md-4 col-from-label" for="name">{{('Slug')}} <span class="text-red">*</span>
                                        </label>
                                        <div class="col-sm-12">
                                            <div class="input-group d-block d-md-flex">
                                                <input type="hidden" class="form-control w-100 w-md-auto" id="slugInput" oninput="slugFunction()" placeholder="{{ ('Slug') }}" name="slug" >
                                                <div class="input-group-prepend"><span class="input-group-text flex-grow-1" style="overflow: auto" id="slugOutput">{{ url('/page/') }}</span><span id="slugOutput"></span></div>
                                                {{-- <small class="form-text text-muted">{{ ('Use character, number, hypen only') }}</small> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="description">{{ __('Description')}}<span class="text-red">*</span>
                                                </label>
                                                <textarea  class="form-control" name="description" type="text" id="description"  value=""  placeholder="Enter Description" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="description_banner" class="control-label ml-3">{{ __('Banner')}}<span class="text-danger">*</span></label>                                            
                                                  <input type="file" name="description_banner" class="form-control" required>
                                                    {{-- <div class="input-group col-xs-8 ml-3">
                                                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Banner">
                                                        <span class="input-group-append">
                                                        <button  class="file-upload-browse btn btn-success" type="button">{{ __('Upload')}}</button>
                                                        </span>
                                                    </div> --}}
                                               
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('seo_title') ? 'has-error' : ''}}">
                                            <label for="seo_title" class="control-label">{{ 'Seo Title' }}</label>
                                            <input class="form-control" name="seo_title" type="text" id="seo_title" value="" placeholder="Enter Seo Title" >
                                            </div>
                                    </div>
                                    </div>
                                    
                                    <div class="row">
                                            <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('seo_keywords') ? 'has-error' : ''}}">
                                                <label for="seo_keywords">{{ __('Seo Keywords')}}</label>
                                                <textarea class="form-control" name="seo_keywords" type="text" id="seo_keywords" value="" placeholder="Enter Seo Keywords"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('short_description') ? 'has-error' : ''}}">
                                                <label for="short_description">{{ __('Short Description')}}</label>
                                                <textarea class="form-control" name="short_description" type="text" id="short_description" value="" placeholder="Enter Short Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary float-right">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
      {{-- normal editor js --}}
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>

      <script>
        
          var options = {
                  filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                  filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                  filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                  filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
              };
              $(window).on('load', function (){
                  CKEDITOR.replace('description', options);
              });
      </script>
    @endpush
    @push('script')
		<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
		<script src="{{ asset('backend/js/form-advanced.js') }}"></script>
		<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
		<script>
				function slugFunction() {
					var x = document.getElementById("slugInput").value;
					document.getElementById("slugOutput").innerHTML = "{{ url('/article/') }}/" + x;
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
			$('#title').on('keyup', function (){
                $('#slugInput').val(convertToSlug($('#title').val()));
				slugFunction();
			});
		</script>
	@endpush
@endsection
 

