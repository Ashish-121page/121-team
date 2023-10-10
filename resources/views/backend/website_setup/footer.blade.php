@extends('backend.layouts.main') 
@section('title', 'Website Footer')
@section('content')
@push('head')
	<link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush
    @php
        $breadcrumb_arr = [
            ['name'=>'Website Setting', 'url'=> "javascript:void(0);", 'class' => ''],
            ['name'=>'Footer', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
    @endphp
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Website Footer')}}</h5>
                            {{-- <span>{{ __('This setting will be automatically updated in your website.')}}</span> --}}
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
			<div class="col-md-10 mx-auto">
				<div class="card">
					<ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Footer Widget')}}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">{{ __('Footer Bottom')}}</a>
						</li>
						{{-- <li class="nav-item">
							<a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">{{ __('Payment Methods Widget')}}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-security-tab" data-toggle="pill" href="#security" role="tab" aria-controls="pills-security" aria-selected="true">{{ __('Custom Style')}}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-customscript-tab" data-toggle="pill" href="#customscript" role="tab" aria-controls="pills-customscript" aria-selected="true">{{ __('Custom Script')}}</a>
						</li> --}}
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
							<div class="card-body">
								<div class="row gutters-10">
									<div class="col-lg-6">
										<div class="card shadow-none bg-light">
											<div class="card-header">
												<h6 class="mb-0">{{ ('About Widget') }}</h6>
											</div>
											<div class="card-body">
												<form action="{{ route('panel.website_setting.footer.about.store') }}" method="POST" enctype="multipart/form-data">
													@csrf
													<input type="hidden" name="group_name" value="{{ 'website_footer_about' }}">
													<div class="form-group">
														<label>{{ ('About Description') }}</label>
														<textarea class="aiz-text-editor form-control" name="frontend_footer_description" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">{{ getSetting('frontend_footer_description') }}
														</textarea>
													</div>
													<div class="text-right">
														<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="card shadow-none bg-light">
											<div class="card-header">
												<h6 class="mb-0">{{ ('Contact Info Widget') }}</h6>
											</div>
											<div class="card-body">
												<form action="{{ route('panel.website_setting.footer.contact.store') }}" method="POST" enctype="multipart/form-data">
													@csrf
													<input type="hidden" name="group_name" value="{{ 'website_footer_contact' }}">
													<div class="form-group">
														<label>{{ ('Contact address') }}<span class="text-red">*</span></label>
														<input type="text" class="form-control" placeholder="{{ ('Address') }}" name="frontend_footer_address" value="{{ getSetting('frontend_footer_address') }}" required>
													</div>
													<div class="form-group">
														<label>{{ ('Contact phone') }}<span class="text-red">*</span></label>
														<input type="text" class="form-control" placeholder="{{ ('Phone') }}" name="frontend_footer_phone" value="{{ getSetting('frontend_footer_phone') }}"required>
													</div>
													<div class="form-group">
														<label>{{ ('Contact email') }}<span class="text-red">*</span></label>
														<input type="text" class="form-control" placeholder="{{ ('Email') }}" name="frontend_footer_email" value="{{ getSetting('frontend_footer_email') }}"required>
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
						<div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
							<div class="card-body p-0 m-0">
								<form action="{{ route('panel.website_setting.footer.bottom.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="group_name" value="{{ 'website_footer_bottom' }}">
								   <div class="card-body">
										<div class="card shadow-none bg-light">
											<div class="card-header">
												<h6 class="mb-0">{{ ('Copyright Widget ') }}</h6>
											</div>
											<div class="card-body">
												<div class="form-group">
													<label>{{ ('Copyright Text') }}</label>
													<textarea class="aiz-text-editor form-control" name="frontend_copyright_text" data-buttons='[["font", ["bold", "underline", "italic"]],["insert", ["link"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">{{ getSetting('frontend_copyright_text') }}
												  </textarea>
													  </div>
											</div>
										</div>
										<div class="card shadow-none bg-light">
										  <div class="card-header">
														<h6 class="mb-0">{{ ('Social Link Widget ') }}</h6>
													</div>
										  <div class="card-body">
											<div class="form-group row">
											  <label class="col-md-2 col-from-label">{{('Show Social Links?')}}</label>
											  <div class="col-md-9">
												<label class="aiz-switch aiz-switch-success mb-0">
												  <input type="checkbox" class="js-single" value="1" name="show_social_links" @if( ('show_social_links') == 'on') checked @endif>
												  <span></span>
												</label>
											  </div>
											</div>
											<div class="form-group">
												<label>{{ ('Social Links') }}</label>
												<div class="input-group form-group">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="ik ik-facebook"></i></span>
													</div>
													<input type="text" class="form-control" placeholder="http://" name="facebook_link" value="{{ getSetting('facebook_link') }}">
												</div>
												<div class="input-group form-group">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="ik ik-twitter"></i></span>
													</div>
													<input type="text" class="form-control" placeholder="http://" name="twitter_link" value="{{ getSetting('twitter_link') }}">
												</div>
												<div class="input-group form-group">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="ik ik-instagram"></i></span>
													</div>
													<input type="text" class="form-control" placeholder="http://" name="instagram_link" value="{{ getSetting('instagram_link') }}">
												</div>
												<div class="input-group form-group">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="ik ik-youtube"></i></span>
													</div>
													<input type="text" class="form-control" placeholder="http://" name="youtube_link" value="{{ getSetting('youtube_link') }}">
												</div>
												<div class="input-group form-group">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="ik ik-linkedin"></i></span>
													</div>
													<input type="text" class="form-control" placeholder="http://" name="linkedin_link" value="{{ getSetting('linkedin_link') }}">
												</div>
											</div>
										  </div>
										</div>
										{{-- <div class="card shadow-none bg-light">
										  <div class="card-header">
												<h6 class="mb-0">{{ ('Payment Methods Widget ') }}</h6>
											</div>
										  <div class="card-body">
											  <div class="form-group">
												<label for="logo" class="col-sm-3 col-form-label">{{ __('Payment Methods')}}</label>
												<div class="col-sm-12">
													<input type="file" name="payment_method_images" class="file-upload-default">
													<div class="input-group col-xs-12">
														<input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo">
														<span class="input-group-append">
														<button class="file-upload-browse btn btn-success" type="button">{{ __('Upload')}}</button>
														</span>
													</div>
												</div>
												  <div class="file-preview box sm">
												  </div>
											   </div>
										  </div>
										</div> --}}
						
										<div class="text-right">
											<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- <div class="card">
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ ('Footer Widget') }}</h6>
			</div>
			<div class="card-body">
				<div class="row gutters-10">
					<div class="col-lg-6">
						<div class="card shadow-none bg-light">
							<div class="card-header">
								<h6 class="mb-0">{{ ('About Widget') }}</h6>
							</div>
							<div class="card-body">
								<form action="{{ route('panel.website_setting.footer.about.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="group_name" value="{{ 'website_footer_about' }}">
									<div class="form-group">
										<label>{{ ('About description') }}</label>
										<textarea class="aiz-text-editor form-control" name="frontend_footer_description" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">{{ getSetting('frontend_footer_description') }}
										</textarea>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card shadow-none bg-light">
							<div class="card-header">
								<h6 class="mb-0">{{ ('Contact Info Widget') }}</h6>
							</div>
							<div class="card-body">
								<form action="{{ route('panel.website_setting.footer.contact.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="group_name" value="{{ 'website_footer_contact' }}">
									<div class="form-group">
										<label>{{ ('Contact address') }}</label>
										<input type="text" class="form-control" placeholder="{{ ('Address') }}" name="frontend_footer_address" value="{{ getSetting('frontend_footer_address') }}">
									</div>
									<div class="form-group">
										<label>{{ ('Contact phone') }}</label>
										<input type="text" class="form-control" placeholder="{{ ('Phone') }}" name="frontend_footer_phone" value="{{ getSetting('frontend_footer_phone') }}">
									</div>
									<div class="form-group">
										<label>{{ ('Contact email') }}</label>
										<input type="text" class="form-control" placeholder="{{ ('Email') }}" name="frontend_footer_email" value="{{ getSetting('frontend_footer_email') }}">
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
		</div> --}}
	
		{{-- <div class="card">
			<div class="card-header">
				<h6 class="fw-600 mb-0">{{ ('Footer Bottom') }}</h6>
			</div>
			<form action="{{ route('panel.website_setting.footer.bottom.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="group_name" value="{{ 'website_footer_bottom' }}">
			   <div class="card-body">
					<div class="card shadow-none bg-light">
						<div class="card-header">
							<h6 class="mb-0">{{ ('Copyright Widget ') }}</h6>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>{{ ('Copyright Text') }}</label>
								<textarea class="aiz-text-editor form-control" name="frontend_copyright_text" data-buttons='[["font", ["bold", "underline", "italic"]],["insert", ["link"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">{{ getSetting('frontend_copyright_text') }}
							  </textarea>
								  </div>
						</div>
					</div>
					<div class="card shadow-none bg-light">
					  <div class="card-header">
									<h6 class="mb-0">{{ ('Social Link Widget ') }}</h6>
								</div>
					  <div class="card-body">
						<div class="form-group row">
						  <label class="col-md-2 col-from-label">{{('Show Social Links?')}}</label>
						  <div class="col-md-9">
							<label class="aiz-switch aiz-switch-success mb-0">
							  <input type="checkbox" class="js-single" value="1" name="show_social_links" @if( ('show_social_links') == 'on') checked @endif>
							  <span></span>
							</label>
						  </div>
						</div>
						<div class="form-group">
							<label>{{ ('Social Links') }}</label>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ik ik-facebook"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="http://" name="facebook_link" value="{{ getSetting('facebook_link') }}">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ik ik-twitter"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="http://" name="twitter_link" value="{{ getSetting('twitter_link') }}">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ik ik-instagram"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="http://" name="instagram_link" value="{{ getSetting('instagram_link') }}">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ik ik-youtube"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="http://" name="youtube_link" value="{{ getSetting('youtube_link') }}">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ik ik-linkedin"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="http://" name="linkedin_link" value="{{ getSetting('linkedin_link') }}">
							</div>
						</div>
					  </div>
					</div>
					<div class="card shadow-none bg-light">
					  <div class="card-header">
							<h6 class="mb-0">{{ ('Payment Methods Widget ') }}</h6>
						</div>
					  <div class="card-body">
						  <div class="form-group">
							<label for="logo" class="col-sm-3 col-form-label">{{ __('Payment Methods')}}</label>
							<div class="col-sm-12">
								<input type="file" name="payment_method_images" class="file-upload-default">
								<div class="input-group col-xs-12">
									<input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo">
									<span class="input-group-append">
									<button class="file-upload-browse btn btn-success" type="button">{{ __('Upload')}}</button>
									</span>
								</div>
							</div>
							  <div class="file-preview box sm">
							  </div>
						   </div>
					  </div>
					</div>
	
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ ('Update') }}</button>
					</div>
				</div>
			</form>
		</div> --}}
    </div>

	@push('script')
		<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
		<script src="{{ asset('backend/js/form-advanced.js') }}"></script>
	@endpush
    
    <!-- push external js -->
@endsection

