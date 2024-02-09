<div class="card-body1 mt-5" style="padding:30px  0px ! important;" id="hztab">

    <div class="col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
        <input type="text" name="searchvault" id="searchvault" class="form-control shadow-none "
            placeholder="Quick Search By Name, KW">
    </div>

    <div class=" col-md-12 col-lg-12 col-sm-12 d-flex justify-content-space-between align-items-center flex-wrap"
        style="padding: 0px ;">

        <div class="cardbx col-sm-6 col-lg-3 col-md-4 ywqgqdya  product-card product-box d-flex justify-content-center align-content-center border bg-white"
            style="width: 100%;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
            <a id="addvault" href="#vault_modal" role="button" class="addcat"
                style="width: 100% !important;text-align: center !important;display: flex !important;justify-content: center !important;align-items: center !important;transform: scale(105%);font-size: 1.2rem">
                + Add Vault
            </a>
        </div>
        <div class="cardbx col-sm-6 col-lg-3 col-md-4 ywqgqdya product-card product-box d-none flex-column border bg-white "
            style="width: 25rem;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;" id="dshgvbs">
            <div class="head d-flex justify-content-between my-2" style="font-size: 1rem !important;">
                <div class="one col-10">
                    <div style="font-weight: bold; font-size: large !important;">Dec 2023</div>
                    <small class="text-muted" style="font-size: medium;">1 Products</small>
                </div>
                <div class="two col-2 d-flex flex-column justify-content-start align-items-start">
                    <a href="#" class="btn text-primary btn-sm">
                        <i class="fas fa-caret-right"></i>
                    </a>
                </div>
            </div>

            <div class="cardbody d-flex justify-content-around  w-100" style="padding: 1rem 0;">

                <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                    <img src="{{ asset('frontend/assets/newuiimages/vault/5.png') }}" class="img-fluid p-1"
                        style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                </div>
                <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                    <img src="{{ asset('frontend/assets/newuiimages/vault/1.png') }}" class="img-fluid p-1"
                        style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                </div>
                <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                    <img src="{{ asset('frontend/assets/newuiimages/vault/4.png') }}" class="img-fluid p-1"
                        style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                </div>
            </div>

            <label class="custom-chk prdct-checked" data-select-all="boards"
                style="bottom: 5; right: 20px; display: block;">
                <input type="checkbox" name="editcat" class="input-check d-none" id="editcat" value="870">
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="cardbx col-sm-6 col-lg-3 col-md-4 ywqgqdya product-card product-box d-flex flex-column border bg-white"
            style="width: 25rem;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
            <div class="head d-flex justify-content-between my-2" style="font-size: 1rem !important;">
                <div class="one col-10">
                    <div style="font-weight: bold; font-size: large !important;">Nov 2023</div>
                    <small class="text-muted" style="font-size: medium;">1 Products</small>
                </div>
                <div class="two col-2 d-flex flex-column justify-content-start align-items-start">
                    <a href="#" class="btn text-primary btn-sm">
                        <i class="fas fa-caret-right"></i>
                    </a>
                </div>
            </div>

            <div class="cardbody d-flex justify-content-around  w-100" style="padding: 1rem 0;">

                <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                    <img src="{{ asset('frontend/assets/newuiimages/vault/19.png') }}" class="img-fluid p-1"
                        style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                </div>
                <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                    <img src="{{ asset('frontend/assets/newuiimages/vault/20.png') }}" class="img-fluid p-1"
                        style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                </div>
                <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                    <img src="{{ asset('frontend/assets/newuiimages/vault/18.png') }}" class="img-fluid p-1"
                        style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                </div>
            </div>

            <label class="custom-chk prdct-checked" data-select-all="boards"
                style="bottom: 5; right: 20px; display: block;">
                <input type="checkbox" name="editcat" class="input-check d-none" id="editcat" value="870">
                <span class="checkmark"></span>
            </label>
        </div>



    </div>
</div>
@include('panel.user_shop_items.modal.add-vault')

@push('script')
    <script>
        $(document).on('click', '#showcard', function() {
            $("#dshgvbs").removeClass('d-none');
            $("#dshgvbs").addClass('d-flex');


        })

        $(document).ready(function() {
            // $('#addvault').click();
            // $('.saveandnext').click();
            // $('.toslide3').click();
            $('.TAGGROUP').tagsinput('items');
        });


        $(document).on('click', '.chekpro', function() {
            let id = $(this).attr('id');
            let input = $(`input#${id}`);
            if (input.is(':checked')) {
                input.prop('checked', false);
            } else {
                input.prop('checked', true);
            }


            $(this).toggleClass('active');
            $(this).toggleClass('btn-outline-primary');
            $(this).toggleClass('btn-outline-success');



        });


        $(document).on('click', '.saveandnext', function() {
            // $("#pills-profile-tab").click();
            $("#pills-contact-tab").click();

        });
        $(document).on('click', '.draftandnext', function() {
            // Add Some Action for Draft
        });
        $(document).on('click', '.toslide3', function() {
            $("#pills-contact-tab").click();
        });


        $(document).on('input', '.sameinput', function() {
            let id = $(this).attr('id');
            let value = $(this).val();
            $(`#${id}1`).html(value);
        });


        $(document).on('click', '.opentable', function() {
            let toggletable = $(this).data('toggletable');
            $(".prevtable").addClass('d-none');
            $(`#${toggletable}`).removeClass('d-none');
        });

        $(document).on('change', '.TAGGROUP', function() {
            let value = $(this).val().split(',')
            $(`#appendtags`).empty();


            value.forEach(element => {
                let tag =
                    `<div class="btn btn-pills btn-primary m-1 " style="width: min-content;border-radius: 20px;">${element}</div>`;
                $(`#appendtags`).append(tag);
            });




        });
    </script>
@endpush
