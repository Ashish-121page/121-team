@extends('native_email.layout')
@section('content')

<div class="b-container">
    <div class="b-panel">
      {!! $content['t_data'] !!}
      @if($content['t_footer'])
      <br><br>
      {!! $content['t_footer'] !!}
      @endif
        <br><br> 
        Regards,<br>
        {{ config('app.name') }}
    </div>
</div>
@endsection
