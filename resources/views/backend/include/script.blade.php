    {{-- Ajax CSRF initialization --}}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{ asset('backend/all.js') }}"></script>

<!-- Stack array for including inline js or scripts -->
@stack('script')



<script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('backend/js/datatables.js') }}"></script>
{{-- Bootstrap CDN --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>


{{-- JQUERY CONFIRM CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>

<!--get role wise permissiom ajax script-->
<script src="{{ asset('backend/js/get-role.js') }}"></script>


{{-- <script src="{{ asset('backend/js/alerts.js')}}"></script> --}}

<script src="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
{{-- start ------------ important js code must include in all backend pages  --}}
<script src="{{ asset('backend/js/form-components.js') }}"></script>

{{-- Date Range Filter JS Code Start --}}

<!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        @include('backend.include.world')
        
{{-- @include('backend.modal.speech-to-text')
<script src="{{ asset('backend/js/speechRecognition.js') }}"></script> --}}
<script type="text/javascript">
    $(function () {
        let dateInterval = getQueryParameter('date_filter');
        let start = moment().startOf('isoWeek');
        let end = moment().endOf('isoWeek');
        if (dateInterval) {
            dateInterval = dateInterval.split(' - ');
            start = dateInterval[0];
            end = dateInterval[1];
        }
        $('#date_filter').daterangepicker({
            "showDropdowns": true,
            "showWeekNumbers": true,
            "alwaysShowCalendars": true,
            startDate: start,
            endDate: end,
            locale: {
                format: 'YYYY-MM-DD',
                firstDay: 1,
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                'All time': [moment().subtract(30, 'year').startOf('month'), moment().endOf('month')],
            }
        });
    });
    function getQueryParameter(name) {
        const url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
</script>
{{-- Date Range Filter JS Code End --}}

<script>    
    function menuSearch(){
        var filter, item;
        filter = $("#menu-search").val().trim().toLowerCase();
        items = $("#main-menu-navigation").find("a");
        items = items.filter(function(i,item){
            if($(item).html().trim().toLowerCase().indexOf(filter) > -1  && $(item).attr('href') !== '#'){
                return item;
            }
        });
        if(filter !== ''){
            $("#main-menu-navigation").addClass('d-none');
            $("#search-menu-navigation").html('')
            if(items.length > 0){
                for (i = 0; i < items.length; i++) {
                    const text = $(items)[i].innerText;
                    const link = $(items[i]).attr('href');
                    $("#search-menu-navigation").append(`<div class="nav-item"><a href="${link}" class="a-item"><i class="ik ik-more-horizontal"></i><span>${text}</span></a></li`);
                }
            }else{
                $("#search-menu-navigation").html(`<div class="nav-item"><span	class="text-center text-muted d-block">{{ _('Nothing Found') }}</span></div>`);
            }
        }else{
            $("#main-menu-navigation").removeClass('d-none');
            $("#search-menu-navigation").html('')
        }
    }  

    $('.sidebar-content').animate({
        scrollTop: $('.active').offset().top - 70
    }, 1000);
</script>

<script src="{{ asset('backend/dist/js/theme.js') }}"></script>

{{-- <script src="{{ asset('backend/js/chat.js') }}"></script> --}}

{{-- end ------------ important js code must include in all backend pages  --}}

@if (session('success'))
<script>
    $.toast({
      heading: 'SUCCESS',
      text: "{{ session('success') }}",
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: '#f96868',
      position: 'top-right'
    });
</script>
@endif


@if(session('error'))
<script>
    $.toast({
      heading: 'ERROR',
      text: "{{ session('error') }}",
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#f2a654',
      position: 'top-right'
    });
</script>
@endif
<script>
    $(document).on('click','.delete-item',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = $(this).data('msg') ?? "You won't be able to revert back!";
        $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: msg,
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Delete',
                    btnClass: 'btn-red',
                    action: function(){
                            window.location.href = url;
                    }
                },
                close: function () {
                }
            }
        });
    });
    $(document).on('click','.confirm-btn',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = $(this).data('msg') ?? "You won't be able to revert back!";
        $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: msg,
            type: 'blue',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-blue',
                    action: function(){
                            window.location.href = url;
                    }
                },
                close: function () {
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        // $(window).resize(function (e) { 
        //     e.preventDefault();
        //     width = $(this).innerWidth();
        //     if (width< 550) {
        //         console.log("Please Open in Desktop");
                
        //         $.toast({
        //             text: "Seller Tools : Best optimized for Laptop/Desktop", 
        //             heading: 'Note',
        //             icon: 'success', 
        //             showHideTransition: 'slide', 
        //             allowToastClose: true,
        //             hideAfter: 3000, 
        //             stack: 1, 
        //             position: 'top-right', 
        //             textAlign: 'left',
        //             loader: true,  
        //             loaderBg: '#9EC600',
        //         });
        //     }
        // });

    //     width = $(this).innerWidth();
    //         if (width< 550) {
    //             console.log("Please Open in Desktop");
                
    //             $.toast({
    //                 text: "Seller Tools : Best optimized for Laptop/Desktop", 
    //                 heading: 'Note',
    //                 icon: 'success', 
    //                 showHideTransition: 'slide', 
    //                 allowToastClose: true,
    //                 hideAfter: 3000, 
    //                 stack: 1, 
    //                 position: 'top-right', 
    //                 textAlign: 'left',
    //                 loader: true,  
    //                 loaderBg: '#9EC600',
    //             });
    //         }
    // });
</script>
{!! getSetting('plugin_script') !!}