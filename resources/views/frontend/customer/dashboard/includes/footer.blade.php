<footer class="footer">

    {{-- <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-30 footer-border">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="uil uil-truck align-middle h5 mb-0 me-2"></i>
                                    <h6 class="mb-0">Free delivery</h6>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="uil uil-archive align-middle h5 mb-0 me-2"></i>
                                    <h6 class="mb-0">Non-contact shipping</h6>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="uil uil-shield-check align-middle h5 mb-0 me-2"></i>
                                    <h6 class="mb-0">Secure payments</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-30 footer-border">
                    <div class="container text-center">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="text-sm-start">
                                    <p class="mb-0">Copyright © <script>document.write(new Date().getFullYear())</script> All Right Reserved</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-0 text-center">{{ getSetting('app_name') }}</p> 
                            </div>
                            <div class="col-md-4">
                                    <ul class="policy-menu d-flex">
                                        <li class="m-2"><a class="text-muted" href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                                        <li class="m-2"><a class="text-muted" href="{{ url('page/terms') }}">Terms & Conditions</a></li>
                                    </ul>
                            </div>
                        </div><!--end row-->
                    </div><!--end container-->
                </div>
            </div>
        </div>
    </div><!--end container-->
</footer>