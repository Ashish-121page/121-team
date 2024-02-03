<style>
    #surverymodal input[type=checkbox] {
        display: none
    }

    #surverymodal .col {
        margin: 10px;
    }

    #surverymodal label {
        margin: 12px;
        width: 100%;
        text-align: start;
        display: block;
        align-content: center !important;
        justify-content: center;
        border: 1px solid black;
        border-radius: 5px;
        padding: 10px;
        max-height: 58px;
        min-width: 42px;
        height: 100%;
        cursor: pointer;
    }


    @media(max-width:420px) {
        #surverymodal label {
            margin: 12px;
            width: 92%;
            text-align: center;
            display: flex;
            align-content: center !important;
            justify-content: center;
            border: 1px solid black;
            border-radius: 5px;
            padding: 10px;
            max-height: 58px;
            min-width: 42px;
            height: 100%;
            cursor: pointer;
        }
    }



    input[type=checkbox]:checked+label {
        /* border: 2px solid #6666CC !important; */
        background-color: #6666CC !important;
        color: white !important;

    }

    input{
        paddding: 0px !important;
    }




</style>


<div class="modal fade" id="surverymodal" role="dialog" aria-labelledby="survery" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                {{-- Modal Header --}}
                <div class="h4 text-primary text-center w-100">Where may we help ? </div>
            </div>
            <div class="modal-body">
                {{-- MOdal Body --}}
                <form action="{{ route("customer.survey") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="ashu">
                        <div class="row">
                            <div class="col-12 col-md-4 col-sm-6 justify-content-center align-items-center">
                                <img src="{{ asset('frontend/assets/img/survey.svg') }}" style="height: 31vh"
                                    alt="" aria-hidden="true" class="illustration" />
                            </div>
                            <div class="col-12 col-md-8 col-sm-6 justify-content-center align-items-center">
                                {{-- <div class="h4">You are looking for</div> --}}
                                <form method="post" >
                                    @if($user->account_type == 'exporter')
                                        <div class="row">

                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Search products with image" name="quest1a[]" id="quest1b"  class="egfdbh">
                                                <label for="quest1b" >Search products with image</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Make offers in PPT, Excel, PDF" name="quest1a[]" class="egfdbh"
                                                    id="quest1d">
                                                <label for="quest1d" >Make offers in PPT, Excel, PDF</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Record Buyer visits at Expo" class="egfdbh"
                                                    name="quest1a[]" id="quest1a[]">
                                                <label for="quest1a[]" >Record Buyer visits at Expo
                                                </label>
                                            </div>



                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Export Documentation" class="egfdbh"
                                                    name="quest1a[]" id="quest1e">
                                                <label for="quest1e" >Export Documentation</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Manage Product Dev" name="quest1a[]" class="egfdbh"
                                                    id="quest1c">
                                                <label for="quest1c" >Manage Product Dev</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Domestic market expansion" name="quest1a[]" class="egfdbh"
                                                    id="quest1f">
                                                <label for="quest1f" >Domestic market expansion</label>
                                            </div>

                                        </div>



                                        <div class="row mt-4">
                                            <div class="col-12 col-lg-12 d-flex justify-content-between">
                                                <div class="col-4 col-lg-6 col-md-8 col-sm-8 justify-content-center d-flex">
                                                    <button class="close-surverymodal btn btn-outline-primary" id="btn-close-modal" type="button" data-bs-dismiss="modal" style="margin-left: 5px;">Cancel</button>
                                                </div>
                                                <div class="col-4 col-lg-6 col-md-8 col-sm-8 justify-content-center d-flex">
                                                    <button class="btn btn-primary" id="sub_survey" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>

                                    @else($user->account_type == 'supplier' || $user->account_type == 'reseller' )

                                        <div class="row">
                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Searchify your catalogues" class="egfdbh"
                                                    name="quest1a[]" id="quest1a[]">
                                                <label for="quest1a[]" style="text-align: center !important;">Searchify your catalogues
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Search products with image" name="quest1a[]" id="quest1b"  class="egfdbh">
                                                <label for="quest1b" style="text-align: center !important;">Search products with image</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Put client logos on products" name="quest1a[]" class="egfdbh"
                                                    id="quest1c">
                                                <label for="quest1c" style="text-align: center !important;">Put client logos on products</label>
                                            </div>
                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Send offers in ppt, pdf, excel" name="quest1a[]" class="egfdbh"
                                                    id="quest1d">
                                                <label for="quest1d" style="text-align: center !important;" >Send offers in ppt, pdf, excel</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Manage samples bought" class="egfdbh"
                                                    name="quest1a[]" id="quest1e">
                                                <label for="quest1e" style="text-align: center !important;">Manage samples bought</label>
                                            </div>
                                            <div class="col-12 col-md-6 col-sm-12">
                                                <input type="checkbox" value="Get B2B website" name="quest1a[]" class="egfdbh"
                                                    id="quest1f">
                                                <label for="quest1f" style="text-align: center !important;">Get B2B website</label>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12 col-lg-12 d-flex justify-content-between">
                                                <div class="col-4 col-lg-6 col-md-8 col-sm-8 justify-content-center d-flex">
                                                    <button class="close-surverymodal btn btn-outline-primary" id="btn-close-modal" type="button" data-bs-dismiss="modal" style="margin-left: 5px;" >Cancel</button>
                                                </div>
                                                <div class="col-4 col-lg-6 col-md-8 col-sm-8 justify-content-center d-flex">
                                                    <button class="btn btn-primary" id="sub_survey" type="submit button">Submit</button>
                                                </div>
                                            </div>
                                        </div>

                                    @endif

                                </form>

                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
