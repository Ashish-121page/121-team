<!-- Modal -->
<div class="modal fade" id="linkAssetsModal" tabindex="-1" aria-labelledby="linkAssetsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkAssetsModalLabel">Link Assets</h5>
            </div>
            <div class="modal-body">

                <form>
                    <div class="table-responsive">
                        <div class="mb-3">
                            <input type="text" name="searchbyname" id="searchbyname" placeholder="Search by Name" class="form-control">
                        </div>
                        <table class="table">

                            <thead>
                                <tr>
                                    <th scope="col"> # </th>
                                    <th scope="col"> Preview </th>
                                    <th scope="col"> Filename </th>
                                    <th scope="col"> </th>
                                </tr>
                            </thead>
                            <tbody id="updateseachassets">

                                @include('panel.products.include.iframe.link-assets')
                            </tbody>
                        </table>
                    </div>
                </form>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
    var addedassets = [];
    var addedassetsFilename = [];

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
                <td> ${indexOrKey+1} </td>
                <td>${name[indexOrKey]}</td>
                <td>
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
