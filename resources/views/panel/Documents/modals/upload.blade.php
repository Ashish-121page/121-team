<!-- Bootstrap Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">File Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Drag and Drop Container -->
                <div id="drop-area">
                    <form class="my-form" action="{{ route('panel.Documents.quotation.uploadFile') }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="typeId" value="{{ $record->id }}">

                        <div class="form-group">
                            <label class="button" for="fileElem">Upload multiple files</label>
                            <br>
                            <input type="file" id="fileElem" name="uploadFiles[]" multiple>
                        </div>

                        <div class="form-group">
                            <label for="entityname">Entity <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="entityname" required>
                        </div>

                        <div class="form-group">
                            <label for="quoteid">Quotation ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="quoteid" required>
                        </div>

                        <div class="form-group">
                            <label for="buyerperson">Buyer Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="buyerperson" required>
                        </div>

                        <div class="form-group">
                            <label for="buyername">Buyer Email </label>
                            <input type="email" class="form-control" id="buyername">
                        </div>

                        <div class="form-group">
                            <label for="buyerphone">Buyer Phone </label>
                            <input type="tel" class="form-control" id="buyerphone">
                        </div>



                        <button class="btn btn-outline-primary" type="submit">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
