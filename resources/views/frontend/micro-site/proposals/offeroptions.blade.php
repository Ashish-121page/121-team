
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css"> 
    {{-- Animated modal --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">

    <style>
        /* modal */
    #btn-close-modal1{
        width: 80%;
        text-align: center;
        cursor:pointer;
        color:#fff;
        left: 30%;
    }
    </style>
    <style>
        /* modal */
    #btn-close-modal3{
        width: 100%;
        text-align: center;
        cursor:pointer;
        color:#fff;
        left: 50%;
        
    }
    </style>
    @endpush

{{-- modal start --}}
<div id="animatedModal2" style="overflow-y: hidden !important;">
    <div id="btn-close-modal2" class="close-animatedModal2 custom-spacing" style="color:black; font-size: 1.5rem;">
        <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
    </div>
    <div class="modal-content custom-spacing" style="background-color:#f3f3f3; height: 90%; width: 80%;">
       

        <div class="row" style="display: flex; justify-content: center; align-items: center; height: 55vh;">
            <div class="col-md-6 col-12 mt-2">
            <div class="col-12 d-flex justify-content-center justify-content-sm-between justify-content-md-between items-align-center py=5 border-bottom">
                <h3><span class="text-center" style="text-align: center!important; position: relative; left: 5rem;">Change Styles</span></h3>
            <hr/>
            </div>
              </div>
            <div class="col-12">
                <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between ">
                    <div class="col-12 my-3 py-2">
                        <div class="row mt-3 px-3" style="display: flex;
                        align-items: center;">
                            <p>Download PDF<span> :</span></p>
                            <div class="d-flex my-3" >
                                <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}" class="btn btn-outline-primary mx-5">
                                    Download
                                </a>
                                <a class="btn btn-outline-primary mx-5" id="jaya1" href="#animatedModal1" role="button">Change Style</a>
                            </div>
                        </div>
                        <div class="row mt-3 px-3" style="display: flex;
                        align-items: center;">
                            <p >Download PPT<span> :</span></p>
                            <div class="d-flex my-3" >
                                <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}?download=ppt" class="btn btn-outline-primary mx-5">
                                    Download
                                </a>
                                <a class="btn btn-outline-primary mx-5" id="jaya3" href="#animatedModal3" role="button">Change Style</a>
                            </div>

                        </div>
                        <div class="row mt-3 px-3" style="display: flex;
                        align-items: center;">
                            <p style= "mt-5 !important "> Export Excel<span> :</span></p>
                            <div class="d-flex my-3" >
                                <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}?download=excel" class="btn btn-outline-primary mx-5">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>       
            </div>

            <div class="col-md-8 d-none">                                    
                <div class="row d-flex justify-content-center justify-content-sm-between justify-content-md-between">
                    <button class="btn btn-outline-primary my-3 px-3"  id="" type="button">Link</button>
                    <button class="btn btn-outline-success my-3 px-3"  id="" type="button">Copy</button>
                    <button class="btn btn-outline-warning my-3 px-3"  id="" type="button">W</button>
                    <button class="btn btn-outline-info my-3 px-3"  id="" type="button">E</button>
                </div>
            </div>

        </div>


    </div>
</div>


@include('frontend.micro-site.proposals.modal.change_style')
@include('frontend.micro-site.proposals.modal.change_pptstyle')

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script>
         //demo 01 change styles position
         $("#jaya1").animatedModal({
             animatedIn: 'lightSpeedIn',
             animatedOut: 'lightSpeedOut',
             color: 'white',
             height: '80%',
             width: '60%',
             top: '10%',
             left: '45%',
             
         });

         $("#jaya1").click(function () {
             $(".close-animatedModal2").click();
         })
         
    </script>

<script>
    //demo 01 change pptstyles position
    $("#jaya3").animatedModal({
        animatedIn: 'lightSpeedIn',
        animatedOut: 'lightSpeedOut',
        color: 'white',
        height: '80%',
        width: '60%',
        top: '10%',
        left: '45%',
        
    });

    $("#jaya3").click(function () {
        $(".close-animatedModal2").click();
    })
    
</script>
    
    
    @endpush