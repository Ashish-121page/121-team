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
                        <button class="btn btn-outline-primary" type="submit">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
