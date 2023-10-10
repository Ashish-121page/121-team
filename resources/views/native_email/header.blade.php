<div class="" style="">
    <div class="b-container">
        <div class="b-header">
            @php $email_header = getSetting('email_header') @endphp
            {!! $email_header ? $email_header : sprintf('<h1 class="site-title">%s</h1>',getSetting('app_name')) !!}
        </div>
    </div>
</div>
