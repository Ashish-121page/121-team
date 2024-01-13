@foreach ($paginator as $file)

    <div class="col-4">
        <div class="card text-center">
          <div class="card-body" style="height: 150px;object-fit: contain; width: 150px;">
            @php
                $filetype = explode('/',Storage::mimeType($file));
                $filetype = $filetype[0];
                $filename = basename($file);
                $path = "storage/files/$user->id/$filename";
            @endphp
            @if ($filetype == 'image')
                <img src="{{ asset($path) }}" alt="No Image Available." style="height:100%;width: 100%;" class="rounded">
            @else
                <img src="https://placehold.co/50x50?text={{ $filetype }}" alt="No Image Available." style="height:100%;width: 100%;"  class="rounded">
            @endif
            <span>{{ substr($filename, 0, 5) }}</span>
                
                {{-- <img src="//picsum.photos/250" alt="Asset Preview" style="object-fit:contain;" class="img-fluid"> --}}
            {{-- <button type="button" class="btn btn-outline-primary btn-sm addingitem my-2" id="addingitem"
                data-mediaid="{{ $file }}" data-file_name="{{ basename($filename) }}">Link</button> --}}
                <a href="#" class="link-btn btn-outline-primary btn-sm addingitem my-2" id="addingitem"
                data-mediaid="{{ $file }}" data-file_name="{{ basename($filename) }}">Link</a>
          </div>
        </div>
    </div>


@endforeach

<div class="col-12" >
    @if ($paginator == null)
        <div class="alert alert-warning text-center" role="alert">
            No Assets Found
        </div>
    @else
        {{-- ` Pagination --}}
        <nav aria-label="Page navigation example">
            <ul class="pagination">

                @php
                    $currentPage = request()->get('page',1);
                    $previousPage = ($currentPage != 1) ? $currentPage -1 : 1;
                    $lastPage = ($currentPage != $paginator->lastpage()) ? $currentPage + 1 : $paginator->lastpage();
                    $view = request()->get('view','default');
                @endphp

            <li class="page-item pageassets">
                <a class="page-link" href="{{ request()->url() }}?view={{$view}}&pageassets={{$previousPage}}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            @for ($i = 1; $i <= $paginator->lastpage(); $i++)
                <li class="page-item pageassets @if ($i == $currentPage) active @endif ">
                    <a class="page-link" href="{{ request()->url() }}?view={{$view}}&pageassets={{$i}}">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            <li class="page-item">
                <a class="page-link pageassets" href="{{ request()->url() }}?view={{$view}}&pageassets={{$lastPage}}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            </ul>
        </nav>
    @endif
</div>

<script>
    $('a.page-link').not('a.pageassets').attr("href","#");

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
