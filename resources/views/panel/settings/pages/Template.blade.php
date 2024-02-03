<div class="col-12">
    {{-- {{ asset('frontend/assets/img/default_ppt.svg') }} --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 my-3 text-center">
            <div class="h4">Powerpoint Templates</div>
        </div>

        @foreach ($templates as $template)
            @if ($template->user_id != null && $template->user_id != auth()->id() )
                @continue
            @endif

            <div class="col-md-2 col-sm-4 col-6 d-flex justify-content-center flex-column card">
                <div class="head d-flex justify-content-between align-items-center w-100" style="height: 100px;width: 250px;object-fit: contain;">
                    <img src="{{ asset($template->thumbnail ?? '') }}" alt="test" class="img-fluid rounded"
                        style="height: 100%;width: 100%;">
                </div>

                <div class="body d-flex justify-content-center align-items-center m-2 flex-column ">
                    <div class="one mx-2 text-center">
                        <div class="name my-2" style="text-transform: uppercase"> {{ $template->name_key }} </div>
                        <div class="lastupdated">{{ $template->updated_at }}</div>
                    </div>
                    <div class="two mx-2 my-1">
                        <div class="action">
                            @if ($template->user_id == auth()->id())
                                <a href="{{ route('panel.settings.make.default.Template',[auth()->id(),$template->id]) }}" class="btn
                                    @if ($template->default == 1) btn-secondary @else btn-outline-primary @endif
                                     mx-1">
                                    @if ($template->default == 1) Default @else Set as Default @endif
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 d-flex justify-content-center">
                        @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
                            <a href="{{ route('panel.settings.edit.Template',$template->id) }}" class="btn btn-outline-primary">Edit as a Admin</a>
                        @elseif ($template->user_id == auth()->id())
                            <a href="#edit" class="btn-link">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>
