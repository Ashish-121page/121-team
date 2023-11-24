<div class="col-md-12 col-12">
    <table class="table">
        <thead class="bg-primary">
            <tr>
                <th scope="col" class="text-light">
                    <input type="checkbox" id="checkall">
                </th>
                <th scope="col" class="text-light">
                    Thumbnail
                </th>
                <th scope="col" class="text-light">
                    Asset Name
                    <i class="fas fa-arrow-up filterbtn @if(request()->get('filtertype') == 'ASC' && request()->get('filtername') == 'name') active @endif" data-filteraname="name" data-filtertype="ASC"></i>
                    <i class="fas fa-arrow-down filterbtn  @if(request()->get('filtertype') == 'DESC' && request()->get('filtername') == 'name') active @endif" data-filteraname="name" data-filtertype="DESC"></i>
                </th>
                <th scope="col" class="text-light">
                    Size
                    <i class="fas fa-arrow-up filterbtn @if(request()->get('filtertype') == 'ASC' && request()->get('filtername') == 'size') active @endif" data-filteraname="size" data-filtertype="ASC"></i>
                    <i class="fas fa-arrow-down filterbtn  @if(request()->get('filtertype') == 'DESC' && request()->get('filtername') == 'size') active @endif" data-filteraname="size" data-filtertype="DESC"></i>
                </th>
                <th scope="col" class="text-light">Extension</th>
                <th scope="col" class="text-light">
                    Linked Items
                    <i class="fas fa-arrow-up filterbtn @if(request()->get('filtertype') == 'ASC' && request()->get('filtername') == 'attachment') active @endif" data-filteraname="attachment" data-filtertype="ASC"></i>
                    <i class="fas fa-arrow-down filterbtn  @if(request()->get('filtertype') == 'DESC' && request()->get('filtername') == 'attachment') active @endif" data-filteraname="attachment" data-filtertype="DESC"></i>
                </th>
                <th scope="col" class="text-light">
                    Last Modified
                    <i class="fas fa-arrow-up filterbtn @if(request()->get('filtertype') == 'ASC' && request()->get('filtername') == 'date') active @endif" data-filteraname="date" data-filtertype="ASC"></i>
                    <i class="fas fa-arrow-down filterbtn  @if(request()->get('filtertype') == 'DESC' && request()->get('filtername') == 'date') active @endif" data-filteraname="date" data-filtertype="DESC"></i>
                </th>
                <th scope="col" class="text-light">
                    
                </th>
            </tr>
        </thead>
        <tbody>

            @forelse ($paginator as $file)
                <tr>
                    <th scope="row">
                        <input type="checkbox" name="checkthis" id="checkthis" class="form-check checkme" value="{{ encrypt($file) }}">
                    </th>
                    <td class="preview-img">
                        @php
                            $filetype = explode("/",Storage::mimeType($file))[0];
                        @endphp
                        @if ($filetype == 'image')
                            <img src="{{ asset(Storage::url($file)) }}" alt="Thumbnail of The Image.">
                        @else
                            <img src="https://placehold.co/600x400?text={{ $filetype }}" alt="Thumbnail of The Image.">
                        @endif
                        
                    </td>
                    <td>
                        <span class="filename" data-oldname="{{ basename($file) }}">
                            {{ basename($file) }}
                        </span>
                    </td>
                    <td>
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
                        <a href="{{ asset(Storage::url($file)) }}" download="{{ basename($file) }}" class="btn-link">Download</a>
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