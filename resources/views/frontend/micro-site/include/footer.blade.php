<footer class="footer">    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-30 footer-border">
                    <div class="container text-center">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="text-sm-start">
                                    <p class="mb-0">Copyright © <script>document.write(new Date().getFullYear())</script> All Rights Reserved</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-0 text-center">{{ getSetting('app_name') }}</p> 
                            </div>
                            <div class="col-md-4">
                                <ul class="policy-menu d-flex">
                                    <li class="m-2"><a class="text-muted" href="{{ remove_subdomain('page/privacy-policy',$user_shop->slug ?? '') }}">Privacy Policy</a></li>
                                    <li class="m-2"><a class="text-muted" href="{{ remove_subdomain('page/terms',$user_shop->slug ?? '') }}">Terms & Conditions</a></li>
                                </ul>
                            </div>
                        </div><!--end row-->
                    </div><!--end container-->
                </div>
            </div>
        </div>
    </div><!--end container-->
</footer>