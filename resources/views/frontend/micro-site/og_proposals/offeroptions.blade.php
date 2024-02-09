
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
        /* text-align: center; */
        cursor:pointer;
        color:#fff;
        left: 50%;
        postion:fixed;
        
    }

    .icon-container {
    margin-left: 5px; /* Adjust the distance between text and icon */
    }

    .fa-file-alt {
    font-size: 20px; /* Increase the size of the icon */
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
                    <h3><span class="text-center" style="text-align: center!important; position: relative; left: 3rem;">Change Styles</span></h3>
                    <hr/>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between">
                    <div class="col-12 my-3 py-2">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <svg width="64" height="64" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#6666cc" d="M17.924 7.154h-.514l.027-1.89a.464.464 0 0 0-.12-.298L12.901.134A.393.393 0 0 0 12.618 0h-9.24a.8.8 0 0 0-.787.784v6.37h-.515c-.285 0-.56.118-.76.328A1.14 1.14 0 0 0 1 8.275v5.83c0 .618.482 1.12 1.076 1.12h.515v3.99A.8.8 0 0 0 3.38 20h13.278c.415 0 .78-.352.78-.784v-3.99h.487c.594 0 1.076-.503 1.076-1.122v-5.83c0-.296-.113-.582-.315-.792a1.054 1.054 0 0 0-.76-.328ZM3.95 1.378h6.956v4.577a.4.4 0 0 0 .11.277a.37.37 0 0 0 .267.115h4.759v.807H3.95V1.378Zm0 17.244v-3.397h12.092v3.397H3.95ZM12.291 1.52l.385.434l2.58 2.853l.143.173h-2.637c-.2 0-.325-.033-.378-.1c-.053-.065-.084-.17-.093-.313V1.52ZM3 14.232v-6h1.918c.726 0 1.2.03 1.42.09c.34.09.624.286.853.588c.228.301.343.69.343 1.168c0 .368-.066.678-.198.93c-.132.25-.3.447-.503.59a1.72 1.72 0 0 1-.62.285c-.285.057-.698.086-1.239.086h-.779v2.263H3Zm1.195-4.985v1.703h.654c.471 0 .786-.032.945-.094a.786.786 0 0 0 .508-.762a.781.781 0 0 0-.19-.54a.823.823 0 0 0-.48-.266c-.142-.027-.429-.04-.86-.04h-.577Zm4.04-1.015h2.184c.493 0 .868.038 1.127.115c.347.103.644.288.892.552c.247.265.436.589.565.972c.13.384.194.856.194 1.418c0 .494-.06.92-.182 1.277c-.148.437-.36.79-.634 1.06c-.207.205-.487.365-.84.48c-.263.084-.616.126-1.057.126H8.235v-6ZM9.43 9.247v3.974h.892c.334 0 .575-.019.723-.057c.194-.05.355-.132.482-.25c.128-.117.233-.31.313-.579c.081-.269.121-.635.121-1.099c0-.464-.04-.82-.12-1.068a1.377 1.377 0 0 0-.34-.581a1.132 1.132 0 0 0-.553-.283c-.167-.038-.494-.057-.98-.057H9.43Zm4.513 4.985v-6H18v1.015h-2.862v1.42h2.47v1.015h-2.47v2.55h-1.195Z"/>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex my-3">
                                            <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}" class="btn btn-outline-primary mx-5">
                                               Preview
                                            </a>
                                            <a class="link btn-outline-primary mx-5" id="jaya1" href="#animatedModal1" role="button" style="text-decoration: underline;">Change Style</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <svg width="64" height="64" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#6666cc" d="M2.5 6.5V6H2v.5h.5Zm4 0V6H6v.5h.5Zm7-3h.5v-.207l-.146-.147l-.354.354Zm-3-3l.354-.354L10.707 0H10.5v.5ZM2.5 7h1V6h-1v1Zm.5 4V8.5H2V11h1Zm0-2.5v-2H2v2h1Zm.5-.5h-1v1h1V8Zm.5-.5a.5.5 0 0 1-.5.5v1A1.5 1.5 0 0 0 5 7.5H4ZM3.5 7a.5.5 0 0 1 .5.5h1A1.5 1.5 0 0 0 3.5 6v1Zm3 0h1V6h-1v1Zm.5 4V8.5H6V11h1Zm0-2.5v-2H6v2h1Zm.5-.5h-1v1h1V8Zm.5-.5a.5.5 0 0 1-.5.5v1A1.5 1.5 0 0 0 9 7.5H8ZM7.5 7a.5.5 0 0 1 .5.5h1A1.5 1.5 0 0 0 7.5 6v1ZM11 6v5h1V6h-1Zm-1 1h3V6h-3v1ZM2 5V1.5H1V5h1Zm11-1.5V5h1V3.5h-1ZM2.5 1h8V0h-8v1Zm7.646-.146l3 3l.708-.708l-3-3l-.708.708ZM2 1.5a.5.5 0 0 1 .5-.5V0A1.5 1.5 0 0 0 1 1.5h1ZM1 12v1.5h1V12H1Zm1.5 3h10v-1h-10v1ZM14 13.5V12h-1v1.5h1ZM12.5 15a1.5 1.5 0 0 0 1.5-1.5h-1a.5.5 0 0 1-.5.5v1ZM1 13.5A1.5 1.5 0 0 0 2.5 15v-1a.5.5 0 0 1-.5-.5H1Z"/>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex my-3">
                                            <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}?download=ppt" class="btn btn-outline-primary mx-5">
                                               Preview
                                            </a>
                                            <a class="link btn-outline-primary mx-5" id="jaya3" href="#animatedModal3" role="button" style="text-decoration: underline;">Change Style</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <svg width="64" height="64" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#6666cc" d="M15.534 1.36L14.309 0H4.662c-.696 0-.965.516-.965.919v3.63H5.05V1.653c0-.154.13-.284.28-.284h6.903c.152 0 .228.027.228.152v4.82h4.913c.193 0 .268.1.268.246v11.77c0 .246-.1.283-.25.283H5.33a.287.287 0 0 1-.28-.284V17.28H3.706v1.695c-.018.6.302 1.025.956 1.025H18.06c.7 0 .939-.507.939-.969V5.187l-.35-.38l-3.116-3.446Zm-1.698.16l.387.434l2.596 2.853l.143.173h-2.653c-.2 0-.327-.033-.38-.1c-.053-.065-.084-.17-.093-.313V1.52Zm-1.09 9.147h4.577v1.334h-4.578v-1.334Zm0-2.666h4.577v1.333h-4.578V8Zm0 5.333h4.577v1.334h-4.578v-1.334ZM1 5.626v10.667h10.465V5.626H1Zm5.233 6.204l-.64.978h.64V14H3.016l2.334-3.51l-2.068-3.156H5.01L6.234 9.17l1.223-1.836h1.727L7.112 10.49L9.449 14H7.656l-1.423-2.17Z"/>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex my-3">
                                            <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug) }}?download=excel" class="btn btn-outline-primary mx-5">
                                               Preview
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
             color: 'transparent',
             height: '80%',
             width: '60%',
             top: '10%',
             left: '49%',
             position:'fixed'
             
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