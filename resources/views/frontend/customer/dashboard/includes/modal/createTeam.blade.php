<div class="modal fade" id="addTeam" role="dialog" aria-labelledby="AccessCodeTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AccessCodeTitle">Create Team</h5>
                <div>
                    <span id="OTP" class="d-none"></span>
                </div>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="{{ route('panel.teams.store') }}" method="post" enctype="multipart/form-data" id="TeamForm">
                        @csrf
                        <input type="hidden" name="user_shop_id" id="" value="{{ $user_shop->id }}">
                        <div class="row">
                                                                                        
                            <div class="col-md-6 col-12 my-2"> 
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                    <label for="name" class="control-label">Team Member<span class="text-danger">*</span> </label>
                                    <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Team Member Name" >
                                </div>
                            </div>
                                                                                        
                            <div class="col-md-6 col-12 my-2"> 
                                <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                    <label for="image" class="control-label">Upload Photo</label>
                                    <input class="form-control" name="image" type="file" id="image" value="{{old('image')}}" >
                                    <img id="image" class="d-none mt-2" style="border-radius: 10px;width:100px;height:80px;"/>
                                </div>
                            </div>
                                                                                        
                            <div class="col-md-6 col-12 my-2"> 
                                <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                    <label for="designation" class="control-label">Designation of member<span class="text-danger">*</span> </label>
                                    <input required  class="form-control" name="designation" type="text" id="designation" value="{{old('designation')}}" placeholder="Enter Designation of member" >
                                </div>
                            </div>


                            <div class="col-md-6 col-12 my-2"> 
                                <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                    <label for="Email" class="control-label">Email<span class="text-danger">*</span> </label>
                                    <input required  class="form-control" name="Email" type="email" id="Email" value="{{old('Email')}}" placeholder="Enter Email of member" >
                                </div>
                            </div>
                            @php
                                $city = App\Models\City::where('country_code',"IN")->get();
                            @endphp
                            <div class="col-md-6 col-12 my-2"> 
                                <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                    <label for="cityEditTeam" class="control-label">City<span class="text-danger">*</span> </label>
                                    <select class="form-select form-control select2insidemodalTeam" id="cityEditTeam" name="city"  required>
                                        {{-- <option value="all" selected>Select City</option> --}}
                                        @foreach ($city as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12 my-2"> 
                                <div class="form-group {{ $errors->has('contact_number') ? 'has-error' : ''}}">
                                    <label for="contact_number" class="control-label">Contact Number<span class="text-danger">*</span> </label>
                                    <input required  class="form-control contact_number" name="contact_number" type="number"  id="contact_number" placeholder="Enter Contact Number" value="">
                                </div>
                            </div>

                            <div class="col-md-12 col-12 my-2"> 
                                <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                    <label for="cityEditTeamRights" class="control-label">Team Permission Rights<span class="text-danger">*</span> </label>
                                    <select class="form-select form-control select2insidemodalTeam" id="cityEditTeamRights" name="teamright[]"  required multiple>

                                        <option value="dashboard" selected> Dashboard </option>
                                        @if ($acc_permissions->mycustomer == 'yes')
                                            <option value="my-customer" selected> My Customer </option>
                                        @endif

                                        @if ($acc_permissions->mysupplier == 'yes')
                                            <option value="my-suppler" selected> My Supplier </option>
                                        @endif

                                        @if ($acc_permissions->offers == 'yes')
                                            <option value="offer-me" selected> Offer Sent By Me </option>
                                            <option value="offer-other" selected> Offer Sent By Other </option>
                                        @endif

                                        @if ($acc_permissions->addandedit == 'yes')
                                            <option value="proadd" selected> Add/Edit </option>
                                        @endif

                                        @if ($acc_permissions->manangebrands == 'yes')
                                            <option value="brand" selected>Manage Brands</option>
                                        @endif

                                        @if ($acc_permissions->pricegroup == 'yes')
                                            <option value="pricegroup" selected>Manage Price Group</option>
                                        @endif

                                        @if ($acc_permissions->managegroup == 'yes')
                                            <option value="categorygroup" selected>Manage Category Group</option>
                                        @endif

                                        @if ($acc_permissions->bulkupload == 'yes')
                                            <option value="bulkupload" selected>Manage Bulk Upload</option>
                                        @endif

                                        <option value="profile" selected> Profile </option>
                                        @if ($acc_permissions->Filemanager == 'yes')
                                            <option value="setting" selected> Settings </option>
                                        @endif
                                        

                                    </select>
                                    <button type="button" id="otpButtonteam" class="btn btn-link btn-outline-primary text-center w-100 float-end my-1">Ask OTP</button>
                                </div>
                            </div>

                            <div class="col-md-6 col-12 my-2 otpaction1 d-none"> 
                                <div class="form-group">
                                    <label for="otp_num" class="control-label">Enter OTP</label>
                                    <input  class="form-control" name="otp_num" type="number" id="otp_num" placeholder="Enter OTP Number" >
                                </div>
                            </div>
                            <div class="col-md-6 col-12 my-2 otpaction2 d-none"> 
                                <div class="form-group">
                                    <button class="btn btn-outline-primary btn-sm my-4" id="verifyOTP" type="button">Verify OTP</button>
                                </div>
                            </div>
                                                        
                            <div class="col-md-12 ml-auto">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary activebtn d-none">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
