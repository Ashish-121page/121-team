<div id="animatedModal" class="modal-fullscreen">
    <div id="btn-close-modal" class="close-animatedModal custom-spacing"
    style="color:black; background-color:#ffff;font-size: x-large;margin: 10px;display: flex;justify-content: space-between;">
        <h5>Select Properties You Wish to Export</h5>
        {{-- <i class="far fa-times-circle fa-rotate-270 fa-lg "></i> --}}

        
    </div>
    <div class="modal-content custom-spacing modal-fullscreen" style="background-color:#ffff">

        <form action="{{ route('panel.bulk.product.custom.bulk-sheet-export',auth()->id()) }}" method="POST">
            <div class="row m-2">
                <div class="col-12" style="display: flex;justify-content: center;gap: 10px;margin: 25px 0;">
                    {{-- 1st Column --}}
                    <div class="col-md-6 col-12 " style="overflow: auto; max-height: 80vh">
                        <div class="">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Template Name" required name="template_name" id="template_name">
                            </div>
                        </div>


                        {{-- <span style="margin-top: -10px;">
                            <i class="ik ik-info fa-2x text-warning ml-2 remove-ik-class" title="These Values will be Updated on All selected Products"></i>
                        </span> --}}
                        {{-- <p>These Values will be Updated on All selected Products</p> --}}



                        {{-- All Attributes Except System --}}
                        
                        

                        <div class="accordion-item" style="margin-top: 2rem">
                            <h2 class="accordion-header">
                                <button class="accordion-button btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseallattribute"
                                    aria-expanded="false" aria-controls="collapseallattribute">
                                    All Properties ( {{count((array) $col_list) - count((array) $default_property)}} )
                                </button>
                            </h2>
                            <div id="collapseallattribute" class="accordion-collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body" >
                                    {{-- <div class="accordion-body" style="max-height:80%; overflow:hidden;overflow-y:auto;"> --}}


                                    <div class="table-responsive" style="max-height:70%; overflow:hidden;overflow-y:auto;">
                                        <div class="form-group w-100" style="margin-bottom:0rem">
                                            <input type="checkbox" id="check_all" class=" m-2">
                                            <label for="check_all"  style="font-size: 14px; font-family:Nunito Sans, sans-serif;font-weight:700;user-select: none;">Select All</label>
                                        </div>
                                        <table class="table">
                                            <tbody>
                                                @forelse ($delfault_cols as $key => $item)
                                                    @if (!in_array($item,$default_property))
                                                        <tr class="">
                                                            <th scope="row" style="padding:0px! important">
                                                                <div class="form-group h-100" style="cursor: pointer; margin-bottom:0rem!important; ">
                                                                    <input type="checkbox" value="{{$item}}"  id="attri_{{$item}}" class="my_attribute d-none mx-1" name="myfields[]" data-index="{{ $key }}">
                                                                    <label for="attri_{{$item}}" class="form-label w-100 h-100" style="font-size: 16px;font-family:Nunito Sans, sans-serif; user-select: none; ">{{$item}}</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr class="">
                                                        <td scope="row">
                                                            <div class="form-group">
                                                                <label for="attri_1" class="form-label w-100 h-100" style="font-size: large;user-select: none;">System Under Upgrade Try Again Later.</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="actionbtn  mt-2 d-flex justify-content-between align-items-center my-2">
                            <button class="btn btn-outline-primary px-5 close-animatedModal">Cancel</button>
                            <button class="btn btn-primary px-5">Save and Download</button>
                        </div>
                    </div>

                    {{-- 2nd column --}}

                    <div>
                        <button class="btn btn-sm mx-1 "> <span id="countselect"></span> Selected</button>
                         
                    </div>

                        <div class="col-md-5 col-12 h-100 invisible" style="overflow: auto; max-height: 80vh" id="tableselected">

                            <div class="d-flex flex-column gap-3 align-items-start justify-content-start">
                                

                            </div>

                            
                            <div class="accordion-item" style="margin-top:4rem">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesystemattri"
                                        aria-expanded="false" aria-controls="collapsesystemattri">
                                        System Properties ( {{count((array) $default_property)}} )
                                    </button>
                                </h2>
                                <div id="collapsesystemattri" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="table-responsive" style="max-height:80%; overflow:hidden;overflow-y:auto;">
                                            <table class="table">
                                                <tbody>
                                                    @forelse ($delfault_cols as $key => $item)
                                                        @if (in_array($item,$default_property))
                                                            <tr class="">
                                                                <td scope="row" style="padding:0px! important">
                                                                    <div class="form-group h-100" style="margin-bottom: 0rem!important;">
                                                                        <label for="attri_{{$item}}" class="form-label " style="font-size: 16px; font-family:Nunito Sans, sans-serif;user-select: none;">{{$item}}</label>
                                                                        <input type="checkbox" value="{{$item}}" id="attri_{{$item}}" class="sys_attribute m-2 invisible" checked name="systemfiels[]">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @empty
                                                        <tr class="">
                                                            <td scope="row">
                                                                <div class="form-group">
                                                                    <label for="attri_1" class="form-label" style="font-size: large;user-select: none;">System Under Upgrade Try Again Later.</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column gap-3 align-items-start justify-content-start">
                                <div class="heading w-100" style="background-color: #f6f8fb; color:#879099;">
                                    <h5> Selected Tags</h5>
                                </div>
                                <div class="selected_tag" style="width:100%">
                                    {{-- Append Element Are shown Here --}}
                                </div>
                            </div>



                        </div>

                </div>
            </div>
        </form>

    </div> {{-- Modal Body End --}}
</div>
