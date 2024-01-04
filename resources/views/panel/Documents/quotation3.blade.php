@extends('backend.layouts.main')
@section('title', 'quotation3')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
        <style>
            .prdct-checked {
                position: absolute;
                width: 30px;
                height: 30px;
                right: 10px;
                cursor: pointer;
            }

            .checkmark {
                position: absolute;
                top: 11px;
                left: 7px;
                height: 19px;
                width: 20px;
                border-radius: 3px;
                background-color: #eee;
            }

            .checkmark:after {
                content: "";
                position: absolute;
                display: block;
            }

            .custom-chk .checkmark:after {
                left: 6px;
                top: 2px;
                width: 7px;
                height: 12px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }

            .custom-chk input:checked~.checkmark {
                background-color: #6666cc;
            }
        </style>
    @endpush

    <div class="container" style="max-width:1350px !important;">

        <div class="row">

            <div class="col-12 mt-4">
                <h4>Select Products For Quotation</h4>
            </div>
            <div class="col lg-6 col-md-5 d-flex justify-content-between align-items-center mt-5">

                <div class=" mx-1">
                    <input type="text" placeholder=" Search here  " id="searchValue" name="search"
                        style="width: 350px !important;" value="{{ request()->get('search') }}" class="form-control">
                    <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i
                            class="uil uil-search"></i></button>
                </div>

            </div>
            <div class="col lg-6 col-md-5 mt-5" style=" margin-left:12rem;">
                <div class="two" style="display: flex;align-items: center;justify-content: flex-end; ">
                    <div class="form-group w-100" style="margin-bottom:0rem">
                        <input type="checkbox" id="check_all" class=" m-2">
                        <label for="check_all"
                            style="font-size: 14px; font-family:Nunito Sans, sans-serif;font-weight:700; user-select: none;">Select
                            All</label>
                    </div>

                    <a id="createvariant" href="#animatedModal12" role="button" class="btn btn-outline-primary mx-2"> Add Product </a>

                    <a href="{{ route('panel.Documents.quotation4') }}?typeId={{ request()->get('typeId') }}"
                        class="btn btn-outline-primary">
                        Next
                    </a>

                    {{-- <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle mx-1" type="button" data-bs-toggle=""
                            aria-expanded="false">
                            Add new product
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('panel.products.create') }}?action=nonbranded&single_product">Single Product</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('panel.products.create') }}?action=nonbranded&bulk_product">Bulk - by Excel</a>
                            </li>
                        </ul>
                    </div> --}}

                </div>
            </div>

        </div>



        <div class="container-fluid" id="loadproduct">
            @include('panel.Documents.pages.products')
        </div>


        {{-- <div class="row mt-4">
          <!-- col1 -->
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
              <img src="..." class="card-img-top" alt="..." style="height:105px; background-color: gray;">
              <div class="card-body">
                <p class="filename">Some quick example </p>
              </div>
            </div>
          </div>
          <!-- col2 -->
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
              <img src="..." class="card-img-top" alt="..." style="height:105px; background-color: gray;">
              <div class="card-body">
                <p class="filename filename card-text">Some quick example </p>
              </div>
            </div>
          </div>
          <!-- col3 -->
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
              <img src="..." class="card-img-top" alt="..." style="height:105px; background-color: gray;">
              <div class="card-body">
                <p class="filename card-text">Some quick example </p>
              </div>
            </div>
          </div>
          <!-- col4 -->
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
              <img src="..." class="card-img-top" alt="..." style="height:105px; background-color: gray;">
              <div class="card-body">
                <p class="filename card-text">Some quick example </p>
              </div>
            </div>
          </div>
          <!-- col4 -->
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
              <img src="..." class="card-img-top" alt="..." style="height:105px; background-color: gray;">
              <div class="card-body">
                <p class="filename card-text">Some quick example </p>
              </div>
            </div>
          </div>
          <!-- col4 -->
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
              <img src="..." class="card-img-top" alt="..." style="height:105px; background-color: gray;">
              <div class="card-body">
                <p class="filename card-text">Some quick example </p>
              </div>
            </div>
          </div>
          <!-- col4 -->
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
              <img src="..." class="card-img-top" alt="..." style="height:105px; background-color: gray;">
              <div class="card-body">
                <p class="filename card-text">Some quick example </p>
              </div>
            </div>
          </div>
          <!-- col4 -->
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
              <img src="..." class="card-img-top" alt="..." style="height:105px; background-color: gray;">
              <div class="card-body">
                <p class="filename card-text">Some quick example </p>
              </div>
            </div>
          </div>

        </div> --}}

    </div>

    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    @include('panel.Documents.pages.addProduct')

    <script>
        document.getElementById('check_all').addEventListener('change', function() {
            let checkboxs = $(".custom-chk");
            if (this.checked) {
                // window.location.href = "{{ route('panel.Documents.quotation4') }}";
                $.each(checkboxs, function(indexInArray, valueOfElement) {
                    if ($(this).children('input').prop('checked') != true) {
                        $(this).children('input').trigger('click')
                    }
                    $(this).children('input').prop('checked', true)

                });
            } else {
                $.each(checkboxs, function(indexInArray, valueOfElement) {
                    if ($(this).children('input').prop('checked') != false) {
                        $(this).children('input').trigger('click')
                    }
                    $(this).children('input').prop('checked', false)

                });
            }
        });

        $(document).ready(function() {
            $(".custom-chk").click(function(e) {
                e.preventDefault();
                console.log("Adding a product to the quotation");
                const precord = $(this).children('input').data('record');
                const pvalue = $(this).children('input').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.Documents.create.Quotation.item') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'precord': precord,
                        'pid': pvalue,
                        'quotation_id': localStorage.getItem("record_id-Quotation"),
                        'currency': 'INR'
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 'success') {
                            $.toast({
                                text: response.message,
                                showHideTransition: 'fade',
                                icon: response.status,
                                stack: 6,
                                position: 'bottom-right'
                            })
                        }
                    }
                });
                if ($(this).children('input').attr('checked') == 'checked') {
                    $(this).children('input').attr('checked', false);                  
                }else{
                  $(this).children('input').attr('checked', true);

                }
                
            });


            // Ajax Search
            $("#searchValue").on('input', function() {
              let loadproductbx = $("#loadproduct");
              if ($(this).val() != '') {
                $.ajax({
                  type: "GET",
                  url: "{{ route('panel.Documents.quotation3') }}",
                  data: {
                    searchProduct: $(this).val()
                  },
                  success: function(response) {
                    loadproductbx.html(response);
                    // Recalling Funcion
                    $(".custom-chk").click(function(e) {
                        e.preventDefault();
                        console.log("Adding a product to the quotation");
                        const precord = $(this).children('input').data('record');
                        const pvalue = $(this).children('input').val();

                        $.ajax({
                            type: "POST",
                            url: "{{ route('panel.Documents.create.Quotation.item') }}",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'precord': precord,
                                'pid': pvalue,
                                'quotation_id': localStorage.getItem("record_id-Quotation"),
                                'currency': 'INR'
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 'success') {
                                    $.toast({
                                        text: response.message,
                                        showHideTransition: 'fade',
                                        icon: response.status,
                                        stack: 6,
                                        position: 'bottom-right'
                                    })
                                }
                            }
                        });
                        if ($(this).children('input').attr('checked') == 'checked') {
                            $(this).children('input').attr('checked', false);                  
                        }else{
                          $(this).children('input').attr('checked', true);

                        }
                        
                    });

                    document.getElementById('check_all').addEventListener('change', function() {
                        let checkboxs = $(".custom-chk");
                        if (this.checked) {
                            // window.location.href = "{{ route('panel.Documents.quotation4') }}";
                            $.each(checkboxs, function(indexInArray, valueOfElement) {
                                if ($(this).children('input').prop('checked') != true) {
                                    $(this).children('input').trigger('click')
                                }
                                $(this).children('input').prop('checked', true)

                            });
                        } else {
                            $.each(checkboxs, function(indexInArray, valueOfElement) {
                                if ($(this).children('input').prop('checked') != false) {
                                    $(this).children('input').trigger('click')
                                }
                                $(this).children('input').prop('checked', false)

                            });
                        }
                    });
                    
                  },
                  error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                  }
                });
              } else {
                loadproductbx.empty();
              }
            });

            



            $("#createvariant").animatedModal();


        });
    </script>
@endsection
