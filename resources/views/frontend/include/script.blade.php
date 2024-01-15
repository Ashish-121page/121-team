
    {{-- <script src="{{ asset('backend/all.js') }}"></script> --}}
        <!--Javascript-->
        @stack('script')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
            <!-- SLIDER -->
            <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
            <script src="{{ asset('frontend/assets/js/tiny-slider.js') }}"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
            <script src="{{ asset('frontend/assets/js/shuffle.min.js') }}"></script>
            <!-- Icons -->
            <script src="{{ asset('frontend/assets/js/feather.min.js') }}"></script>
            {{-- JQUERY CONFIRM CDN --}}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
            <!-- Switcher -->
            <!-- Switcher -->
            <script src="{{ asset('frontend/assets/js/switcher.js') }}"></script>
            <!-- Main Js -->
            <script src="{{ asset('frontend/assets/js/jquery.mask.min.js') }}"></script>
            <script src="{{ asset('frontend/assets/js/autoNumeric-min.js') }}"></script>
            <!-- Init js-->
            <script src="{{ asset('frontend/assets/js/app-form-masks-init.js') }}"></script>
            <script src="{{ asset('frontend/assets/js/app-plugins-init.js') }}"></script>
            <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
            <script src="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
            <script src="{{ asset('js/share.js') }}"></script>
        <!-- Google analytics -->
        <!-- End google analytics -->


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
         
            function copyToClipboard(text) {
                var inputc = document.body.appendChild(document.createElement("input"));
                inputc.value = window.location.href;
                inputc.focus();
                inputc.select();
                document.execCommand('copy');
                inputc.parentNode.removeChild(inputc);
                alert("URL Copied.");
            }

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
            
        </script>