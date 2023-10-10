@extends('backend.layouts.main') 
@section('title', 'Website Appearance')
@section('content')
@push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-minicolors/jquery.minicolors.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datedropper/datedropper.min.css') }}">
    @endpush
@php
	$breadcrumb_arr = [
		['name'=>'Website Setting', 'url'=> "javascript:void(0);", 'class' => ''],
		['name'=>'Appearance', 'url'=> "javascript:void(0);", 'class' => 'active']
	]
@endphp
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Website Appearance')}}</h5>
                            <span>{{ __('This setting will be automatically updated in your website.')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
					<div>
						
							@include('backend.include.breadcrumb')
					</div>
                </div>
				@include('backend.setting.sitemodal',['title'=>"How to use",'content'=>"You need to create a unique code and call the unique code with paragraph content helper."])
            </div>
        </div> 
		<div class="row">
			<div class="col-lg-8 mx-auto">
				<div class="card">
					<ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('General')}}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">{{ __('Global SEO')}}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">{{ __('Cookies Agreement')}}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-security-tab" data-toggle="pill" href="#security" role="tab" aria-controls="pills-security" aria-selected="true">{{ __('Custom Style')}}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-customscript-tab" data-toggle="pill" href="#customscript" role="tab" aria-controls="pills-customscript" aria-selected="true">{{ __('Custom Script')}}</a>
						</li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
							<div class="card-body">
								<form action="{{ route('panel.website_setting.theme.store') }}" method="POST">
									@csrf
									<input type="hidden" name="group_name" value="{{ 'appearance_general' }}">
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{('Website Base Color')}}</label>
										<div class="col-md-8">
											<input type="text" id="hue-demo" name="website_base_color" class="form-control demo" data-control="hue" placeholder="#377dff" value="{{ getSetting('website_base_color') }}">
											<small class="text-muted">{{ ('Hex Color Code') }}</small>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{('Website Base Hover Color')}}</label>
										<div class="col-md-8">
											<input type="text" id="hue-demo" name="website_base_hov_color" class="form-control demo" data-control="hue" placeholder="#377dff" value="{{ getSetting('website_base_hov_color') }}">
											<small class="text-muted">{{ ('Hex Color Code') }}</small>
										</div>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
									</div>
								</form>
							</div>
						</div>
						<div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
							<div class="card-body">
								<form action="{{ route('panel.website_setting.seo.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="group_name" value="{{ 'appearance_global_seo' }}">
									<input type="hidden" name="appearance_seo_group" value="{{ 'seo_group' }}">
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{ ('Meta Title') }}</label>
										<div class="col-md-8">
											<input type="text" class="form-control" placeholder="Title" name="seo_meta_title" value="{{ getSetting('seo_meta_title') }}">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{ ('Meta description') }}</label>
										<div class="col-md-8">
											<textarea class="resize-off form-control" placeholder="Description" name="seo_meta_description">{{ getSetting('seo_meta_description') }}</textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{ ('Keywords') }}</label>
										<div class="col-md-8">
											<textarea class="resize-off form-control" placeholder="Keyword, Keyword" name="seo_meta_keywords">{{ getSetting('seo_meta_keywords') }}</textarea>
											<small class="text-muted">{{ ('Separate with coma') }}</small>
										</div>
									</div>
									<div class="form-group row">
										<label for="logo" class="col-sm-3 col-form-label">{{ __('Meta Image')}}</label>
										<div class="col-sm-8">
											<input type="file" name="seo_meta_image" class="file-upload-default">
											<div class="input-group col-xs-12">
												<input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo">
												<span class="input-group-append">
												<button class="file-upload-browse btn btn-success" type="button">{{ __('Upload')}}</button>
												</span>
											</div>
											<div class="file-preview box"></div>
										</div>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
									</div>
								</form>
							</div>
						</div>
						<div class="tab-pane fade" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
							<div class="card-body">
								<form action="{{ route('panel.website_setting.cookies.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="group_name" value="{{ 'appearance_cookies_agreement' }}">
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{ ('Cookies Agreement Text') }}</label>
										<div class="col-md-8">
											<textarea name="cookies_agreement_text" rows="4" class="aiz-text-editor form-control" data-buttons='[["font", ["bold"]],["insert", ["link"]]]'>{{ getSetting('cookies_agreement_text') }}</textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{('Show Cookies Agreement?')}}</label>
										<div class="col-md-8">
											<label class="aiz-switch aiz-switch-success mb-0">
												<input type="checkbox" name="show_cookies_agreement" value="1" class="js-single" checked />
												<span></span>
											</label>
										</div>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
									</div>
								</form>
							</div>
						</div>
						<div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="pills-security-tab">
							<div class="card-body">
								<form action="{{ route('panel.website_setting.style.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="group_name" value="{{ 'appearance_custom_style' }}">
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{ ('Header custom style - before </head>') }}</label>
										<div class="col-md-8">
											<textarea name="custom_header_style" rows="4" class="form-control" placeholder="<style>&#10;...&#10;</style>">{{ getSetting('custom_header_style') }}</textarea>
											<small>{{ ('Write style with <style> tag') }}</small>
										</div>
									</div>
									@csrf
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{ ('Footer custom style - before </body>') }}</label>
										<div class="col-md-8">
											<textarea name="custom_footer_style" rows="4" class="form-control" placeholder="<style>&#10;...&#10;</style>">{{ getSetting('custom_footer_style') }}</textarea>
											<small>{{ ('Write style with <style> tag') }}</small>
										</div>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
									</div>
								</form>
							</div>
						</div>
						<div class="tab-pane fade" id="customscript" role="tabpanel" aria-labelledby="pills-customscript-tab">
							<div class="card-body">
								<form action="{{ route('panel.website_setting.script.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="group_name" value="{{ 'appearance_custom_script' }}">
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{ ('Header custom script - before </head>') }}</label>
										<div class="col-md-8">
											<textarea name="custom_header_script" rows="4" class="form-control" placeholder="<script>&#10;...&#10;</script>">{{ getSetting('custom_header_script') }}</textarea>
											<small>{{ ('Write script with <script> tag') }}</small>
										</div>
									</div>
									@csrf
									<div class="form-group row">
										<label class="col-md-3 col-from-label">{{ ('Footer custom script - before </body>') }}</label>
										<div class="col-md-8">
											<textarea name="custom_footer_script" rows="4" class="form-control" placeholder="<script>&#10;...&#10;</script>">{{ getSetting('custom_footer_script') }}</textarea>
											<small>{{ ('Write script with <script> tag') }}</small>
										</div>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	@push('script')
		<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datedropper/datedropper.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-picker.js') }}"></script>
		<script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    @endpush
@endsection
