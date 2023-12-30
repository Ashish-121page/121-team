<div id="animatedModal12" style="overflow: hidden">
    <div class="modal-content custom-spacing"
        style="height: 100%;display: flex;align-items: center;justify-content: center;padding: 10px">

        <div class="d-flex justify-content-between w-100 ">
            <div class="h5 m-3">Add New Category</div>
            <div id="btn-close-modal" class="close-animatedModal12 d- justify-content-between w-100  custom-spacing">
                <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
            </div>
        </div>
        <iframe id="myIframe" src="{{ route('panel.products.create') }}?action=nonbranded&single_product"
            style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; border: none;"></iframe>
    </div> {{-- Modal Body End --}}
</div>


<script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#tags').tagsinput('items');
    });

    // Access button inside iframe
    var iframe = document.getElementById('myIframe');
    var iframeWindow = iframe.contentWindow;

    iframeWindow.addEventListener('load', function() {
        var button = iframeWindow.document.getElementById('back_btn');
        var getSingleProduct = iframeWindow.document.getElementsByClassName('getSingleProduct');

        // Open Page Agiain After Close
        $("#createvariant").click(function(e) {
            getSingleProduct[0].click();
            iframeWindow.document.getElementById('in_modal').value = 1;
        });
        if (button) {
            // button.classList.remove('back_btn');
            // button.classList.remove('d-none');

            button.addEventListener('click', function(e) {
                e.preventDefault();
                $(".close-animatedModal12").click()
            });
        }
    });

</script>
