@foreach ($medias as $media)
    {{-- <tr class="">
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
    </tr> --}}

    <div class="col-3">
        <div class="card text-center">
          <div class="card-body" style="height: fit-content">
            @php
                $filetype = $media->file_type;
            @endphp
            @if ($filetype == 'Image')
                <img src="{{ asset($media->path) }}" alt="No Image Available." style="height:50px !important;" class="rounded">
            @else
                <img src="https://placehold.co/50x50?text={{ $filetype }}" alt="No Image Available." style="height:50px !important;"  class="rounded">
            @endif

            {{-- <img src="//picsum.photos/250" alt="Asset Preview" style="object-fit:contain;" class="img-fluid"> --}}
            <button type="button" class="btn btn-outline-primary btn-sm addingitem my-2" id="addingitem"
                data-mediaid="{{ $media->id }}" data-file_name="{{ basename($media->file_name) }}">Link</button>
          </div>
        </div>
    </div>


@endforeach

<div class="col-12" >
    @if ($medias->isEmpty())
        <div class="alert alert-warning text-center" role="alert">
            No Assets Found
        </div>
    @else
        <div class="d-flex align-items-center justify-content-center" style="overflow: auto">
            {{ $medias->appends(request()->query())->links() }}
        </div>
    @endif
</div>

{{-- <tr>
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
</tr> --}}

<script>
    $('a.page-link').attr("href","#");
    $(document).ready(function () {
        $('a.page-link').attr("href","#");

        $("li.page-item").click(function (e) {
            $('a.page-link').attr("href","#");
            e.preventDefault();
            console.log($(this).children('a').html());


            $.ajax({
                type: "GET",
                url: "{{ route('panel.products.search.assets') }}",
                data: {
                    page: $(this).children('a').html(),
                    type:'page'
                },
                success: function (response) {
                    $("#updateseachassets").html(response);


                    $(".addingitem").click(function(e) {
                        e.preventDefault();
                        $(this).addClass("active");
                        $(this).addClass("disabled");


                        let mediaid = $(this).data("mediaid");
                        let file_name = $(this).data("file_name");

                        if (addedassets != null) {
                            addedassets.push(mediaid);
                            addedassetsFilename.push(file_name);
                        }

                        let addedassets1 = [...new Set(addedassets)];
                        let addedassetsFilename1 = [...new Set(addedassetsFilename)];

                        localStorage.setItem("mediaId", addedassets1)
                        localStorage.setItem("mediaFilename", addedassetsFilename1)

                        appendAssets(addedassets1, addedassetsFilename1);

                    });

                },error:function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>
