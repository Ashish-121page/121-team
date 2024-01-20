<!-- Modal -->
<div class="modal fade" id="linkAssetsModal" tabindex="-1" aria-labelledby="linkAssetsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkAssetsModalLabel">Link Assets</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <input type="text" name="searchbyname" id="searchbyname" placeholder="Search by File Name" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex flex-column justify-content-center">
                            <div class="row" id="updateseachassets">
                                @include('panel.products.include.iframe.link-assets')
                            </div>

                            <div class="row">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-outline-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>


<script>
    var addedassets = [];
    var addedassetsFilename = [];

    $('a.page-link').attr("href","#");


    $(document).ready(function () {
        $('a.page-link').attr("href","#");
    });

    function remveassets(element) {
        let assetId = element.value;
        let tmp_arry = [];
        let tmp_arryname = [];

        $.map(addedassets, function (elementOrValue, indexOrKey) {
            // console.log(elementOrValue);
            if (elementOrValue != assetId) {
                tmp_arry.push(elementOrValue);
                tmp_arryname.push(addedassetsFilename[indexOrKey]);
            }
        });

        addedassets = tmp_arry;
        localStorage.setItem("mediaId", addedassets)

        addedassetsFilename = tmp_arryname;
        localStorage.setItem("mediaFilename", addedassetsFilename)

        appendAssets(addedassets, addedassetsFilename);
    }

    function appendAssets(value, name) {
        let creatingInputtag = '<input type="hidden" name="avl_assets[]" value="' + value + '">';
        $("#previewassetsitem").html("");

        $.map(value, function(elementOrValue, indexOrKey) {
            let tag = `<tr>
                <td class="col-1"> ${indexOrKey+1} </td>
                <td class="col-4">${name[indexOrKey]}</td>
                <td class="col-3">
                    <button value="${elementOrValue}" type="button" class="btn btn-outline-danger btn-sm" onclick="remveassets(this)">Remove</a>
                </td>
            </tr>`;
            $("#previewassetsitem").append(tag);
        });

        $(".myassetsbox").html("");
        $(".myassetsbox").append(creatingInputtag);
    }


    $(document).ready(function() {
        $(".addingitem").click(function(e) {
            e.preventDefault();
            $(this).addClass("active");
            $(this).addClass("disabled");



            let mediaid = $(this).data("mediaid");
            let file_name = $(this).data("file_name");

            if (addedassets != null) {
                addedassets.push(mediaid);
                addedassetsFilename.push(file_name);
            }

            let addedassets1 = [...new Set(addedassets)];
            let addedassetsFilename1 = [...new Set(addedassetsFilename)];

            localStorage.setItem("mediaId", addedassets1)
            localStorage.setItem("mediaFilename", addedassetsFilename1)

            appendAssets(addedassets1, addedassetsFilename1);

        });
    });
</script>
