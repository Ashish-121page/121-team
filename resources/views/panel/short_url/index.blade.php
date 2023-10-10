@extends('backend.layouts.main') 
@section('title', 'Manage Short URLs')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-unlock bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Short Urls')}}</h5>
                            <span>{{ __('Create,Manange and Share Short Urls ')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="../index.html"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Manage Short Urls')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <!-- only those have manage_permission permission will get access -->
            @can('manage_permission')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Add Url')}}</h3></div>
                    <div class="card-body">
                        {{-- <form class="forms-sample" method="POST" action="{{url('panel/permission/create')}}">
                            @csrf --}}
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="urlvalue">{{ __('Link To Short')}}<span class="text-red">*</span></label>
                                        <input type="text" class="form-control" id="urlvalue" name="urlvalue" placeholder="Enter Url That You Want Shrink" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="unikey">{{ __('Url Key')}}</label>
                                        <input type="text" class="form-control" id="unikey" name="unikey" placeholder="Any Unique Url Key">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button id="shrinkUrlbtn" type="button" class="btn btn-primary">Get Url</button>
                                    </div>
                                </div>
                                
                            </div>
                        {{-- </form> --}}
                        <h6 class="my-2">Your Shrinked Url Is 
                            <span id="short">https://121.page/short/{Unique-key}</span> 
                            <a class="text-info btn-icon fz-12" title="Click To Copy URL" style="cursor: pointer" onclick="copyTextToClipboard()"><i class="fa fa-copy"></i></a>
                        </h6>

                    </div>
                </div>
            </div>
            @endcan
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">

                    <form action="{{ route("panel.short_url.searchurl") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <input type="text" class="form-control " placeholder="Search Url Key" name="searchkey" value="{{ $request->searchkey ?? '' }}">
                            <button class="btn btn-primary mx-2" type="submit">search</button>
                        </div>
                    </form>
                    
                    <div class="card-body">
                        <table id="url_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('#')}}</th>
                                    <th>{{ __('Action')}}</th>
                                    <th>{{ __('Desination URL')}}</th>
                                    <th>{{ __('Short Url')}}</th>
                                    <th>{{ __('Views')}}</th>
                                    {{-- <th>{{ __('Action')}}</th> --}}
                                    <th>{{ __('Created At')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($short_url as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-item p-0"><a href="{{ route('panel.short_url.edit_url', $item->id) }}" title="Edit NewsLetter" class="btn btn-sm">Edit</a></li>
                                                    <li class="dropdown-item p-0"><a href="{{ route('panel.short_url.delete_url', $item->id) }}" title="Delete NewsLetter" class="btn btn-sm delete-item">Delete</a></li>
                                                  </ul>
                                            </div> 
                                        </td>
                                        <td style="max-width: 80px">{{ $item->destination_url }}</td>
                                        <td>{{ $item->default_short_url }}</td>
                                        <td>
                                            @php
                                                $view = App\Models\shorturlvisitor::where('url_key',$item->url_key)->get();
                                            @endphp
                                            {{ count($view) }}
                                        </td>
                                        {{-- <td>
                                            <a href="{{ route("panel.short_url.delete_url").'?id='.$item->id }}" class="btn btn-danger">Delete</a>
                                        </td> --}}
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                
                <div class="card-footer d-flex justify-content-between">
                    <div class="pagination">
                        {{ $short_url->appends(request()->except('page'))->links() }}
                    </div>
                    <div>
                        @if($short_url->lastPage() > 1)
                            <label for="">Jump To: 
                                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                                    @for ($i = 1; $i <= $short_url->lastPage(); $i++)
                                        <option value="{{ $i }}" {{ $short_url->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </label>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script>

        $("#shrinkUrlbtn").click(function (e) { 
            e.preventDefault();
            var url = $("#urlvalue").val();
            var unikey = $("#unikey").val();
            $.ajax({
                type: "post",
                url: "{{ route('panel.short_url.create_url') }}",
                data: {
                    'url': url,
                    'key': unikey,
                },
                success: function (response) {
                    console.log(response);
                    $("#short").html(response);
                }
            });
        });
        function copyTextToClipboard(text) {
            var text = $("#short").html();
                if (!navigator.clipboard) {
                    fallbackCopyTextToClipboard(text);
                    return;
                }
                navigator.clipboard.writeText(text).then(function() {
                }, function(err) {
                });
                $.toast({
                    heading: 'SUCCESS',
                    text: "Short Url copied successfully!",
                    showHideTransition: 'slide',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-right'
                });
            }
        
    </script>




    @endpush
@endsection
