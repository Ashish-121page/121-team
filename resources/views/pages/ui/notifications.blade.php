@extends('backend.layouts.main') 
@section('title', 'Notifications')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.css')}}">
    @endpush
 
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-gitlab bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Notifications')}}</h5>
                            <span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('panel.dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('UI')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Advanced')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Notifications')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Jquery Toast Styles')}}</h3></div>
                    <div class="card-body">
                        <p>Click on the below buttons for notifications in different styles.</p>
                        <p>The <code>icon</code> property can be used to specify the predefined types of toasts - success, info, warning and danger</p>
                        <div class="template-demo">
                            <button type="button" class="btn btn-success btn-fw" onclick="showSuccessToast()">{{ __('Success')}}</button>
                            <button type="button" class="btn btn-info btn-fw" onclick="showInfoToast()">{{ __('Info')}}</button>
                            <button type="button" class="btn btn-warning btn-fw" onclick="showWarningToast()">{{ __('Warning')}}</button>
                            <button type="button" class="btn btn-danger btn-fw" onclick="showDangerToast()">{{ __('Danger')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Jquery Toast Positions')}}</h3></div>
                    <div class="card-body">
                        <p>The <code>position</code> property can be used to specify the predefined positions of toasts</p>
                        <div class="template-demo">
                            <button type="button" class="btn btn-primary btn-sm" onclick="showToastPosition('bottom-left')">{{ __('Bottom Left')}}</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="showToastPosition('bottom-right')">{{ __('Bottom Right')}}</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="showToastPosition('bottom-center')">{{ __('Bottom Center')}}</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="showToastPosition('top-left')">{{ __('Top Left')}}</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="showToastPosition('top-right')">{{ __('Top Right')}}</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="showToastPosition('top-center')">{{ __('Top Center')}}</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="showToastPosition('mid-center')">{{ __('Mid Center')}}</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="showToastInCustomPosition()">{{ __('Custom')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __(' Jquery-Confirm!')}}</h3></div>
                    <div class="card-body">
                        <p>For more information <code><a href="https://craftpip.github.io/jquery-confirm/" target="_blank" class="text-primary">click here.</a></code>
                        <div class="template-demo">
                            <button class="alert btn btn-danger">Alert</button>
                            <button class="confirm btn btn-primary">Confirm</button>
                            <button class="prompt btn btn-warning">Prompt</button>
                            <button class="dialog btn btn-success">Movable Dialog</button>
                            <a class="home-confirm btn btn-info" data-title="Goto home?" href="{{ url('/') }}">Goto Home</a>
                            
                            <button class="error btn btn-danger">Error Red Dialog</button>
                            <button class="success-dialog btn btn-success">Success Green Dialog</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')      
        <script src="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
        
        <script src="{{ asset('backend/js/alerts.js')}}"></script>

        <script>
            

                // Confirm Alert
            $('.alert').click(function(){
                $.alert({
                    title: 'Alert!',
                    content: 'Simple alert!',
                });
            });
               //Simple Confirm 
            $('.confirm').click(function(){
                $.confirm({
                    title: 'Confirm!',
                    content: 'Simple confirm!',
                    buttons: {
                        confirm: function () {
                            $.alert('Confirmed!');
                        },
                        cancel: function () {
                            $.alert('Canceled!');
                        },
                        somethingElse: {
                            text: 'Something',
                            btnClass: 'btn-blue',
                            keys: ['enter', 'shift'],
                            action: function(){
                                $.alert('Something else?');
                            }
                        }
                    }
                });
            });
                // Confirm-Prompt 
            $('.prompt').click(function(){
                $.confirm({
                    title: 'Prompt!',
                    content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Enter something here</label>' +
                    '<input type="text" placeholder="Your name" class="name form-control" required />' +
                    '</div>' +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.name').val();
                                if(!name){
                                    $.alert('provide a valid name');
                                    return false;
                                }
                                $.alert('Your name is ' + name);
                            }
                        },
                        cancel: function () {
                            //close
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            });
            // Confirm dialog
            $('.dialog').click(function(){
                $.dialog({
                    title: 'Text content!',
                    content: 'Simple modal!',
                });
            });
            // $.fn.confirm                   
            $('a.home-confirm').click(function(){
                $.confirm({
                    buttons: {
                        hey: function(){
                            location.href = this.$target.attr('href');
                        }
                    }
                });
            })
            // Red Alerts
            $('.error').click(function(){
                $.confirm({
                    title: 'Encountered an error!',
                    content: 'Something went downhill, this may be serious',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Try again',
                            btnClass: 'btn-red',
                            action: function(){
                            }
                        },
                        close: function () {
                        }
                    }
                });
            })
             // Success Alerts
            $('.success-dialog').click(function(){
                $.confirm({
                    title: 'Congratulations!',
                    content: 'Consider something great happened, and you have to show a positive message.',
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Thankyou',
                            btnClass: 'btn-green',
                            action: function(){
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });

               
        </script>
      
    @endpush
@endsection
        