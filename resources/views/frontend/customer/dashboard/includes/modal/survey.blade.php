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
        text-align: center;
        display: flex;
        align-content: center !important;
        justify-content: center;
        border: 1px solid black;
        border-radius: 5px;
        padding: 10px;
        max-height: 68px;
        min-width: 42px;
        height: 100%;
        cursor: pointer;
    }
    input[type=checkbox]:checked+label {
        border: 2px solid #6666CC !important;

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
                                <img src="/project/121.page-Laravel/121.page/frontend/assets/img/survey.svg" style="height: 31vh"
                                    alt="" aria-hidden="true" class="illustration" />
                            </div>
                            <div class="col-12 col-md-8 col-sm-6 justify-content-center align-items-center">
                                {{-- <div class="h4">You are looking for</div> --}}
                                <form method="post" >
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-sm-12">
                                            <input type="checkbox" value="Enquiries at showroom/ exhibition" class="egfdbh"
                                                name="quest1a[]" id="quest1a[]">
                                            <label for="quest1a[]" >Enquiries at showroom/ exhibition</label>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-12">
                                            <input type="checkbox" value="Manage resellers" name="quest1a[]" id="quest1b"  class="egfdbh">
                                            <label for="quest1b" >Manage resellers</label>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-sm-12">
                                            <input type="checkbox" value="Manage offers on old/dead stocks" name="quest1a[]" class="egfdbh"
                                                id="quest1c">
                                            <label for="quest1c" >Manage offers on old/dead stocks</label>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-12">
                                            <input type="checkbox" value="Fast private proposals" name="quest1a[]" class="egfdbh"
                                                id="quest1d">
                                            <label for="quest1d" >Fast private proposals</label>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-sm-12">
                                            <input type="checkbox" value="Catalogue Archive & retrieval" class="egfdbh"
                                                name="quest1a[]" id="quest1e">
                                            <label for="quest1e" >Catalogue Archive & retrieval</label>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-12">
                                            <input type="checkbox" value="B2B web display" name="quest1a[]" class="egfdbh"
                                                id="quest1f">
                                            <label for="quest1f" >B2B web display</label>
                                        </div>
                                    </div>
    
                                    <div class="row mt-3">
                                        <div class="col-8 col-md-8 col-sm-8 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-primary">Submit</button>
                                        </div>
                                    </div>
                                    
                                </form>
    
                            </div>
                        
                           
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
