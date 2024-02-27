<div class="modal fade" id="barCodeModal" role="dialog" aria-labelledby="AccessCodeTitle" aria-hidden="true" style="z-index: 999999 !important">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AccessCodeTitle">Scan QR</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="report-print">
                    {{-- <div class="d-block mx-auto text-center">
                        <div id="qr-reader" style="mx-auto" style="width:500px"></div>
                        <div id="qr-reader-results"></div>
                    </div> --}}
                    <div class="d-block mx-auto ">
                        <label for="dosomething" class="mb-3">Select Qr Code</label>
                        <br>
                        <input type="file" id="dosomething">
                        <div class="h6" id="infoText"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
