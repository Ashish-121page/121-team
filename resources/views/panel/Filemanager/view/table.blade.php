<div class="col-md-12 col-12">
    <table class="table ">
        <thead class="bg-primary">
            <tr>
                <th scope="col" class="text-light" style="">
                    <input type="checkbox" id="checkall">
                </th>
                <th   scope="col" class="text-light">
                    Thumbnail
                </th>
                <th colspan="2" scope="col" class="text-light">
                    <div style="display: flex; flex-direction: column;">
                        <span style="margin-bottom: 5px;">Asset Name</span>
                        <div>
                            <i class="fas fa-arrow-up filterbtn @if(request()->get('filtertype') == 'ASC' && request()->get('filtername') == 'name') active @endif" data-filteraname="name" data-filtertype="ASC"></i>
                            <i class="fas fa-arrow-down filterbtn  @if(request()->get('filtertype') == 'DESC' && request()->get('filtername') == 'name') active @endif" data-filteraname="name" data-filtertype="DESC"></i>
                        </div>
                    </div>
                </th>
                <th scope="col" class="text-light" style="width: 150px;">
                    <div style="display: flex; flex-direction: column;">
                        <span style="margin-bottom: 5px;">Size</span>
                        <div style="display: flex; ">
                            <i class="fas fa-arrow-up filterbtn @if(request()->get('filtertype') == 'ASC' && request()->get('filtername') == 'size') active @endif" data-filteraname="size" data-filtertype="ASC"></i>
                            <i class="fas fa-arrow-down filterbtn @if(request()->get('filtertype') == 'DESC' && request()->get('filtername') == 'size') active @endif" data-filteraname="size" data-filtertype="DESC"></i>
                        </div>
                    </div>
                </th>
                
                <th scope="col" class="text-light">Extension</th>
                <th scope="col" class="text-light">
                    <div style="display: flex; flex-direction: column;">
                        <span style="margin-bottom: 5px;">Linked Items</span>
                        <div>
                            <i class="fas fa-arrow-up filterbtn @if(request()->get('filtertype') == 'ASC' && request()->get('filtername') == 'attachment') active @endif" data-filteraname="attachment" data-filtertype="ASC"></i>
                            <i class="fas fa-arrow-down filterbtn @if(request()->get('filtertype') == 'DESC' && request()->get('filtername') == 'attachment') active @endif" data-filteraname="attachment" data-filtertype="DESC"></i>
                        </div>
                    </div>
                </th>
                <th scope="col" class="text-light">
                    <div style="display: flex; flex-direction: column; ">
                        <span style="margin-bottom: 5px;">Last Modified</span>
                        <div>
                            <i class="fas fa-arrow-up filterbtn @if(request()->get('filtertype') == 'ASC' && request()->get('filtername') == 'date') active @endif" data-filteraname="date" data-filtertype="ASC"></i>
                            <i class="fas fa-arrow-down filterbtn  @if(request()->get('filtertype') == 'DESC' && request()->get('filtername') == 'date') active @endif" data-filteraname="date" data-filtertype="DESC"></i>
                        </div>
                    </div>
                </th>     
                <th scope="col" class="text-light">
                    
                </th>
            </tr>
        </thead>
        <tbody>

            @forelse ($paginator as $file)
                <tr>
                    {{-- <th scope="row">
                        <input type="checkbox" name="checkthis" id="checkthis" class="form-check checkme" value="{{ encrypt($file) }}">
                    </th> --}}
                    <th scope="row" style="display: flex; align-items: center;">
                        <input type="checkbox" name="checkthis" id="checkthis" class="form-check checkme mt-4" value="{{ encrypt($file) }}">
                    </th>
                    
                    <td class="preview-img">
                        @php
                            $filetype = explode("/",Storage::mimeType($file))[0];
                        @endphp
                        @if ($filetype == 'image')
                            <img src="{{ asset(Storage::url($file)) }}" alt="Thumbnail of The Image." style="height:180% !important;">
                        @else
                            <img src="https://placehold.co/600x400?text={{ $filetype }}" alt="Thumbnail of The Image.">
                        @endif
                        
                    </td>
                    <td colspan="2">
                        <span class="filename" data-oldname="{{ basename($file) }}">
                            {{ basename($file) }}
                        </span>
                    </td>
                    <td style="width:100px !important;" >
                        {{ number_format(Storage::size($file)/ (1024 * 1024),2) }} MB
                    </td>
                    <td  class="text-uppercase">
                        {{ pathinfo($file, PATHINFO_EXTENSION) }}
                    </td>
                    <td style="width: 250px">
                        @php
                            $filename = basename($file);
                            $user_id = auth()->id();
                            $path = "storage/files/$user_id/$filename";
                            $linked = App\Models\Media::where('path',$path)->groupBy('type_id')->pluck('type_id');
                            $models = App\Models\Product::whereIn('id',$linked)->groupBy('model_code')->pluck('model_code');
                        @endphp
                        @forelse ($models as $key => $model)
                            {{ $model }} 
                            @if ($key != 0)
                                ,
                            @endif
                        @empty
                            No Item Linked
                        @endforelse
                        
                    </td>
                    <td>
                        <span>
                            {{ date("Y-m-d H:i:s",Storage::lastModified($file)) }}
                        </span>
                    </td>
                    <td>
                        
                            <div style="display: flex;">
                                <a href="{{ route('panel.image.studio',encrypt($file)) }}" class="btn-link mx-3">
                                    Edit
                                </a>
                                <a href="{{ asset(Storage::url($file)) }}" download="{{ basename($file) }}" class="btn-link">Download</a>
                            </div>
                        
                    </td>
                </tr>
            @empty
            
                <tr>
                    <td colspan="6" class="text-center">
                        No Files are Exist
                    </td>
                </tr>
                
            @endforelse
        </tbody>
    </table>
</div>