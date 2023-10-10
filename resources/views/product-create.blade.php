{{-- products --}}
<div class="col-lg-8">
    <form action="{{ route('panel.user_shops.products',$user_shop->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_shop_id" value="{{ $user_shop->id }}">
        <div class="row mt-3">
            <div class="col-md-12 col-12">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    
                    <label for="title" class="control-label">Title</label>
                    <input class="form-control" name="title" type="text" id="title"
                        value="{{ $products['title'] ?? '' }}" required placeholder="Enter Title">
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label for="description" class="control-label">Description</label>
                    <textarea class="form-control" name="description" type="text" id="description" placeholder="Enter Description"
                        value="">{{ $products['description'] ?? '' }}</textarea>
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label for="description" class="control-label">Label</label>
                    <input type="text" name="label" id="" placeholder="Enter Label" value="{{ $products['label'] ?? '' }}" class="form-control">
                </div>
            </div>
            <div class="col-md-12 mx-auto">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ inject_subdomain('home', $user_shop->slug)}}#products" target="_blank" class="btn btn-outline-primary">Preview</a>
                </div>
            </div> 
        </div> 
    </form>
    
</div>