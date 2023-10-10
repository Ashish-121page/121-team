@extends('backend.layouts.main') 
@section('title', 'Mail/SMS Settings')
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Mail/SMS Setting')}}</h5>
                            {{-- <span>{{ __('This setting will be automatically updated in your website.')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>

                      
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('panel.dashboard')}}"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">{{ __('Setting')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Mail/SMS')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                @include('backend.setting.sitemodal',['title'=>"How to use",'content'=>"You need to create a unique code and call the unique code with paragraph content helper."])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-484">
                    <div role="tabpanel">
                        <div class="card-header" style="border:none;" >
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#mail" class="nav-link active" aria-controls="mail" role="tab" data-toggle="tab">Mail</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#sms" class="nav-link" aria-controls="sms" role="tab" data-toggle="tab">SMS</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="#notification" class="nav-link" aria-controls="notification" role="tab" data-toggle="tab">Push notification</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="card-body pt-0">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active pt-3" id="mail" aria-labelledby="mail-tab">
                                    <div class="card-header p-0 justify-content-between">
                                        <h3>{{ __('Mail Configuration')}}</h3>
                                        <a href="javascript:void(0);" class="btn btn-primary openModal mb-2" data-type="Mail">Send Mail</a>
                                    </div>
                                    <form class="forms-sample" action="{{ route('panel.setting.mail.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="group_name" value="mail_setting">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Admin Email')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="admin_email" class="form-control"  required value="{{ getSetting('admin_email') }}" placeholder="Admin Email">
                                                </div>
                                                <div class="col-sm-5">
                                                    <span class="text-warning">All Admin mails are received by this email.</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Mail From Name')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="mail_from_name" class="form-control"  required value="{{ getSetting('mail_from_name') }}" placeholder="Mail From Name">
                                                </div>
                                                <div class="col-sm-5">
                                                    <span class="text-warning">This will be display name for your sent email.</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputEmail2" class="col-sm-2 col-form-label">{{ __('Mail From Address')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="mail_from_address" class="form-control" required value="{{ getSetting('mail_from_address') }}" placeholder="Mail From Address">
                                                </div>
                                                <div class="col-sm-5">
                                                    <span class="text-warning">This email will be used for "Contact Form" correspondence.</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Mail Driver')}}<span class="text-red">*</span></label>
                                                
                                                <div class="col-sm-5">
                                                    {{-- <input type="text" name="mail_mailer" class="form-control" value="{{ getSetting('mail_mailer') }}" placeholder="Mail Driver"> --}}
                                                    <select   name="mail_mailer" id="" required>
                                                        <option value="" aria-readonly="true">Select mail driver</option>
                                                        <option @if(getSetting('mail_mailer') == "smtp") selected @endif value="smtp">SMTP</option>
                                                        <option @if(getSetting('mail_mailer') == "sendmail") selected @endif value="sendmail">Sendmail</option>
                                                        <option @if(getSetting('mail_mailer') == "mailgun") selected @endif value="mailgun">Mailgun</option>
                                                        <option @if(getSetting('mail_mailer') == "sparkpost") selected @endif value="sparkpost">SparkPost</option>
                                                        <option @if(getSetting('mail_mailer') == "ses") selected @endif value="ses">Amazon SES</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-5">
                                                    <span class="text-warning">You can select any driver you want for your Mail setup. Ex. SMTP, Mailgun, Mandrill, SparkPost, Amazon SES etc.
                                                        Add single driver only.</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Mail Host')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="mail_host" class="form-control" value="{{ getSetting('mail_host') }}" placeholder="'Ex. smtp.gmail.com'" required>
                                                </div>
                                                <div class="col-sm-5">
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Mail Port')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    {{-- <input type="text" name="mail_port" class="form-control" value="{{ getSetting('mail_port') }}" placeholder=" "> --}}
                                                    <select required name="mail_port" id="">
                                                        <option value="" aria-readonly="true">Select mail port</option>
                                                        <option @if(getSetting('mail_port') == "587") selected @endif value="587">587</option>
                                                         <option @if(getSetting('mail_port') == "465") selected @endif value="465">465</option>
                                                         <option @if(getSetting('mail_port') == "2525") selected @endif value="2525">2525</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-5">

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Mail Username')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="mail_username" class="form-control" value="{{ getSetting('mail_username') }}" placeholder="Ex. myemail@email.com" required>
                                                </div>
                                                <div class="col-sm-5">
                                                    <span class="text-warning">Add your email id you want to configure for sending emails</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Mail Password')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="password" name="mail_password" class="form-control" value="{{ getSetting('mail_password') }}" placeholder="Mail Password" required>
                                                </div>
                                                <div class="col-sm-5">
                                                    <span class="text-warning">Add your email password you want to configure for sending emails</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Mail Encryption')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    {{-- <input type="text" name="mail_encryption" class="form-control" value="{{ getSetting('mail_encryption') }}" placeholder="Mail Encryption"> --}}
                                                    <select required name="mail_encryption" id="">
                                                        <option value="" aria-readonly="true">Mail encryption</option>
                                                        <option @if(getSetting('mail_encryption') == "tls") selected @endif value="tls">TLS
                                                        </option>
                                                         <option @if(getSetting('mail_encryption') == "ssl") selected @endif value="ssl">SSL
                                                        </option>
                                                       
                                                     </select>

                                                </div>
                                                <div class="col-sm-5">
                                                    <span class="text-warning">Use tls if your site uses HTTP protocol and ssl if you site uses HTTPS protocol</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <p class="help-text mb-0"><b>Important Note</b> : IF you are using <b>GMAIL</b> for Mail configuration, make sure you have completed following process before updating:
                                            </p>
                                            <ul>
                                                <li>Go to <a target="_blank" href="https://myaccount.google.com/security">My Account</a> from your Google Account you want to configure and Login</li>
                                                <li>Scroll down to <b>Less secure app access</b> and set it <b>ON</b></li>
                                                </ul>
                                     
                                            
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
                                        </div>
                                    </form>

                                </div><!--tab panel profile-->

                                <div role="tabpanel" class="tab-pane fade show pt-3" id="sms" aria-labelledby="sms-tab">
                                    <div class="card-header p-0 justify-content-between">
                                        <h3>{{ __('SMS Configuration')}}</h3>
                                        <a href="javascript:void(0);" class="btn btn-primary openModal" data-type="Sms">Send Sms</a>
                                    </div>
                                    
                                    <form class="forms-sample" action="{{ route('panel.setting.sms.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="group_name" value="sms_api">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Twilio Sid')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="twilio_account_sid" class="form-control" value="{{ getSetting('twilio_account_sid') }}" placeholder="INSERT YOUR TWILIO ACCOUNT SID" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Twilio Auth Token')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">  
                                                    <input type="password" name="twilio_auth_token" class="form-control" value="{{ getSetting('twilio_auth_token') }}" placeholder="INSERT YOUR TWILIO AUTH TOKEN" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Twilio Verify Sid')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="twilio_verify_sid" class="form-control" value="{{ getSetting('twilio_verify_sid') }}" placeholder="INSERT YOUR TWILIO SYNC SERVICE SID" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Sms Number')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">  
                                                    <input type="text" name="twilio_account_number" class="form-control" value="{{ getSetting('twilio_account_number') }}" placeholder="SMS NUMBER" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
                                        </div>
                                    </form>
                                </div><!--tab panel profile-->

                                {{-- <div role="tabpanel" class="tab-pane fade show pt-3" id="notification" aria-labelledby="notification-tab">
                                    <div class="card-header p-0"><h3>{{ __('Push Notification Configuration')}}</h3></div>

                                    <form class="forms-sample" action="{{ route('panel.setting.notification.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">{{ __('Push Notification API')}}<span class="text-red">*</span></label>
                                                <div class="col-sm-5">
                                                    <textarea type="text" name="notification_api" class="form-control" value="{{ getSetting('notification_api') }}" placeholder="notification API" required> </textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary mr-2">{{ __('Submit')}}</button>
                                        </div>
                                    </form>
                                </div> --}}
                                <!--tab panel profile-->

                            </div><!--tab content-->
                        </div>
                    </div><!--tab panel-->
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="OpenSendModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Modal title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('panel.setting.test.send') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" id="type">
                    <div class="modal-body">
                        <div class="form-group mail">
                            <input type="email" name="email" id="" class="form-control" placeholder="Enter your valid Email">
                        </div>
                        <div class="form-group sms">
                            <input type="number" name="phone" id="" class="form-control" placeholder="Enter your valid Contact Number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" class="close" aria-label="Close" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- push external js -->
    @push('script')
        <script>
            $('.openModal').click(function(){
                var type = $(this).data('type');
                if(type == 'Mail'){
                    $('.sms').hide();
                    $('.mail').show();
                }else{
                    $('.sms').show();
                    $('.mail').hide();
                }
                $('#type').val(type);
                $('#demoModalLabel').html('Send '+type);
                $('#OpenSendModal').modal('show');
            });
        </script>
    @endpush
@endsection