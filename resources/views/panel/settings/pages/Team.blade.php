@php
    $record = App\Models\Media::where('type_id',auth()->id())->where('type','OfferBanner')->get();
@endphp

<div class="card-body">

    <div class="row justify-content-center">
        <div class="col-lg-10">                                       
            {{-- brief_induction --}}
            @if(AuthRole() == 'Admin')
                <div class="card-body">
                    <div class="h5 my-3">Brief Intro</div>
                    <form action="{{ route('panel.user_shops.story',$user_shop->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-12 col-12  d-none">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <label for="title" class="control-label">Title</label>
                                    <input class="form-control" name="title" type="text" id="title"
                                    value="{{ $story['title'] ?? '' }}" placeholder="Enter Title">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 my-3">
                                <div class="form-group {{ $errors->has('cta_link') ? 'has-error' : '' }}">
                                    <label for="cta_link" class="control-label">Catalogue</label>
                                    <input type="file" class="form-control" name="cta_file">

                                    @if(isset($story['cta_link']) != null)
                                        @if ($story['cta_link'] != "")
                                            <i title="eKyc Verified" class="fa fa-check-circle fa-sm text-success"></i>
                                            <a href="{{ asset($story['cta_link']) }}" target="_blank" class="btn-link pt-2">Show Catalogue</a>
                                        @endif
                                        <input class="form-control d-none" name="cta_link" type="link" id="cta_link"
                                        value="{{ $story['cta_link'] ?? '' }}" placeholder="Enter Button Link" readonly>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-12 my-3 d-none">
                                <div class="form-group {{ $errors->has('cta_label') ? 'has-error' : '' }}">
                                    <label for="label" class="control-label ">Catalogue Label</label>
                                    <input class="form-control" name="cta_label" type="text" id="cta_label"
                                    value="{{ 'Download Catalogue' }}" placeholder="Enter Button Label">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 my-3">
                                <div class="form-group {{ $errors->has('prl_link') ? 'has-error' : '' }}">
                                    <label for="prl_link" class="control-label">Price List</label>
                                    <input type="file" class="form-control" name="prl_file">

                                    @if(isset($story['prl_link']) != null)
                                        @if ($story['prl_link'] != "")
                                            <i title="eKyc Verified" class="fa fa-check-circle fa-sm text-success"></i>
                                            <a href="{{ asset($story['prl_link']) }}" target="_blank" class="btn-link pt-2">Show Price List</a>
                                        @endif
                                        <input class="form-control d-none" name="prl_link" type="link" id="prl_link"
                                        value="{{ $story['prl_link'] ?? '' }}" placeholder="Enter Button Link" readonly>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-12 my-3 d-none">
                                <div class="form-group {{ $errors->has('prl_label') ? 'has-error' : '' }}">
                                    <label for="label" class="control-label ">Price List Label</label>
                                    <input class="form-control" name="prl_label" type="text" id="prl_label"
                                    value="{{ 'Download Price List'}}" placeholder="Enter Button Label">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group {{ $errors->has('video_link') ? 'has-error' : '' }}">
                                    <label for="label" class="control-label">Video Link</label>
                                    <input class="form-control" name="video_link" type="url" id="video_link"
                                    value="{{ $story['video_link'] ?? '' }}" placeholder="Enter Video Link">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mt-lg-0 md-mt-0 mt-3">
                                <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                    <label for="img" class="control-label">Image</label>
                                    <input class="form-control" name="img" type="file" id="img"
                                    value="">
                                    @if(isset($story['img']) && $story['img'] != null)
                                    <img src="{{ asset($story['img']) }}" class="mt-1" alt="img" style="width: 40%; height: 80px; object-fit: contain;">
                                    <input type="text"  class="d-none" name="old_img" value="{{ asset($story['img']) }}" readonly>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 col-12 mt-3">
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                    <label for="description" class="control-label mb-2">Description</label>
                                    <textarea name="description" class="form-control" id="description1" cols="30" rows="10">{{ $story['description'] ?? '' }}</textarea>
                                </div>
                            </div>



                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ inject_subdomain('about-us', $user_shop->slug)}}#story" target="_blank" class="btn btn-outline-primary">Preview</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Testimonial Form --}}
            <h6 class="my-3 d-none">Testimonials Section</h6>
            <form action="{{ route('panel.user_shops.testimonial') }}" method="post" class="d-none" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="user_shop_id" value="{{ $user_shop->id }}">
                <div class="row mt-3">
                    <div class="col-md-12 col-12">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">

                                <label for="title" class="control-label">Title</label>


                            <input class="form-control" name="title" type="text" id="title"
                                value="{{ $testimonial['title'] ?? '' }}" required placeholder="Enter Title">
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description" class="control-label">Description</label>
                            <textarea class="form-control" name="description" type="text" id="description" placeholder="Enter Description"
                                value="">{{ $testimonial['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mx-auto">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ inject_subdomain('home', $user_shop->slug)}}#testimonial" target="_blank" class="btn btn-outline-primary">Preview</a>
                        </div>
                    </div>
                    <div class="col-md-12"><hr></div>

                    <div class="col-md-12">
                        <div class="d-flex justify-content-between my-3">
                            <h6>Testimonials</h6>
                            <a href="{{ route('panel.user_shop_testimonals.create') }}{{ '?shop_id='.$user_shop->id }}" class="mb-2 btn btn-icon btn-sm btn-outline-primary" title="Add New User Shop Testimonal"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                            @php
                                $items = App\Models\UserShopTestimonal::whereUserShopId($user_shop->id)->paginate(4)
                            @endphp
                        <div class="row mt-3">
                            @if ($items->count() > 0)
                            @foreach($items as $item)
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body text-center" style="padding: 8px 10px;">
                                                <div class="profile-pic mb-20">
                                                    <div class="row">
                                                        <div class="col-4 pr-0">
                                                            @if($item->image != null)
                                                                <img src="{{ ($item->image) ? asset($item->image) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded mt-2">
                                                            @endif
                                                        </div>

                                                        <div class="col-6 pl-5 pt-2 text-left">
                                                            <h6 class="mb-0">{{\Str::limit($item->name, 10) }}
                                                            </h6>

                                                            <span class="mt-2"> {{\Str::limit($item->designation, 10)}}
                                                            </span>
                                                            <p>
                                                                @for ($i = 1; $i < $item->rating; $i++)
                                                                    <i class="fa fa-star text-warning"></i>
                                                                @endfor
                                                            </p>
                                                        </div>
                                                        <div class="col-2 pl-2">
                                                            <button style="background: transparent;margin-left: -12px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                <a href="{{ route('panel.user_shop_testimonals.edit', $item->id) }}{{ '?shop_id='.$user_shop->id }}" title="Edit Testimonial"
                                                                    class="dropdown-item ">
                                                                    <li class="p-0">Edit</li>
                                                                </a>
                                                                <a href="{{ route('panel.user_shop_testimonals.destroy', $item->id) }}" title="Delete Testimonial"
                                                                    class="dropdown-item  delete-item">
                                                                    <li class=" p-0">Delete</li>
                                                                </a>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <div class="mx-auto text-center">
                                <span>No records!</span>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div class="pagination">
                                {{ $items->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Team Form --}}
            {{-- <hr> --}}
            <h6 class="mt-3">Team Section</h6>
            <form action="{{ route('panel.teams.user-shops.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_shop_id" id="" value="{{ $user_shop->id }}">
                    <div class="row mt-3">
                        <div class="col-md-12 col-12">
                            {{-- <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title" class="control-label">Title</label>
                                <input class="form-control" placeholder="Enter Title" name="title" required type="text" id="title" value="{{ $team['title'] ?? '' }}">
                            </div> --}}
                        </div>
                        <div class="col-md-12 col-12">
                            {{-- <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description" class="control-label">Description</label>
                                <textarea class="form-control" placeholder="Enter Descriptoin" name="description" type="text" id="description"
                                    value="">{{ $team['description'] ?? '' }}</textarea>
                            </div> --}}
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ inject_subdomain('about-us', $user_shop->slug)}}#team" class="btn btn-outline-primary" target="_blank">Preview</a>
                            </div>
                        </div>  --}}
                    </div>

                    <div class="row">
                        <div class="col-md-12"><hr></div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between my-3">
                                <h6>Team Members</h6>
                                <a href="{{ route('panel.teams.create') }}{{ '?shop_id='.$user_shop->id }}" class="mb-2 btn btn-icon btn-sm btn-outline-primary" title="Add New Team Member"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                                @php
                                    $items = App\Models\Team::whereUserShopId($user_shop->id)->paginate(4);
                                @endphp
                            <div class="row mt-3">
                                @if ($items->count() > 0)
                                    @foreach($items as $item)
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body text-center" style="padding: 8px 10px;">
                                                    <div class="profile-pic mb-20">
                                                        <div class="row">
                                                            <div class="col-4 pr-0">
                                                                @if($item->image != null)
                                                                    <img src="{{ ($item->image) ? asset($item->image) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded mt-2">
                                                                @endif
                                                            </div>

                                                            <div class="col-6 pl-5 pt-2 text-left">
                                                                <h6 class="mb-0">{{\Str::limit($item->name, 10) }}
                                                                </h6>

                                                                <span class="mt-2"> {{\Str::limit($item->designation, 10)}}
                                                                </span>
                                                                <p>{{$item->contact_number}}</p>
                                                            </div>
                                                            <div class="col-2 pl-2">
                                                                <button style="background: transparent;margin-left: -12px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                    <a href="{{ route('panel.teams.edit', $item->id) }}{{ '?shop_id='.$user_shop->id }}" title="Edit Brand"
                                                                        class="dropdown-item ">
                                                                        <li class="p-0">Edit</li>
                                                                    </a>
                                                                    <a href="{{ route('panel.teams.destroy', $item->id) }}" title="Delete Brand"
                                                                        class="dropdown-item  delete-item">
                                                                        <li class=" p-0">Delete</li>
                                                                    </a>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                <div class="mx-auto text-center">
                                    <span>No records!</span>
                                </div>
                                @endif
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <div class="pagination">
                                    {{ $items->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
            </form>



        </div>
         {{-- <div class="col-lg-4">
            <div class="sticky">
                <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="screenshot-img" class="screen-shot-image">
            </div>
        </div> --}}
    </div>
    
    {{-- <form action="{{ route('panel.teams.user-shops.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_shop_id" id="" value="{{ $user_shop->id }}">
            <div class="row">
                <div class="col-md-12 col-12 d-none">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title" class="control-label form-label">Title</label>
                        <input class="form-control" placeholder="Enter Title" name="title" required type="text" id="title" value="Team">
                    </div>
                </div>
                <div class="col-md-12 col-12 mt-3 d-none">
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description" class="control-label form-label">Description</label>
                        <textarea class="form-control" placeholder="Enter Descriptoin" name="description" type="text" id="description"
                            value="">{{ $team['description'] ?? '' }}</textarea>
                    </div>
                </div>

                <div class="col-md-12 d-none">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mt-3">Update</button>

                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12"><hr></div>
                <div class="col-md-12">
                    <div class="d-flex justify-content-between my-3">
                        <h6>Team Members settings</h6>
                        <a href="{{ route('panel.teams.create') }}{{ '?shop_id='.$user_shop->id }}" id="addmember" class="mb-2 btn btn-icon btn-sm btn-outline-primary" title="Add New Team Member"><i class="fa fa-plus" aria-hidden="true" style="line-height: 2 !important;"></i></a>
                    </div>
                        @php
                            $items = App\Models\Team::whereUserShopId($user_shop->id)->paginate(4);
                        @endphp
                    <div class="row mt-3">
                        @if ($items->count() > 0)
                            @foreach($items as $item)
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body text-center" style="padding: 8px 10px;">
                                            <div class="profile-pic mb-20">
                                                <div class="row">
                                                    <div class="col-4 pr-0">
                                                        @if($item->image != null)
                                                            <img src="{{ ($item->image) ? asset($item->image) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded mt-2">
                                                        @endif
                                                    </div>

                                                    <div class="col-6 pl-5 pt-2 text-left">
                                                        <h6 class="mb-0">{{\Str::limit($item->name, 10) }}
                                                        </h6>

                                                        <span class="mt-2"> {{\Str::limit($item->designation, 10)}}
                                                        </span>
                                                        <p>{{$item->contact_number}}</p>
                                                    </div>
                                                    <div class="col-2 pl-2">
                                                        <a href="{{ route('panel.teams.destroy', $item->id) }}" class="text-danger delete-item">
                                                            <i class="ui uil-trash-alt"></i>
                                                        </a>
                                                        <a href="{{ route('panel.teams.edit' , $item->id) }}?shop_id={{$user_shop->id}}" class="text-primary editteam">
                                                            <i class="ui uil-pen"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <div class="mx-auto text-center">
                            <span>No records!</span>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div class="pagination">
                            {{ $items->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
    </form> --}}
        
</div>