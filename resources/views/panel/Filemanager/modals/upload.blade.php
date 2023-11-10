<!-- Modal -->
<div class="modal fade" id="uploadfiles" tabindex="-1" aria-labelledby="uploadfilesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-title d-flex justify-content-between">
                <div class="h5 m-2">Choose Files</div>
                <button type="button" class="btn btn-outline-primary m-2" data-bs-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <div class="modal-body">                
                <form action="{{ route('panel.filemanager.upload') }}" class="dropzone border-primary " id="myDropzone">
                    @csrf
                    <div class="fallback">
                        <input name="file" type="file" multiple id="forminputfile">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>