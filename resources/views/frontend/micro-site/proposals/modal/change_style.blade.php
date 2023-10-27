<div id="animatedModal1">
    <div id="btn-close-modal1" class="close-animatedModal1 custom-spacing" style="color:black">
        <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
    </div>
    <div class="modal-content custom-spacing" style="background-color:#f3f3f3">
        <div class="row">
            <div class="col-md-6 col-12 my-2">
                {{-- <div class="accordion" id="accordionInternalCollection"> --}}
                    {{-- <div class="col-3 d-flex align-items-center justify-content-center"> --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseInternalCollection" aria-expanded="false"
                                aria-controls="collapseInternalCollection">
                                change the styles
                            </button>
                        </h2>
                        <div id="collapseInternalCollection" class="accordion-collapse collapse show"
                            data-bs-parent="">
                            <div class="accordion-body">
                                
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <th>Allow Resellers</th>
                                                        <td>{{ $productExtraInfo->allow_resellers ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Live / Active</th>
                                                        <td>{{ ($product->is_publish == 1) ? "Yes" : "No"}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Copyright/ Exclusive item</th>
                                                        <td>{{ ($product->exclusive == 1) ? "Yes" : "No" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Exclusive Buyer Name</th>
                                                        <td>{{ $productExtraInfo->exclusive_buyer_name ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Theme / Collection Name</th>
                                                        <td>{{ $productExtraInfo->collection_name ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Season / Month</th>
                                                        <td>{{ $productExtraInfo->season_month ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Theme / Collection Year</th>
                                                        <td>{{ $productExtraInfo->season_year ?? '--' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
            
           
        </div>
    </div>
</div>