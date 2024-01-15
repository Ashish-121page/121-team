@php
    $record = App\Models\Media::where('type_id',auth()->id())->where('type','OfferBanner')->get();
@endphp

<div class="card-body">
    
            <form action="{{ route('panel.teams.user-shops.update') }}" method="post" enctype="multipart/form-data">
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
                                <h6>Team Members</h6>
                                <a href="#" id="addmember" class="mb-2 btn btn-icon btn-sm btn-outline-primary" title="Add New Team Member"><i class="fa fa-plus" aria-hidden="true" style="line-height: 2 !important;"></i></a>
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
            </form>
        
</div>