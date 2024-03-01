<div class="card-body1 mt-5" style="padding:30px  0px ! important;" id="hztab">

    <div class="col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
        <input type="text" name="searchvault" id="searchvault" class="form-control shadow-none "
            placeholder="Quick Search By Name">
    </div>

    <div class=" col-md-12 col-lg-12 col-sm-12 d-flex justify-content-space-between align-items-center flex-wrap"
        style="padding: 0px ;" id="dhfusdjn">

        <div class="cardbx col-sm-6 col-lg-3 col-md-4 ywqgqdya  product-card product-box dhuifhsdi d-flex justify-content-center align-content-center border bg-white"
            style="width: 100%;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
            <a id="addvaultmodal" href="#add_vault_modal" role="button" class="addcat"
                style="width: 100% !important;text-align: center !important;display: flex !important;justify-content: center !important;align-items: center !important;transform: scale(105%);font-size: 1.2rem">
                + Add Vault
            </a>
        </div>


        {{-- Starting View of Vault Can be started Byt A loop from Here.... --}}
        @include('panel.user_shop_items.includes.vault-load')
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

        // Simple Ajax without Server Use :)
        $(document).on('input', '#searchvault', function() {
            let value = $(this).val().toLowerCase();
            $.ajax({
                type: "get",
                url: "{{ route('panel.asset-link.search.asset.card') }}",
                data: {
                    q: value
                },
                success: function (response) {
                    $(".cardbx:not(.dhuifhsdi)").remove();
                    $("#dhfusdjn").append(response);
                    // console.log(response);
                }
            });



            $(".cardbx:not(.dhuifhsdi)").filter(function() {
                if ($(this).find('.one').find(':first').text().toLowerCase().indexOf(value) > -1) {
                    $(this).removeClass('d-none');
                    $(this).addClass('d-flex');
                }else{
                    $(this).addClass('d-none');
                    $(this).removeClass('d-flex');
                }
            });
        });


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
            let index_number=$(this).data('index_number');
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
