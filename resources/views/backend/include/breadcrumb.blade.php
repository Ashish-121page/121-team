
<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('customer.dashboard')}}"><i class="ik ik-home"></i></a>
        </li>
        @foreach ($breadcrumb_arr as $item)
            @if($item != null)
                <li class=" breadcrumb-item {{ $item['class'] }}"><a href="{{$item['url']}}" class="item">{{$item['name']}}</a></li>
            @endif
        @endforeach
        {{-- <li class="breadcrumb-item"><a href="#">{{ __('Setting')}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('General')}}</li> --}}
    </ol>
</nav>