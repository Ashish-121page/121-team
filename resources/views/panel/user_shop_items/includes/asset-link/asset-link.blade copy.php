<div class="col-12">
    <div class="row">
        {{-- ` Work With Delimiter Card --}}
        
        <div class="card border-primary mb-3 col-4 border">
            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&delimiter-link">
                <div class="card-header">Work With Delimiter</div>
                <div class="card-body text-dark">
                    <p class="card-text" style="font-size: 0.8rem">
                        Delimiters (characters like hyphens, underscores, or periods) help separate different parts of a
                        filename.
                    </p>
                </div>
            </a>
        </div>
        {{-- Card --}}

        {{--` File Name is Model cod Card --}}
        <div class="card border-primary mb-3 col-4 border">
            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&file_name_is_model_code">
                <div class="card-header">File Name is Model code</div>
                <div class="card-body text-dark">
                    <p class="card-text" style="font-size: 0.8rem">
                        File Is Model Code
                    </p>
                </div>
            </a>
        </div>
        {{-- Card --}}

        {{-- ` File Name is irrelevant Card --}}
        <div class="card border-primary mb-3 col-4 border">
            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&irrelevant-file-name">
                <div class="card-header">File Name is irrelevant</div>
                <div class="card-body text-dark">
                    <p class="card-text" style="font-size: 0.8rem">
                        File Name is irrelevant
                    </p>
                </div>
            </a>
        </div>
        {{-- Card --}}



    </div>


</div>
