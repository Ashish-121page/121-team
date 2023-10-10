@extends('backend.layouts.main') 
@section('title', 'Group Products')
@section('content')
@php
/**
 * Group Product 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
    if(request()->get('product')){
        $product = fetchFirst('App\Models\Product',request()->get('product'));
        $arr =  ['name'=>@$product->title, 'url'=> route('panel.products.index')."?action=nonbranded", 'class' => 'active'];
    }elseif(@$group){
     $arr =  ['name'=>@$group->name, 'url'=> route('panel.groups.index'), 'class' => 'active'];
    }else{
        $arr = [];
    }

    $breadcrumb_arr = [
        $arr,
        ['name'=>'Group Products', 'url'=> "javascript:void(0);", 'class' => 'active'],
    ];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{@$group->name}} {{ @$product->title }} Products</h5>
                            {{-- <span>List of Group Products</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.group_products.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>{{@$group->name}} {{ @$product->title }} Products</h3>
                            <div class="d-flex justicy-content-right">
                                <div class="form-group mb-0 mr-2">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.group_products.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                @if(request()->get('product'))
                                    <input type="hidden" name="product" value="{{ request()->get('product') }}">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-primary" data-toggle="modal" data-target="#addPriceGroup" title="Add New Group Product"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                @endif
                                {{-- <a href="{{ route('panel.group_products.create') }}{{'?id='.request()->get('id')}}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Group Product"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.group_products.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if(request()->get('product'))
        <div class="modal fade" id="addPriceGroup" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addProductTitle">Add Price</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.group_products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ request()->get('product') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Group</label>
                                <select name="group_id" id="" class="form-control">
                                    <option value="" aria-readonly="true">Select Group</option>
                                    @foreach (App\Models\Group::where('user_id',auth()->id())->get() as $group)
                                    {{-- @foreach (App\Models\Group::whereIn('user_id',[getAdminId()->id,auth()->id()])->get() as $group) --}}
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 ml-auto">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        <div class="modal fade" id="editPriceGroup" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addProductTitle">Update Price</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.group_products.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="Id">
                    <input type="hidden" name="product_id" value="{{ request()->get('product') }}">
                    <div class="row">
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Group</label>
                                <select name="group_id" id="group_id" class="form-control">
                                    <option value="" aria-readonly="true">Select Group</option>
                                    @foreach (App\Models\Group::where('user_id',[auth()->id()])->get() as $group)
                                        <option value="{{ $group->id }}">GRP{{ getPrefixZeros($group->id) }} - {{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <input type="hidden" id="group_id" name="group_id" value="">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" class="form-control" id="price">
                            </div>
                        </div>
                        <div class="col-md-12 ml-auto">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        <div class="modal fade" id="downloadQRModal" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addProductTitle">Download QR</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            {{-- <div class="p-2" id="html-content-holder">
                            </div> --}}
                            <div class="p-2 text-center" id="html-content-holder">
                            </div>
                            <div id="previewImg" class="d-none">
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="javascript:void(0)" id="download-qr" class=" btn btn-outline-primary">Download QR</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    @endif
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/html2canvas.js') }}"></script>
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
           
          
           $('.editrecord').click(function(){
               var rec = $(this).data('rec');
                $('#Id').val(rec.id);
                $('#price').val(rec.price);
                $('#group_id').val(rec.group_id);
               $('#editPriceGroup').modal('show');
            });
            $('.downloadQr').click(function(){
                $('#html-content-holder').html('');
                var group_id = $(this).data('group_id');
                $.ajax({
                    url: "{{route('panel.group_products.api.qr')}}",
                    method: "get",
                    datatype: "html",
                    data: {
                        group_id:group_id
                    },
                    success: function(res){
                        console.log(res);
                        $('#html-content-holder').html(res);
                    }
                })
                $('#downloadQRModal').modal('show');
           });


           var element = $("#html-content-holder"); // global variable
            var getCanvas; // global variable

            $("#download-qr").on('click', function () {
                html2canvas(document.getElementById("html-content-holder")).then(function (canvas) {	
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    document.getElementById("previewImg").appendChild(canvas);
                    anchorTag.download = "mymicrositeshop.jpg";
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.target = '_blank';
                    anchorTag.click();
                });
            });





        function html_table_to_excel(type)
        {
            var table_core = $("#table").clone();
            var clonedTable = $("#table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#table").html(clonedTable.html());
            var data = document.getElementById('table');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'GroupProductFile.' + type);
            $("#table").html(table_core.html());
            
        }

        $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
        })
       

        $('#reset').click(function(){
            var url = $(this).data('url');
            getData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
            //   $('#fieldId').select2('val',"");               // if you use any select2 in filtering uncomment this code
           // $('#fieldId').trigger('change');                  // if you use any select2 in filtering uncomment this code
        });

       
        </script>
    @endpush
@endsection
