<div class="card-body1 mt-5" style="padding:30px  0px ! important;" id="hztab">

    <div class="col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
        <input type="text" name="searchvault" id="searchvault" class="form-control shadow-none "
            placeholder="Quick Search By Name, KW">
    </div>

    <div class=" col-md-12 col-lg-12 col-sm-12 d-flex justify-content-space-between align-items-center flex-wrap"
        style="padding: 0px ;">

        <div class="cardbx col-sm-6 col-lg-3 col-md-4 ywqgqdya  product-card product-box d-flex justify-content-center align-content-center border bg-white"
            style="width: 100%;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
            <a id="addvaultmodal" href="#add_vault_modal" role="button" class="addcat"
                style="width: 100% !important;text-align: center !important;display: flex !important;justify-content: center !important;align-items: center !important;transform: scale(105%);font-size: 1.2rem">
                + Add Vault
            </a>
        </div>


        {{-- Starting View of Vault Can be started Byt A loop from Here.... --}}


        @forelse ($vault_data as $item)
            <div class="cardbx col-sm-6 col-lg-3 col-md-4 ywqgqdya product-card product-box d-flex flex-column border bg-white"
                style="width: 25rem;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
                <div class="head d-flex justify-content-between my-2" style="font-size: 1rem !important;">
                    <div class="one col-10">
                        <div style="font-weight: bold; font-size: large !important;"> {{ $item }} </div>
                        @php
                            $count = App\Models\Media::where('vault_name', $item)->count();
                            $first_three = App\Models\Media::where('vault_name', $item)->take(3)->get();
                        @endphp
                        <small class="text-muted" style="font-size: medium;">{{ $count }} Assets</small>
                    </div>
                    <div class="two col-2 d-flex flex-column justify-content-start align-items-start">
                        <a href="#" class="btn shadow-none  text-primary btn-sm editshowvault"
                            data-vault_rec="{{ $item }}">
                            <i class="fas fa-caret-right"></i>
                        </a>
                    </div>
                </div>

                <div class="cardbody d-flex justify-content-around  w-100" style="padding: 1rem 0;">
                    @forelse ($first_three as $item)
                        <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                            <img src="{{ asset($item->path ?? 'frontend/assets/newuiimages/vault/19.png') }}"
                                class="img-fluid p-1"
                                style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                        </div>
                    @empty
                        <div class="col-12 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                            Nothing Found
                        </div>
                    @endforelse
                    {{-- <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                        <img src="{{ asset('frontend/assets/newuiimages/vault/20.png') }}" class="img-fluid p-1"
                            style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                    </div>
                    <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                        <img src="{{ asset('frontend/assets/newuiimages/vault/18.png') }}" class="img-fluid p-1"
                            style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
                    </div> --}}
                </div>

                {{-- <label class="custom-chk prdct-checked" data-select-all="boards"
                    style="bottom: 5; right: 20px; display: block;">
                    <input type="checkbox" name="editcat" class="input-check d-none" id="editcat" value="870">
                    <span class="checkmark"></span>
                </label> --}}
            </div>
        @empty

        @endforelse

        {{-- Starting View of Vault Can be started Byt A loop from Here.... --}}

    </div>
</div>

@include('panel.user_shop_items.modal.add_vault_items')


<a href="#edit_vault_modal" id="openEditVaultModal" class="d-none"></a>


{{-- -- Modal For Editing and View of Vault -- --}}
@include('panel.user_shop_items.modal.add-vault')


</div>

@push('script')
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>

    <script>
        //  Modal for Add Vault
        $("#addvaultmodal").animatedModal({
            color: 'FFFFFF',
        });

        //  Modal for Edit  Vault
        $("#openEditVaultModal").animatedModal({
            color: 'FFFFFF',
        });
        $(document).ready(function() {
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
            $("#pills-profile-tab").click();
            // $("#pills-contact-tab").click();

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



        {{-- ! Working for Vault --}}
        $(document).on("click", ".editshowvault", function(e) {
            let vault_rec = $(this).data('vault_rec');
            // console.log(vault_rec);
            // Updating Size
            $.ajax({
                type: "GET",
                url: "{{ route('panel.asset-link.vault.rec') }}",
                data: {
                    vault_rec: vault_rec
                },
                dataType: "html",
                success: function(response) {
                    $("#eidhfiusdh").empty();
                    $("#eidhfiusdh").html(response);
                }
            });

            $('#openEditVaultModal').click();
        })
    </script>
@endpush
