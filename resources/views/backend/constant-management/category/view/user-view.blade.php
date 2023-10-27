<div class="col-md-12">
  
    {{-- First Pane --}}
    @if (!request()->has('parent_id'))
        <div class="card">
            <div class="card-header align-items-center d-flex justify-content-between">
                <h3>
                    Manage Category
                </h3>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table id="category_table" class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                {{-- @if (AuthRole() == 'Admin') --}}
                                    <th>Industry</th>
                                {{-- @endif --}}

                                <th>Category</th>
                                <th>Sub Category Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if($category->count() > 0)
                                    @foreach($category as $item)

                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            {{-- @if (AuthRole() == 'Admin') --}}
                                                <td>
                                                    {{ App\Models\Category::whereId($item->parent_id)->first()->name ?? 'Unknown ' }}
                                                </td>
                                            {{-- @endif --}}
                                            
                                            <td>
                                                {{ $item->name }} {{ $item->type == 1 ? "" : "(Self)" }}
                                            </td>

                                            <td>
                                                {{ count(App\Models\Category::where('parent_id',$item->id)->get()) ?? '0' }}
                                            </td>


                                            <td>
                                                <div class="dropdown open">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="actioncat" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                                Action
                                                            </button>
                                                    <div class="dropdown-menu" aria-labelledby="actioncat">

                                                        @if($item->user_id == auth()->id() || AuthRole() == "Admin")
                                                            <a href="{{ route('panel.constant_management.category.edit', $item->id)  }}" title="Edit Lead Contact" class="btn btn-sm dropdown-item">Edit</a>
                                                        @endif 
                                                        @if(AuthRole() == "Admin")
                                                            <a href="{{ route('panel.constant_management.category.delete', $item->id)  }}" title="Delete Category" class="btn btn-sm delete-item dropdown-item">Delete</a>
                                                        @endif
                                                        <a href="?parent_id={{$item->id }}" title="View Sub Categoryes" class="btn btn-sm dropdown-item">Show</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                    @endforeach
                            @else
                                <div class="text-center">
                                    There is no Custom Category
                                </div>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    
    
    {{-- second Pane --}}
    @if (request()->has('parent_id'))
        <div class="card">
            <div class="card-header align-items-center d-flex justify-content-between">
                <h3>
                    Manage Category
                </h3>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table id="category_table" class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                @if (AuthRole() == 'Admin')
                                    <th>Industry</th>
                                @endif

                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if($sub_category->count() > 0)
                                    @foreach($sub_category as $item)

                                        @if ($item->parent_id != request()->get('parent_id'))
                                            @continue
                                        @endif

                                        @php
                                            if ($item->level == 3) {
                                                // sub-category
                                                $sub_category_parent = $item->parent_id;
                                                $category_parent = App\Models\Category::whereId($sub_category_parent)->first();
                                                $industry = App\Models\Category::whereId($category_parent->parent_id)->first();
                                            }
                                        @endphp

                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            @if (AuthRole() == 'Admin')
                                                <td>
                                                    {{ $industry->name ?? 'Unknown ' }}
                                                </td>
                                            @endif
                                            
                                            <td>
                                                {{ App\Models\Category::whereId($item->parent_id)->first()->name  }}
                                            </td>
                                            <td>
                                                {{ $item->name }} {{ $item->type == 1 ? "" : "(Self)" }}
                                            </td>
                                            <td>
                                                <div class="dropdown open">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="actioncat" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                                Action
                                                            </button>
                                                    <div class="dropdown-menu" aria-labelledby="actioncat">

                                                        @if($item->user_id == auth()->id() || AuthRole() == "Admin")
                                                            <a href="{{ route('panel.constant_management.category.edit', $item->id)  }}" title="Edit Lead Contact" class="btn btn-sm dropdown-item">Edit</a>
                                                        @endif 
                                                        @if(AuthRole() == "Admin")
                                                            <a href="{{ route('panel.constant_management.category.delete', $item->id)  }}" title="Delete Category" class="btn btn-sm delete-item dropdown-item">Delete</a>
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                    @endforeach
                            @else
                                <div class="text-center">
                                    There is no Custom Category
                                </div>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif



</div>