
<div class="row">
    <div class="col-md-6 col-12 my-2">
        <div class="d-flex justify-content-start ">
            <button type="button" class="btn mx-1 btn-outline-primary">
                <span id="selected_count">0</span> Selected
            </button>
            <button type="button" class="btn exportbtn mx-1">
                <i class="fas fa-share-alt"></i>
                Export
            </button>
            <button type="button" class="btn text-danger deletebtn mx-1">
                <i class="fas fa-trash"></i>
                Delete
            </button>

            <a href="{{ route('panel.filemanager.new.view') }}?view=grid&page={{ request()->get('page') ?? 1}}" class="btn btn-icon btn-outline-primary mx-1 @if (request()->get('view','default') == 'grid') active @endif">
                <i class="fas fa-th-large" ></i>
            </a>
            <a href="{{ route('panel.filemanager.new.view') }}?view=default&page={{ request()->get('page') ?? 1 }}" class="btn btn-icon btn-outline-primary mx-1 @if (request()->get('view','default') == 'default') active @endif">
                <i class="fas fa-list"></i>
            </a>

            {{-- <button type="button" class="btn">
                <i class="fas fa-link"></i>
                LInk to Products
            </button> --}}
        </div>
    </div>
    <div class="col-md-6 col-12 my-2 d-flex align-content-center justify-content-between  ">
        <span>
            Total Storage Used: <b>{{ number_format($formattedSize/ (1024 * 1024),2) }} MB</b>
        </span>
        <span>
            Total Items: <b> {{$paginator->total()}} </b>
        </span>
    </div>
    
</div>

<div class="row">
    @if (request()->has('view') && request()->get('view') == 'default' )
        @include('panel.Filemanager.view.table')
    @elseif(request()->has('view') && request()->get('view') == 'grid')
        @include('panel.Filemanager.view.grid')
    @else
        @include('panel.Filemanager.view.table')
    @endif



    <div class="col-12">
        {{-- ` Pagination --}}
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                
                @php
                    $currentPage = request()->get('page',1);
                    $previousPage = ($currentPage != 1) ? $currentPage -1 : 1;
                    $lastPage = ($currentPage != $paginator->lastpage()) ? $currentPage + 1 : $paginator->lastpage();
                    $view = request()->get('view','default');
                @endphp
                
            <li class="page-item">
                <a class="page-link" href="{{ request()->url() }}?view={{$view}}&page={{$previousPage}}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            
            @for ($i = 1; $i <= $paginator->lastpage(); $i++)
                <li class="page-item @if ($i == $currentPage) active @endif ">
                    <a class="page-link" href="{{ request()->url() }}?view={{$view}}&page={{$i}}">
                        {{ $i }}
                    </a>
                </li>
            @endfor
            
            <li class="page-item">
                <a class="page-link" href="{{ request()->url() }}?view={{$view}}&page={{$lastPage}}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            </ul>
        </nav>
    </div>

</div>

<button type="button" class="btn btn-outline-primary btn-icon openupload" data-bs-toggle="modal"
    data-bs-target="#uploadfiles" style="position: fixed;bottom: 9%;right: 4%;height: 50px;width: 50px;font-size: 1.5rem;" title="Upload Assets">
    <i class="fas fa-cloud-upload-alt" style="line-height: 1 !important"></i>
</button>