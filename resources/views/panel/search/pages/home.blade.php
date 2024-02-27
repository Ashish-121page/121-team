<form action="{{ route('panel.search.search.result') }}" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12 col-md-6">
            <label for="AssetVaultname"> Vaults to Search </label>
            <select name="AssetVaultname[]" id="AssetVaultname" class="form-control  select2" multiple>
                <option selected>All</option>
                <option>Name 1</option>
                <option>Name 2</option>
                <option>Name 3</option>
                <option>Name 4</option>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <label for="productcatname">Product</label>
            <select name="productcatname[]" id="productcatname" class="form-control  select2" multiple>
                <option selected>All</option>
                <option>Category Name 1</option>
                <option>Category Name 2</option>
                <option>Category Name 3</option>
                <option>Category Name 4</option>
            </select>
        </div>

        <div class="col-12 d-flex justify-content-center flex-column align-items-center ">
            <div class=" mb-2">
                <input type="file" id="searchimg" name="searchimg" class="d-none">
                <label for="searchimg" style="height: 250px">
                    <img src="{{ asset('frontend\assets\website\ASSETVAULT.png') }}" alt="img"
                        style="height: 100%;object-fit: contain;" id="mynewimage">
                </label>
            </div>

            <button class="btn btn-primary d-none align-items-center shadow-none mb-2 MYSEACHBTN" style="transform: scale(120%)">
                <span class="mx-2">Search</span>
            </button>

            <div class="alert alert-warning my-3 mb-2" role="alert">
                <i class="ik ik-info mr-1" title="Upgrade to search PDF and Excel"></i>
                Upgrade to search PDF and Excel
            </div>
        </div>


    </div>
</form>
