<div class="modal fade" id="bulkdeliveryupdate" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="addProductTitle">Bulk Product T&A Update</h5>

        <div class="ml-auto">
            <a href="{{ route('panel.product.deliveryExport') }}" class="btn btn-link"><i class="fa fa-download"></i> Export </a>
        </div>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        
        </div>
        <div class="modal-body">
            <form action="{{ route('panel.delivery.group.bulk-update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                   
                    <div class="form-group">
                        <label for="">Upload Updated Excel Template</label>
                        <input type="file" name="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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