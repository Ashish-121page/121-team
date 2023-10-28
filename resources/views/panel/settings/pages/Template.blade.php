<div class="col-12">
    {{-- {{ asset('frontend/assets/img/default_ppt.svg') }} --}}
    <div class="row">
        <div class="col-12 my-3 text-center">
            <div class="h4">Powerpoint Templates</div>
        </div>
        
        @foreach ($templates as $template)
            @if ($template->user_id != null && $template->user_id != auth()->id() )
                @continue
            @endif
            
            <div class="col-md-3 col-sm-4 col-6 d-flex justify-content-center flex-column card">
                <div class="head d-flex justify-content-between align-items-center w-100" style="height: 250px;width: 250px;object-fit: contain;">
                    <img src="{{ asset($template->thumbnail ?? '') }}" alt="test" class="img-fluid rounded"
                        style="height: 100%;width: 100%;">
                </div>
                
                <div class="body d-flex justify-content-between align-items-center m-2">
                    <div class="one">
                        <div class="name my-2" style="text-transform: uppercase"> {{ $template->name_key }} </div>
                        <div class="lastupdated">{{ $template->updated_at }}</div>
                    </div>
                    <div class="two">
                        <div class="action">

                            <a href="#edit" class="btn-link">Edit</a>
                            @if ($template->user_id == auth()->id())
                                <a href="{{ route('panel.settings.make.default.Template',[auth()->id(),$template->id]) }}" class="btn-link @if ($template->default == 1) text-dark @endif  mx-1">Default</a>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
