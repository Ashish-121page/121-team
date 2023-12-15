<!-- Modal -->
<div class="modal fade" id="uploadfiles" tabindex="-1" aria-labelledby="uploadfilesLabel" aria-hidden="true" style="overflow: auto;">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-title d-flex justify-content-between">
                <div class="h5 m-2">Upload assets</div>
                <button type="button" class="btn btn-outline-primary m-2" data-bs-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <div class="modal-body  ">
                <form action="{{ route('panel.filemanager.upload') }}" class="dropzone border-primary d-flex flex-wrap " id="myDropzone">
                    @csrf
                    <div class="fallback">
                        <input name="file" type="file" multiple id="forminputfile">
                    </div>
                </form>

                <div class="row my-3">
                    <div class="col-12 d-flex justify-content-end ">
                        <button class="btn btn-outline-secondary mx-1" type="button" data-bs-dismiss="modal" aria-label="Close" >Cancel</button>
                        <button class="btn btn-outline-primary mx-1" type="button" id="openlinkfile">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>