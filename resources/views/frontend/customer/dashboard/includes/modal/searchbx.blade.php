<style>
    #searchbx form {
        height: 100%;
        margin: 0;
    }

    #searchbx .modal-content{
        background: #6666cc !important;
        font: 13px monospace;
        color: #FFFFFF;
    }

    p {
        margin-top: 30px;
    }

    .cntr {
        display: table;
        width: 100%;
        height: 100%;
    }

    .cntr .cntr-innr {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }

    .search {
        display: inline-block;
        position: relative;
        height: 35px;
        width: 35px;
        box-sizing: border-box;
        margin: 0px 8px 7px 0px;
        padding: 7px 9px 0px 9px;
        border: 3px solid #FFFFFF;
        border-radius: 25px;
        transition: all 200ms ease;
        cursor: text;
    }

    .search:after {
        content: "";
        position: absolute;
        width: 3px;
        height: 20px;
        right: -5px;
        top: 21px;
        background: #FFFFFF;
        border-radius: 3px;
        transform: rotate(-45deg);
        transition: all 200ms ease;
    }

    .search.active,
    .search:hover {
        width: 200px;
        margin-right: 0px;
    }

    .search.active:after,
    .search:hover:after {
        height: 0px;
    }

    .search input {
        width: 100%;
        border: none;
        box-sizing: border-box;
        font-family: Helvetica;
        font-size: 15px;
        color: inherit;
        background: transparent;
        outline-width: 0px;
    }

    #inpt_search::focus {
        width: 100%;
    }

    #searchbx .modal-content .cntr-innr #inpt_search:focus{
        width: 100%;
    }
    #searchbx .modal-content .cntr-innr #inpt_search::placeholder{
        color: white;
        padding-left: 7px;
        font-size:  10px;

    }

</style>




<div class="modal fade" id="searchbx" role="dialog" aria-labelledby="searchbxTitle" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <form method="GET" action="{{ route('home.search') }}" enctype="multipart/form-data">
                <div class="modal-header d-flex justify-content-end" style="border: none">  
                    {{-- <h5 class="modal-title" id="searchbxTitle">Search</h5> --}}
                    <button type="button" class="btn close text-light fs-4" data-bs-dismiss="modal" aria-label="Close"
                        style="padding: 0px 20px;font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body h-75">
                    <div class="cntr" id="cntr">
                        <div class="cntr-innr">
                            <label class="search" for="inpt_search">
                                <input id="inpt_search" type="text" placeholder="Search Name, Phone, Company" name="searchquery"/>
                            </label>
                            <p>Type to search...</p>
                            <br>
                            <button class="btn btn-outline-success text-light">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
