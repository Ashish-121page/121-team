@extends('backend.layouts.main') 
@section('title', 'Lead')
@section('content')
@push('head')
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
@endpush

@php
$breadcrumb_arr = [
    ['name'=>'Lead', 'url'=> route('panel.admin.lead.index'), 'class' => ''],
    ['name'=>'View Lead', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('View Lead')}}</h5>
                            <span>{{ __('View a record for Lead')}}</span>
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
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Lead Details of {{ $lead->name }}</h3>
                        <div class="">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                    <li class="dropdown-item p-0"><a href="#!" title="Custom Mail" class="btn btn-sm" data-toggle="modal" data-target="#customMailModalCenter">Custom Mail</a></li>
                                    <li class="dropdown-item p-0"><a href="{{ route('panel.admin.lead.edit', $lead->id) }}" title="Edit Lead Info" class="btn btn-sm">Edit Lead</a></li>
                                    <li class="dropdown-item p-0"><a href="{{ route('panel.admin.lead.delete', $lead->id) }}" title="Edit Lead" class="btn btn-sm delete-item">Delete</a></li>
                                  </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @include('backend.include.message')
                        <div class="col-lg-4 col-md-5">
                            {{-- <div class="card"> --}}
                                <div class="card-body pb-0">
                                    <div class="text-center"> 
                                        <div style="width: 150px; height: 150px; position: relative" class="mx-auto">
                                            <img src="{{ ($lead && $lead->avatar) ? asset('storage/backend/users/'.$lead->avatar) : asset('backend/default/default-avatar.png') }}" class="rounded-circle" width="150" style="object-fit: cover; width: 150px; height: 150px" />
                                            {{-- <button class="btn btn-dark rounded-circle position-absolute" style="width: 30px; height: 30px; padding: 8px; line-height: 1; top: 0; right: 0"  data-toggle="modal" data-target="#updateProfileImageModal"><i class="ik ik-camera"></i></button> --}}
                                        </div>
                                        <h4 class="card-title mt-10">{{$lead->name}}</h4>
                                        <h6 class="mt-10">{{NameById($lead->user_id)}}</h6>
                                    </div>
                                </div>
                                <hr class="mb-0"> 
                                <div class="card-body"> 
                                    <small class="text-muted d-block">{{ __('Email address')}} </small>
                                    <h6>{{ $lead->owner_email }}</h6> 
                                    <small class="text-muted d-block pt-10">{{ __('Phone')}}</small>
                                    <h6>{{ $lead->phone }}</h6> 
                                    <small class="text-muted d-block pt-10">{{ __('Website')}}</small>
                                    <h6>{{ $lead->website }}</h6> 
                                    <small class="text-muted d-block pt-10">{{ __('Location')}}</small>
                                    <h6>{{ $lead->city }} {{ $lead->state }}</h6> 
                                    <small class="text-muted d-block pt-10">{{ __('Lead Type')}}</small>
                                    <h6>{{fetchFirst('App\Models\Category',$lead->lead_type_id,'name','--') }}</h6> 
                                    <small class="text-muted d-block pt-10">{{ __('Lead Sourse')}}</small>
                                    <h6>{{fetchFirst('App\Models\Category',$lead->lead_source_id,'name','--') }}</h6> 
                                    <small class="text-muted d-block pt-10">{{ __('Address')}}</small>
                                    <h6>{{ $lead->address }}</h6>
                                </div>
                            {{-- </div> --}}
                        </div>
                        <div class="col-lg-8 col-md-7">
                            {{-- <div class="card"> --}}
                                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">{{ __('Note')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">{{ __('Contact')}}</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" id="pills-security-tab" data-toggle="pill" href="#security" role="tab" aria-controls="pills-security" aria-selected="true">{{ __('Activity')}}</a>
                                    </li> --}}
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                        <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                            <h3>{{ __('Notes')}}</h3>
                                            <a href="javacript:void(0);" class="btn btn-icon btn-sm btn-outline-primary" data-toggle="modal" data-target="#exampleModalCenter" title="Add New Note"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                        </div>
                                        <div class="card-body" style="overflow: auto">
                                            <table  class="table data_table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Created At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (fetchGet('App\Models\UserNote', 'where', 'type_id', '=', $lead->id) as $index => $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->title }}</td>
                                                            <td>{{ $item->description }}</td>
                                                            <td>{{ getFormattedDate($item->created_at) }}</td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="btn edit-btn btn-block btn-icon btn-sm btn-outline-warning edit-note" data-item="{{ $item }}"> <i class="ik ik-edit"></i></a>
                                                                <a href="{{ route('panel.admin.user_note.delete', $item->id) }}" class="btn btn-block btn-icon btn-sm btn-outline-danger delete-item"><i class="ik ik-trash"></i></a>        
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>    
                                        </div>
                                        {{-- <div class="card-body">
                                            @foreach (fetchGet('App\Models\UserNote', 'where', 'type_id', '=', $lead->id) as $index => $item)
                                            <div class="">
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <h6>{{ $item->title }}</h6>
                                                    <div class="d-flex mb-1" style="align-items: baseline;">
                                                        <small class="text-right">{{ $item->created_at }}</small>
                                                        <a href="javascript:void(0);" class="btn edit-btn btn-block btn-icon btn-sm btn-outline-warning ml-1" data-toggle="modal" data-target="#editModalCenter"> <i class="ik ik-edit"></i></a>
                                                        <a href="{{ route('panel.admin.user_note.delete', $item->id) }}" class="btn btn-block btn-icon btn-sm btn-outline-danger ml-1 delete-item"><i class="ik ik-trash"></i></a>
                                                    </div>
                                                </div>
                                                <textarea readonly class="form-control edit-text" rows="2" name="description" id="description" placeholder="Enter Description" required>{{ isset($item->description) ? $item->description : ''}}</textarea>
                                            </div>
                                            @endforeach
                                        </div> --}}
                                    </div>
                                    <div class="tab-pane fade" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                        <div class="card-body">
                                            <div class="card-header p-2 d-flex justify-content-between align-items-center">
                                                <h3>{{ __('Conatact')}}</h3>
                                                <a href="javacript:void(0);" class="btn btn-icon btn-sm btn-outline-primary" data-toggle="modal" data-target="#ContactModalCenter" title="Add New Contact"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="card-body" style="overflow: auto">
                                                <table  class="table data_table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Job Title</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Gender</th>
                                                            <th>Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(fetchGet('App\Models\Contact', 'where', 'type_id', '=', $lead->id) as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->first_name }}</td>
                                                                <td>{{ $item->last_name }}</td>
                                                                <td>{{ $item->job_title }}</td>
                                                                <td>{{ $item->email }}</td>
                                                                <td>{{ $item->phone }}</td>
                                                                <td>{{ $item->gender }}</td>
                                                                <td>{{ $item->type }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="pills-security-tab">
                                        <div class="card-body">
                                            {{ 'No Activity Yet !!!!' }}
                                        </div>
                                    </div>
                                </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        

    {{-- Note Modal Start --}}
    {{-- Note Create form --}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Add Note')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.admin.user_note.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="{{ 'Lead Note' }}">
                        <input type="hidden" name="type_id" value="{{ $lead->id }}">
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                    <label for="title" class="control-label">{{ 'Title' }}</label>
                                    <input class="form-control" name="title" type="text" id="title" placeholder="Enter Title" value="{{ isset($note->title) ? $note->title : ''}}" required>
                                </div>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                    <label for="description" class="control-label">{{ 'Description' }}</label>
                                    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" placeholder="Enter Description" required>{{ isset($note->description) ? $note->description : ''}}</textarea>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Note Edit form --}}
    <div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Edit Note')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form  id="editNoteForm" method="post">
                        @csrf
                        <input type="hidden" name="type" value="{{ 'Lead Note' }}">
                        <input type="hidden" name="type_id" id="note-type_id" >
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                    <label for="title" class="control-label">{{ 'Title' }}</label>
                                    <input class="form-control" name="title" type="text" id="note-title" placeholder="Enter Title" required>
                                </div>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                    <label for="description" class="control-label">{{ 'Description' }}</label>
                                    <textarea class="form-control" rows="5" name="description" type="textarea" id="note-description" placeholder="Enter Description" required></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Note Modal End --}}

    {{-- Contact Modal Start --}}
    <div class="modal fade" id="ContactModalCenter" tabindex="-1" role="dialog" aria-labelledby="contactModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalCenterLabel">{{ __('Add Contact')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.admin.contact.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="{{ 'Lead Contact' }}">
                        <input type="hidden" name="type_id" value="{{ $lead->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6 {{ $errors->has('first_name') ? 'has-error' : ''}}">
                                        <label for="first_name" class="control-label">{{ 'Name' }}</label>
                                        <input class="form-control" name="first_name" type="text" id="first_name" placeholder="Enter First Name" value="{{ isset($lead->name) ? $lead->name : ''}}" required>
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('last_name') ? 'has-error' : ''}}">
                                        <label for="last_name" class="control-label">{{ 'Last Name' }}</label>
                                        <input class="form-control" name="last_name" type="text" id="last_name" placeholder="Enter Last Name"  value="{{ isset($lead->last_name) ? $lead->last_name : ''}}" required>
                                    </div>

                                    <div class="form-group col-md-6 {{ $errors->has('job_title') ? 'has-error' : ''}}">
                                        <label for="job_title" class="control-label">{{ 'Job Title' }}</label>
                                        <input class="form-control" name="job_title" type="text" id="job_title" placeholder="Enter Job Title" value="{{ isset($lead->job_title) ? $lead->job_title : ''}}" required>
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('email') ? 'has-error' : ''}}">
                                        <label for="email" class="control-label">{{ 'Email' }}</label>
                                        <input class="form-control" name="email" type="email" id="email" placeholder="Enter Email" value="{{ isset($lead->email) ? $lead->email : ''}}" required>
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('phone') ? 'has-error' : ''}}">
                                        <label for="phone" class="control-label">{{ 'phone' }}</label>
                                        <input class="form-control" name="phone" type="number" id="phone" placeholder="Enter Phone" value="{{ isset($lead->phone) ? $lead->phone : ''}}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gender">{{ __('Gender')}}<span class="text-red">*</span></label>
                                        <div class="form-radio form-group">
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" name="gender" value="male" checked>
                                                        <i class="helper"></i>{{ __('Male')}}
                                                    </label>
                                                </div>
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" name="gender" value="female">
                                                        <i class="helper"></i>{{ __('Female')}}
                                                    </label>
                                                </div>
                                        </div> 
                                    </div>   
                                </div>

                            </div>
                            <div class="col-md-12 mx-auto"> 
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Contact Modal End --}}

    {{-- Custom Mail Start --}}
    <div class="modal fade" id="customMailModalCenter" tabindex="-1" role="dialog" aria-labelledby="customMailModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:900px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customMailModalLongTitle">{{ __('Compose a new mail')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.admin.email.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="user_selection">Send To</label>
                                    <select name="user_selection" id="user_selection" class="form-control">
                                        <option value="">--Select User--</option>
                                        <option value="new">New Email ID</option>
                                        @foreach(UserList() as $user)
                                            <option value="{{ $user->email }}">{{ $user->name }}</option>
                                        @endforeach
                                        @foreach(UserList() as $user)
                                            <option value="{{ $user->email }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id="email-container">
                                    <label for="email">To</label>
                                    <textarea type="email" class="form-control" name="email" id="email" placeholder="Email"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="cc">CC</label>
                                    <input type="email" class="form-control" name="cc" id="cc" placeholder="CC Email">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bcc">BCC</label>
                                    <input type="email" class="form-control" name="bcc" id="bcc" placeholder="BCC Email">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-10">
                                <div class="form-group">
                                    <label for="attach">Attach</label>
                                    <select name="attach[]" id="attach" class="form-control" multiple> 
                                        @foreach(UserList() as $user)
                                            <option value="{{ $user->email }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-2">
                                <div class="form-group mt-4">
                                    <button type="button" class="btn btn-primary" id="prepareMessage">Prepare Message</button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control html-editor" rows="6" name="message" id="message" placeholder="Message" style="resize: none"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="body">Body</label>
                                    <textarea class="form-control" required rows="6" name="body" id="bodytextarea" placeholder="Body" style="resize: none"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"> <i class="ik ik-send"></i> Send</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Custom Mail End --}}

    <!-- push external js -->
    @push('script')
        <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
        <script>
            var options = {
                    filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                    filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                    filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                    filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
                };
                $(window).on('load', function (){
                    CKEDITOR.replace('message', options);
                });
                $(window).on('load', function (){
                    CKEDITOR.replace('bodytextarea', options);
                });
        </script>
        <script>
            $(document).ready(function() {
                $('#prepareMessage').on('click', function(){
                    var user_emails = $('#attach').val();
                    var url = "{{ route('panel.admin.email.msg.prepare') }}";
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {user_emails:user_emails},
                        dataType: "html",
                        success: function(resultData) { 
                            console.log(resultData);
                            // $('#bodytextarea').val();
                            // $( '#bodytextarea' ).val( resultData );
                            // $( '#bodytextarea' ).html( resultData );
                            CKEDITOR.instances['bodytextarea'].setData(resultData);
                            // $( 'textarea.body' ).val('');
                            // $('#body').html('');
                            // $("#body").html(resultData);
                        }
                    });
                });

                $('#email-container').hide();
                $(document).on('change', '#user_selection', function (e) {
                    var old_value = $('#email').val();
                    var email = e.target.value;
                    var emails;
                    if(old_value != ''){
                    emails = old_value+','+email;
                    }
                    else{
                        emails = email;
                    }
                    if(email !== 'new'){
                        $('#email').val(emails);
                    } else {
                        $('#email').val('');
                    }

                    $('#email-container').fadeIn(250);
                    if (email == ''){
                        $('#email-container').fadeOut(250);
                    }
                });
            });
        </script>
        <script>
                $('.edit-note').each(function(){
                    $(this).click(function(){
                        var data = $(this).data('item');
                            $('#note-type_id').val(data.type_id);
                            $('#note-title').val(data.title);
                            $('#note-description').val(data.description);
                            var url = "{{ url('/panel/admin/manage/user-note/update') }}"+'/'+data.id;
                            $('#editNoteForm').attr('action',url);
                            $('#editModalCenter').modal('show');
                    })
                });
                    $(".edit-text").attr("readonly");
            $('.edit-btn').each(function(){
                $(this).click(function(){
                    $(".edit-text").attr("readonly");
                        $(this).parent().parent().parent().find($('.edit-text')).removeAttr('readonly');
                });
            });
            $(document).ready(function() {
                var table = $('.data_table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-success',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },
                        'colvis',
                        {
                            extend: 'print',
                            className: 'btn-sm btn-primary',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            }
                        }
                    ]

                });
            });
        </script>
    @endpush
@endsection
