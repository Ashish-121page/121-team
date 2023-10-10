<div class="b-footer" style="margin-top: 0px;">
    <div class="b-container">
        @if(getSetting('email_footer'))
            {!! getSetting('email_footer') !!}
        @else
            {{ getSetting('app_name') }} © {{ \Carbon\Carbon::now()->format('Y') }} All rights reserved
        @endif
    </div>
</div>