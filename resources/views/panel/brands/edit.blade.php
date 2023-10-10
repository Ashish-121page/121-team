
@extends('backend.layouts.main')
@section('title', 'Brand')
@section('content')
    @php
    /**
     * Brand
     *
     * @category  zStarter
     *
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'Edit Brand', 'url' => 'javascript:void(0);', 'class' => '']];


        $brand_legal = App\Models\BrandUser::whereBrandId($brand->id)->first();
        if($brand_legal != null){
            $details = json_decode($brand_legal->details,true) ?? '';
            $brand_logo = App\Models\Media::whereType('BrandLogo')->whereTypeId($brand_legal->brand_id)->first() ?? '';
             $brand_legal_proof = App\Models\Media::whereType('BrandUserProof')->whereTypeId($brand_legal->brand_id)->first() ?? '';
        }
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }

        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Brand</h5>
                            {{-- <span>Update a record for Brand</span> --}}
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
                <!-- start message area-->
                @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Update Brand</h3>
                    </div>
                    <div class="card-body pt-2">
                              {{-- <div class=" mb-3 mobile-overflow">
                                <a class="btn btn-primary @if(request()->has('active') && request()->get('active') == "appearance") active @endif" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">{{ __('Appearance')}}</a>
                              </div> --}}
                            
                            {{-- <li class="nav-item">
                                <a class="nav-link @if(request()->has('active') && request()->get('active') == "legal") active @endif" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Legal')}}</a>
                            </li> --}}
                      
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "legal") active show @endif" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">

                            @if(!App\Models\BrandUser::whereBrandId($brand->id)->exists())
                            <div class="alert alert-info mt-3">
                                <div>
                                    <p class="mb-0">This information is not updated yet!</p>
                                </div>
                            </div>
                            @endif
                            
                                <form action="{{ route('panel.brands.legal-details.update', $brand->id) }}" method="post"
                                    enctype="multipart/form-data" id="ProductForm">
                                    @csrf
                                    <div class="row mt-3">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group {{ $errors->has('proof_certificate') ? 'has-error' : '' }}">
                                                <label for="proof_certificate" class="control-label">Proof of Certificate<span
                                                        class="text-danger">*</span> </label>
                                                <input class="form-control" name="proof_certificate" type="file"
                                                    id="proof_certificate">
                                                @if (isset($brand_legal) && $brand_legal_proof != null)
                                                    <img id="proof_certificate" src="{{ asset($brand_legal_proof->path) }}" class="mt-2"
                                                        style="border-radius: 10px;width:100px;height:80px;" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                                                <label for="logo" class="control-label">Logo<span class="text-danger">*</span>
                                                </label>
                                                <input  class="form-control" name="logo" type="file" id="logo">
                                                @if (isset($brand_legal) && $brand_logo != null)
                                                    <img id="logo" src="{{ asset($brand_logo->path) }}" class="mt-2"
                                                        style="border-radius: 10px;width:100px;height:80px;" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group {{ $errors->has('est_date') ? 'has-error' : '' }}">
                                                <label for="est_date" class="control-label">Established Date<span
                                                        class="text-danger">*</span> </label>
                                                <input class="form-control" name="est_date" type="date" id="est_date" value="{{ $details['est_date'] ?? 0 }}">
                                            </div>
                                        </div>
                                        

                                        <div class="col-md-6 col-12">
                                            <div class="form-group {{ $errors->has('brand_name') ? 'has-error' : '' }}">
                                                <label for="brand_name" class="control-label">Brand Name<span
                                                        class="text-danger">*</span> </label>
                                                <input  class="form-control" value="{{ $details['brand_name'] ?? 0 }}" name="brand_name" type="text" id="brand_name"
                                                    placeholder="Enter Brand Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                                <label for="email" class="control-label">Email<span class="text-danger">*</span>
                                                </label>
                                                <input class="form-control email" value="{{ $details['email'] ?? '' }}" name="email" type="email" id="email"
                                                    placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                                <label for="phone" class="control-label">Phone<span class="text-danger">*</span>
                                                </label>
                                                <input class="form-control phone" value="{{ $details['phone'] ?? '' }}"  name="phone" type="number" id="phone"
                                                    placeholder="Enter Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                                <label for="phone" class="control-label">Address<span class="text-danger">*</span>
                                                </label>
                                                <textarea id="" cols="10" rows="5" placeholder="Enter Address" class="form-control" name="address" >{{ $details['address'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">{{ __('Country') }}</label>
                                                <select  name="country" id="country" class="form-control select2" >
                                                    <option value="" readonly>{{ __('Select Country') }}</option>
                                                    @foreach (\App\Models\Country::all() as $country)
                                                        <option value="{{ $country->id }}"
                                                            @if ($country->name == 'India') selected @endif>
                                                            {{ $country->name }}</option>
                                                    @endforeach
                                                </select>

                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="state">{{ __('State') }}</label>
                                                <select name="state" id="state" class="form-control select2">
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="city">{{ __('City') }}</label>
                                                <select  name="city" id="city" class="form-control select2">
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="city">{{ __('Pincode') }}</label>
                                                <input type="number" name="pincode" id="" class="form-control" placeholder="Enter Pincode" value="{{ $details['pincode'] ?? '' }}" >
                                                <div class="help-block with-errors" ></div>
                                            </div>
                                        </div>
                                        @if(App\Models\BrandUser::whereBrandId($brand->id)->exists())
                                            <div class="col-md-12 ml-auto">
                                                <div class="form-group d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                           
                        </div>
                        <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "appearance") show active @endif" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                            <form action="{{ route('panel.brands.update', $brand->id) }}" method="post"
                            enctype="multipart/form-data" id="BrandForm">
                            @csrf
                            <div class="row mt-3">

                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span>
                                        </label>
                                        <input required class="form-control" name="name" type="text" id="name"
                                            value="{{ $brand->name }}">
                                    </div>
                                </div>

                                @if (AuthRole() == 'Admin')
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="user_id">User</label>
                                            <select  name="user_id" id="user_id" class="form-control select2">
                                                <option value="" readonly>Select User </option>
                                                @foreach (BrandList()  as $option)
                                                    <option value="{{ $option->id }}"
                                                        {{ $brand->user_id == $option->id ? 'selected' : '' }}>
                                                        {{ $option->name ?? '' }}</option>
                                                @endforeach
                                                @foreach (SellerList()  as $option)
                                                    <option value="{{ $option->id }}"
                                                        {{ $brand->user_id == $option->id ? 'selected' : '' }}>
                                                        {{ $option->name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="user_id">Is Verified</label>
                                            <input type="checkbox" name="is_verified" class="js-single switch-input" value="1" @if($brand->is_verified) checked @endif id="">
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                                        <label for="logo" class="control-label">Logo</label>
                                        <input class="form-control" name="logo_file" type="file" id="logo">
                                        @if ($media != null)
                                        <img id="logo_file" src="{{ asset($media->path) }}" class="mt-2"
                                            style="border-radius: 10px;width:100px;height:80px;" />
                                        @endif
                                    </div>
                                </div>
                                @if(AuthRole() == 'Admin')
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select required name="status" id="status" class="form-control select2">
                                                <option value="" readonly>Select Status</option>
                                                @foreach (getBrandStatus() as $option)
                                                    <option value="{{ $option['id'] }}" @if ($option['id'] == $brand->status) selected @endif>
                                                        {{ $option['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('short_text') ? 'has-error' : '' }}">
                                        <label for="short_text" class="control-label">About</label>
                                        <textarea class="form-control" name="short_text" type="text" id="short_text"
                                            value="">{{ $brand->short_text }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mx-auto">
                                    <div class="form-group d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
   
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script>
           
            $('#BrandForm').validate();

            document.getElementById('logo').onchange = function() {
                var src = URL.createObjectURL(this.files[0])
                $('#logo_file').removeClass('d-none');
                document.getElementById('logo_file').src = src
            }


             // this functionality work in edit page
			function getStateAsync(countryId) {
				return new Promise((resolve, reject) => {
					$.ajax({
						url: '{{ route("world.get-states") }}',
						method: 'GET',
					data: {
						country_id: countryId
					},
					success: function (data) {
						$('#state').html(data);
						$('.state').html(data);
					resolve(data)
					},
					error: function (error) {
					reject(error)
					},
				})
				})
			}
    
			function getCityAsync(stateId) {
				if(stateId != ""){
					return new Promise((resolve, reject) => {
						$.ajax({
							url: '{{ route("world.get-cities") }}',
							method: 'GET',
							data: {
								state_id: stateId
							},
							success: function (data) {
								$('#city').html(data);
								$('.city').html(data);
							resolve(data)
							},
							error: function (error) {
							reject(error)
							},
						})
					})
				}
			}

			$(document).ready(function () {
					var country = "{{ $details['country'] ?? ''}}";
					var state = "{{ $details['state'] ?? '' }}";
					var city = "{{ $details['city'] ?? ''}}";
					if(state){
						getStateAsync(country).then(function(data){
							$('#state').val(state).change();
							$('#state').trigger('change');
						});
					}
					if(city){
						$('#state').on('change', function(){
							if(state == $(this).val()){
								getCityAsync(state).then(function(data){
									$('#city').val(city).change();
									$('#city').trigger('change');
								});
							}
						});
					}
            });
        </script>
    @endpush
@endsection
