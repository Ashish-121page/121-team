@foreach ($medias as $media)
    <tr class="">
        <td scope="row">
            {{ $loop->iteration }}
        </td>
        <td class="preview-img">
            @php
                $filetype = $media->file_type;
            @endphp
            @if ($filetype == 'Image')
                <img src="{{ asset($media->path) }}" alt="No Image Available." style="height:50px !important;" class="rounded">
            @else
                <img src="https://placehold.co/50x50?text={{ $filetype }}" alt="No Image Available." style="height:50px !important;"  class="rounded">
            @endif
        </td>
        <td>
            {{ basename($media->file_name) }}
        </td>
        <td>
            <button type="button" class="btn btn-outline-primary btn-sm addingitem" id="addingitem"
                data-mediaid="{{ $media->id }}" data-file_name="{{ basename($media->file_name) }}">Link</button>
        </td>
    </tr>
@endforeach

<tr>
    <td colspan="4">
        @if ($medias->isEmpty())
            <div class="alert alert-warning" role="alert">
                No Assets Found
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center">
                {{ $medias->appends(request()->query())->links() }}
            </div>
        @endif
    </td>
</tr>
