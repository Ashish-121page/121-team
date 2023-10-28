<div id="animatedModal1">
    <div id="btn-close-modal1" class="close-animatedModal1 custom-spacing" style="color:black; font-size: 1.5rem">
        <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
    </div>
    <div class="modal-content custom-spacing" style="background-color:#f3f3f3; height: 80%; width: 80%;">
       

        
            <div class="col-12">
                {{-- <div class="row justify-content-between" style="display: flex;justify-content: center;align-items: center;height: 73vh;"> --}}
                    <div class="row" style="display: flex; justify-content: center; align-items: center; height: 73vh;">
                    <div class="col-4 my-1" style="padding-left: 55px !important;">
                        <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug)  }}?firstview" target="_blank">
                            <svg width="150px" height="150px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#6666cc" d="M960 1024H640c-35.344 0-64-28.656-64-64V640c0-35.344 28.656-64 64-64h320c35.344 0 64 28.656 64 64v320c0 35.344-28.656 64-64 64zm0-384H640v320h320V640zm0-192H640c-35.344 0-64-28.656-64-64V64c0-35.344 28.656-64 64-64h320c35.344 0 64 28.656 64 64v320c0 35.344-28.656 64-64 64zm0-384H640v320h320V64zm-576 960H64c-35.344 0-64-28.656-64-64V640c0-35.344 28.656-64 64-64h320c35.344 0 64 28.656 64 64v320c0 35.344-28.656 64-64 64zm0-384H64v320h320V640zm0-192H64c-35.344 0-64-28.656-64-64V64C0 28.656 28.656 0 64 0h320c35.344 0 64 28.656 64 64v320c0 35.344-28.656 64-64 64zm0-384H64v320h320V64z"/>
                            </svg>
                        </a>                        
                    </div>

                    <div class="col-4 my-1">
                        <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug)  }}?latest-view" target="_blank">
                            
                            <svg width="150px" height="150x" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#6666cc" fill-rule="evenodd" d="M14 5H2V3h12v2zm0 4H2V7h12v2zM2 13h12v-2H2v2z" clip-rule="evenodd"/>
                            </svg>
                        </a>                        
                    </div>

                    <div class="col-4 my-1">
                        <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug)  }}?row-view" target="_blank">
                            <svg width="150px" height="150px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#6666cc" d="M10.001 7.8a2.2 2.2 0 1 0 0 4.402A2.2 2.2 0 0 0 10 7.8zm-7 0a2.2 2.2 0 1 0 0 4.402A2.2 2.2 0 0 0 3 7.8zm14 0a2.2 2.2 0 1 0 0 4.402A2.2 2.2 0 0 0 17 7.8z"/>
                            </svg>

                        </a>                        
                    </div>

                    <div class="col-4 my-1">
                        <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug)  }}?secondview" target="_blank">
                            <svg width="150px" height="150px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" stroke="#6666cc" stroke-linecap="round" stroke-width="2" d="M5 9h14M5 15h14"/>
                            </svg>
                        </a>                        
                    </div>
                    <div class="col-4 my-1">
                        <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug)  }}?hz-secondview" target="_blank">
                            <svg width="150px" height="150px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#6666cc" d="M14.001 7.8a2.2 2.2 0 1 0 0 4.402A2.2 2.2 0 0 0 14 7.8zm-8 0a2.2 2.2 0 1 0 0 4.402A2.2 2.2 0 0 0 6 7.8z"/>
                            </svg>
                        </a>                        
                    </div>

                    <div class="col-4 my-1">
                        <a href="{{ inject_subdomain('shop/proposal/'.$proposal->slug, $user_shop_record->slug)  }}?thirdview" target="_blank">
                            <svg width="150px" height="150px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#6666cc" d="M4 3.5a.5.5 0 0 0-.5.5v1.614a.75.75 0 0 1-1.5 0V4a2 2 0 0 1 2-2h1.614a.75.75 0 0 1 0 1.5H4Zm5.636-.75a.75.75 0 0 1 .75-.75H12a2 2 0 0 1 2 2v1.614a.75.75 0 0 1-1.5 0V4a.5.5 0 0 0-.5-.5h-1.614a.75.75 0 0 1-.75-.75ZM2.75 9.636a.75.75 0 0 1 .75.75V12a.5.5 0 0 0 .5.5h1.614a.75.75 0 0 1 0 1.5H4a2 2 0 0 1-2-2v-1.614a.75.75 0 0 1 .75-.75Zm10.5 0a.75.75 0 0 1 .75.75V12a2 2 0 0 1-2 2h-1.614a.75.75 0 1 1 0-1.5H12a.5.5 0 0 0 .5-.5v-1.614a.75.75 0 0 1 .75-.75Z"/>
                            </svg>
                        </a>                        
                    </div> 
                </div>
            </div>
        

        
        

    </div>
</div>