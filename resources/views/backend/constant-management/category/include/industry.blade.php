<div class="modal fade" id="categoryBulkModal" role="dialog" aria-labelledby="categoryBulkModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryBulkModalTitle">Upload Industries Category</h5>
        <div class="">
            <a href="{{ asset('utility/bulk-category.xlsx') }}" type="button"  class="btn btn-outline-danger ml-4">Download Template</a>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      </div>
      <div class="modal-body">
          <form action="{{ route('panel.category-upload') }}" method="post" enctype="multipart/form-data">
            @csrf
              <div class="row">
                <div class="col-md-12 col-12"> 
                    <div class="form-group">
                        <label for="file">Upload Excel<span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>