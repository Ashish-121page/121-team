    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css"> 
    {{-- Animated modal --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">

    <style>
        /* modal */
    #btn-close-modal1{
        width: 100%;
        text-align: center;
        cursor:pointer;
        color:#fff;
    }
    </style>
    @endpush

{{-- modal start --}}
<div id="animatedModal2">
    <div id="btn-close-modal2" class="close-animatedModal2 custom-spacing" style="color:black; font-size: 1.5rem;">
        <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
    </div>
    <div class="modal-content custom-spacing" style="background-color:#f3f3f3; height: 80%; width: 80%; overflow-y:hidden!important; overflow-x:hidden!important">
       

        <div class="row">
            <div class="col-12 mt-2">
            <div class="col-12 d-flex justify-content-center justify-content-sm-between justify-content-md-between items-align-center py=5 border-bottom">
                <h3><span class="text-center" style="text-align: center!important; position: relative; left: 5rem;">Change Styles</span></h3>
            <hr/>
            </div>
              </div>
            <div class="col-12">
                <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between ">
                    <div class="col-6 my-3 py-2">
                        <div class="row mt-3 px-3" style="display: flex;
                        align-items: center;">
                            <p>Download PDF:</p>
                            <div class="d-flex my-3" >
                            <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}" class="btn btn-outline-primary mx-1" target="_blank">
                                Download
                            </a>
                            <a class="btn btn-outline-primary mx-1" id="jaya1" href="#animatedModal1" role="button">Change Style</a>                
                            </div>
                        </div>
                        <div class="row mt-3 px-3" style="display: flex;
                        align-items: center;">
                            <p >Download PPT:</p>
                            <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between align-items-center flex-wrap gap-3 my-3" style="margin-left: 100px">       
                            <button onclick="getPPT()" type="button" class="btn btn-outline-info" style="position: relative; right: 5rem;">Download</button>
                            </div>
                        </div>
                        <div class="row mt-3 px-3" style="display: flex;
                        align-items: center;">
                            <p style= "mt-5 !important"> Export Excel:</p>
                            <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between align-items-center flex-wrap gap-3 my-3 " style="margin-left: 100px">
                            <button class="btn btn-outline-success" style="position: relative; right: 5rem;" id="export_button" type="button">Download</button>
                        </div> 
                        </div>
                    </div>
                </div>       
            </div>
        </div>



        <div class="col-md-8 ">                                    
            <div class="row d-flex justify-content-center justify-content-sm-between justify-content-md-between my-3 px-3">
                <button class="btn btn-outline-primary"  id="" type="button">Link</button>
                <button class="btn btn-outline-success"  id="" type="button">Copy</button>
                <button class="btn btn-outline-warning"  id="" type="button">W</button>
                <button class="btn btn-outline-info"  id="" type="button">E</button>
            </div>
        </div> 

        
        

    </div>
</div>


@include('frontend.micro-site.proposals.modal.change_style')


@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script>
         //demo 01
         $("#jaya1").animatedModal({
             animatedIn: 'lightSpeedIn',
             animatedOut: 'lightSpeedOut',
             color: 'fffff',
             height: '80%',
             width: '80%',
             top: '10%',
             left: '10%',
         });

        $("#jaya1").click(function(){
            $(".close-animatedModal2").click();
        })

        


    </script>
    @endpush