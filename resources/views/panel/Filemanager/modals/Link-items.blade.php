<!-- Modal -->
<div class="modal fade" id="linkItems" tabindex="-1" aria-labelledby="linkItemsLabel" aria-hidden="true" style="overflow: auto;">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-title d-flex justify-content-between">
                <div class="h5 m-2">Choose SKU's</div>
                {{-- <button type="button" class="btn btn-outline-primary m-2" data-bs-dismiss="modal" aria-label="Close">
                    X
                </button> --}}
            </div>
            <div class="modal-body  ">
                <form method="POST" action="{{ route('panel.filemanager.link.product',encrypt(auth()->id()) ) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="images" id="imagestolinkjs">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    
                                </div>
                                <div class="col-4">
                                    {{-- <div class="">
                                        <input type="text" name="" id="" class="form-control" placeholder="Search product by sku or label" aria-describedby="helpId">
                                    </div> --}}

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314Z"/>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" id="searchinlinking" placeholder="Search product by sku or label" aria-label="Search" aria-describedby="basic-addon1" autofocus="true">
                                      </div>

                                </div>

                                <div class="col-4 d-flex justify-content-end ">
                                    <div class="mb-2">
                                        <button class="btn btn-outline-primary" id="linkgfyusebh">Link With Delimter</button>
                                        <span id="selected-count" class="btn btn-orange">
                                            <i class="fas fa-check text-orange"></i> 
                                            0 selected
                                        </span>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="col-12">
                            <div class="table-responsive" id="sdhfuyweguygd2qw">

                              @include('panel.Filemanager.modals.ProductList')
                                
                            </div>
                            
                        </div>
                    </div>
  
                    <div class="row">
                        <div class="col-12">
                            {{-- ` Pagination --}}
                            <nav aria-label="Page navigation" style="width: 100%;border: 1px solid;overflow: hidden;overflow-x: auto;">
                                <ul class="pagination">
                                    
                                    @php
                                        $currentPage = request()->get('page',1);
                                        $previousPage = ($currentPage != 1) ? $currentPage -1 : 1;
                                        $lastPage = ($currentPage != $paginator->lastpage()) ? $currentPage + 1 : $paginator->lastpage();
                                        $view = request()->get('view','default');
                                    @endphp
                                    
                                <li class="page-item page-itemajax ">
                                    <button class="page-linkajax btn page-link" data-pagenum="{{$previousPage}}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </button>
                                </li>
                                
                                @for ($i = 1; $i <= $paginator->lastpage(); $i++)
                                    <li class="page-item page-itemajax @if ($i == 1) active @endif">
                                        <button class="page-linkajax btn page-link" data-pagenum="{{$i}}">
                                            {{ $i }}
                                        </button>
                                    </li>
                                @endfor
                                
                                <li class="page-item page-itemajax ">
                                    <button class="page-linkajax btn page-link" data-pagenum="{{$lastPage}}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    </button>
                                </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                            
                                <div class="dropdown">
                                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Results per page
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="{{ request()->url() }}?view={{ request()->get('view','grid') }}&pageliimt32=10">10</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->url() }}?view={{ request()->get('view','grid') }}&pageliimt32=25">25</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->url() }}?view={{ request()->get('view','grid') }}&pageliimt32=50">50</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->url() }}?view={{ request()->get('view','grid') }}&pageliimt32=100">100</a></li>
                                  </ul>
                                </div>
                            </div>  
                        </div>

                        <div class="col-12 d-flex justify-content-end align-content-center">
                            <button class="btn btn-outline-secondary mx-1 my-3" type="button" data-bs-dismiss="modal" aria-label="Close" >Cancel</button>
                            <button type="submit" class="btn d-none btn-outline-primary mx-1 my-3" id="linkprbtn">Submit</button>
                        </div>
                    </div>

                    
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    function updateSelectedCount() {
        const selectedCheckboxes = document.querySelectorAll('.item-checkbox:checked').length;
        document.getElementById('selected-count').textContent = `${selectedCheckboxes} selected`;

        if (selectedCheckboxes > 0) {
            $("#linkprbtn").removeClass('d-none');
        } else {
            $("#linkprbtn").addClass('d-none');
        }

    }

    function toggleCheckboxes(source) {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = source.checked;
        });
        updateSelectedCount();
    }

    function mainwork() {
        // Event listener for the 'Select All' checkbox
        document.getElementById('select-all').addEventListener('click', function () {
            toggleCheckboxes(this);
        });

        // Event listeners for all other checkboxes
        document.querySelectorAll('.item-checkbox').forEach(function (checkbox) {
            checkbox.addEventListener('click', updateSelectedCount);
        });

        // Initialize the selected count on page load
        updateSelectedCount();
    };


    window.onload = mainwork();

    // ` Uncomment For Ajax
    // $(document).ready(function () {
    //     $(document).on('click', '.pagination a', function(event) {
    //         event.preventDefault();
    //         var page = $(this).attr('href').split('page=')[1];
    //         fetch_data(page);
    //     });

    //     function fetch_data(page)
    //     {
    //         $.ajax({
    //             url:"http://localhost/project/121.page-Laravel/121.page/panel/filemanager?view=grid&page="+page,
    //             success:function(data)
    //             {
    //                 $('#table-responsive').html(data);
    //             }
    //         });
    //     }
    // });
</script>
