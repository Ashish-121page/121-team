@extends('backend.layouts.main') 
@section('title', 'Calendar')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/fullcalendar/dist/fullcalendar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
    @endpush
    
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-calendar bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Calendar')}}</h5>
                            <span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                {{-- <a href="{{route('panel.dashboard')}}"><i class="ik ik-home"></i></a> --}}
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('UI Element')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Calendar')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="editEvent" tabindex="-1" role="dialog" aria-labelledby="editEventLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="editEventForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editEventLabel">{{ __('Edit Event')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="EditId">
                            <div class="form-group">
                                <label for="editEname">{{ __('Event Title')}}</label>
                                <input type="text" class="form-control" id="editEname" name="editEname" placeholder="Please enter event title">
                            </div>
                            <div class="form-group">
                                <label for="editStarts">{{ __('Start')}}</label>
                                {{-- <input type="datetime-local" class="form-control" id="editStarts" name="editStarts" data-toggle="datetimepicker" data-target="#editStarts"> --}}
                                <input type="text" class="form-control datetimepicker-input" id="editStarts" name="editStarts" data-toggle="datetimepicker" data-target="#editStarts">
                            </div>
                            <div class="form-group">
                                <label for="editEnds">{{ __('End')}}</label>
                                <input type="text" class="form-control datetimepicker-input" id="editEnds" name="editEnds" data-toggle="datetimepicker" data-target="#editEnds">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                            <button class="btn btn-danger delete-event" type="button">{{ __('Delete')}}</button>
                            <button class="btn btn-success save-event" type="submit">{{ __('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> 

        <div class="modal" id="addEvent" tabindex="-1" role="dialog" aria-labelledby="addEventLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEventLabel">{{ __('Add New Event')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="addEventForm">
                            <div class="form-group">
                                <label for="eventName">{{ __('Event Title')}}</label>
                                <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Please enter event title">
                            </div>
                            <div class="form-group">
                                <label for="eventStarts">{{ __('Starts')}}</label>
                                <input type="text" class="form-control datetimepicker-input" id="eventStarts" name="eventStarts" data-toggle="datetimepicker" data-target="#eventStarts">
                            </div>
                            <div class="form-group">
                                <label for="eventEnds">{{ __('Ends')}}</label>
                                <input type="text" class="form-control datetimepicker-input" id="eventEnds" name="eventEnds" data-toggle="datetimepicker" data-target="#eventEnds">
                            </div>
                            <div class="form-group mb-0" id="addColor">
                                <label for="colors">{{ __('Choose Color')}}</label>
                                <ul class="color-selector">
                                    <li class="bg-aqua">
                                        <input type="radio" value="bg-aqua" data-color="" checked name="colorChosen" id="addColorAqua">
                                        <label for="addColorAqua"></label>
                                    </li>
                                    <li class="bg-blue">
                                        <input type="radio" value="bg-blue" data-color="" name="colorChosen" id="addColorBlue">
                                        <label for="addColorBlue"></label>
                                    </li>
                                    <li class="bg-light-blue">
                                        <input type="radio" value="bg-light-blue" data-color="bg-light-blue" name="colorChosen" id="addColorLightblue">
                                        <label for="addColorLightblue"></label>
                                    </li>
                                    <li class="bg-teal">
                                        <input type="radio" value="bg-teal" data-color="" name="colorChosen" id="addColorTeal">
                                        <label for="addColorTeal"></label>
                                    </li>
                                    <li class="bg-yellow">
                                        <input type="radio" value="bg-yellow" data-color="" name="colorChosen" id="addColorYellow">
                                        <label for="addColorYellow"></label>
                                    </li>
                                    <li class="bg-orange">
                                        <input type="radio" value="bg-orange" data-color="" name="colorChosen" id="addColorOrange">
                                        <label for="addColorOrange"></label>
                                    </li>
                                    <li class="bg-green">
                                        <input type="radio" value="bg-green" data-color="" name="colorChosen" id="addColorGreen">
                                        <label for="addColorGreen"></label>
                                    </li>
                                    <li class="bg-lime">
                                        <input type="radio" value="bg-lime" data-color="" name="colorChosen" id="addColorLime">
                                        <label for="addColorLime"></label>
                                    </li>
                                    <li class="bg-red">
                                        <input type="radio" value="bg-red" data-color="" name="colorChosen" id="addColorRed">
                                        <label for="addColorRed"></label>
                                    </li>
                                    <li class="bg-purple">
                                        <input type="radio" value="bg-purple" data-color="" name="colorChosen" id="addColorPurple">
                                        <label for="addColorPurple"></label>
                                    </li>
                                    <li class="bg-fuchsia">
                                        <input type="radio" value="bg-fuchsia" data-color="" name="colorChosen" id="addColorFuchsia">
                                        <label for="addColorFuchsia"></label>
                                    </li>
                                    <li class="bg-muted">
                                        <input type="radio" value="bg-muted" data-color="" name="colorChosen" id="addColorMuted">
                                        <label for="addColorMuted"></label>
                                    </li>
                                    <li class="bg-navy">
                                        <input type="radio" value="bg-navy" data-color="" name="colorChosen" id="addColorNavy">
                                        <label for="addColorNavy"></label>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="button" class="btn btn-success save-event">{{ __('Save')}}</button>
                        {{-- <button type="button" class="btn btn-danger delete-event" data-dismiss="modal">{{ __('Delete')}}</button> --}}
                    </div>
                </div>
            </div>
        </div> 
    </div>


    <!-- push external js -->
    @push('script') 
    
    <script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('backend/plugins/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/js/calendar.js') }}"></script> --}}
       
        <script>
            $(document).ready(function(t, e, i) {
                function t(t) {
                    t.each(function() {
                        var t = {
                            title: $.trim($(this).text())
                        };
                        $(this).data("eventObject", t), $(this).draggable({
                            zIndex: 1070,
                            revert: !0,
                            revertDuration: 0
                        })
                    })
                }
                t($("#external-events div.external-event"));
                    var e = new Date,
                        i = e.getDate(),
                        n = e.getMonth(),
                        r = e.getFullYear();
                    var calendar = $("#calendar").fullCalendar({
                        header: {
                            left: "prev,next today",
                            center: "title",
                            right: "month,agendaWeek,agendaDay"
                        },
                        buttonText: {
                            today: "today",
                            month: "month",
                            week: "week",
                            day: "day"
                        },
                        events: [
                            @foreach($data as $index => $eventdata)
                                    {
                                    title: "{{ $eventdata->event_name }}",
                                    id: "{{ $eventdata->id }}",
                                    start: "{{ $eventdata->start }}",
                                    end: "{{ $eventdata->end }}",
                                    className: "{{ $eventdata->color_code }}"
                                    },
                            @endforeach
                        ],
                        timezone: 'local',
                        editable: !0,
                        selectable: !0,
                        droppable: !0,
                        drop: function(t, e) {
                            // alert('s');
                            var i = $(this).data("eventObject"),
                                n = $.extend({}, i);
                            n.start = t, n.allDay = e, n.backgroundColor = $(this).css("background-color"), n.borderColor = $(this).css("border-color"), $("#calendar").fullCalendar("renderEvent", n, !0), $("#drop-remove").is(":checked") && $(this).remove()
                        },
                        eventClick: function(calEvent, jsEvent, view) {
                            var $this = this;
                            // console.log(calEvent);
                            
                            console.log(calEvent.start._d);
                       
                            // alert('s');
                            var delurl = '{{ url("dev/calendar/delete-cal") }}'+'/'+calEvent.id;
                            // console.log(calEvent.start._d);
                            $("#editEname").val(calEvent.title)
                            $("#editStarts").datetimepicker("date", calEvent.start._d)
                            $("#editEnds").datetimepicker("date",calEvent.end._d)
                            $("#EditId").val(calEvent.id)
                            // $("#editEvent").modal({
                            //     backdrop: 'static'
                            // });
                            $("#editEvent").modal('show');
                            $("#editEvent").find('.delete-event').show().end().find('.delete-event').unbind('click').click(function() {
                                    $.get(delurl, function(res){
                                            console.log(res);
                                            
                                    });
                                calendar.fullCalendar('removeEvents', function(ev) {
                                    return (ev._id == calEvent._id);
                                });
                                $("#editEvent").modal('hide');
                            });
                            $(".editEventForm").on('submit', function() {
                                
                                var editformValues= $(this).serialize();
                                calEvent.title = $("#editEname").val();
                                calEvent.start = new Date($("#editStarts").data("datetimepicker").date())
                                    $.post('{!! route("dev.calendar.update") !!}', editformValues, function(data){
                                            console.log(data);
                                            // $("#calendar").fullCalendar('updateEvent', data);
                                    });
                                    calendar.fullCalendar('updateEvent', calEvent);
                                $("#editEvent").modal('hide');
                                window.location.reload();
                                return false;
                            });
                        },

                        select: function(start, end, allDay) {
                            // alert('s');
                            $("#addEvent").modal('show');
                            var $this = this;
                            // $("#addEvent").modal({
                            //     backdrop: 'static'
                            // });
                            $("#eventStarts").datetimepicker("date", start)
                            $("#eventEnds").datetimepicker("date", end)
                            var form = $("#addEventForm");
                            $("#addEvent").find('.delete-event').hide().end().find('.save-event').show().end().find('.save-event').unbind('click').click(function() {
                                form.submit();
                            });

                            $("#addEventForm").on('submit', function() {
                                var formValues= $(this).serialize();
                                var title = form.find("#eventName").val();
                                var start = form.find("#eventStarts").val();
                                var end = form.find("#eventEnds").val();
                                var categoryClass = form.find("#addColor [type=radio]:checked").data("color");
                                if (title !== null && title.length != 0) {
                                
                                    $.post('{!! route("dev.calendar.store") !!}', formValues).done(function( data ) {
                                    
                                        calendar.fullCalendar('renderEvent', {
                                                title: title,
                                                start: start,
                                                end: end,
                                                allDay: false,
                                                className: categoryClass
                                            }, true);
                                
                                    });                   
                                    $("#addEvent").modal('hide');
                                    calendar.fullCalendar('unselect');
                                } else {
                                    alert('You have to give a title to your event');
                                }
                                window.location.reload();
                                return false;                                
                            });
                            calendar.fullCalendar('unselect');

                        }
                    });
                var a = "#3c8dbc";
                $("#color-chooser-btn");
                $("#color-chooser > li > a").on("click", function(t) {
                    t.preventDefault(), a = $(this).css("color"), $("#add-new-event").css({
                        "background-color": a,
                        "border-color": a
                    })
                }), $("#add-new-event").on("click", function(e) {
                    e.preventDefault();
                    var i = $("#new-event").val();
                    if (0 != i.length) {
                        var n = $("<div />");
                        n.css({
                            "background-color": a,
                            "border-color": a,
                            color: "#fff"
                        }).addClass("external-event"), n.html(i), $("#external-events").prepend(n), t(n), $("#new-event").val("")
                    }
                });

            });
        </script>
    @endpush
@endsection
        