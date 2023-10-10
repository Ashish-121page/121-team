@can('access_by_marketer')

    <div class="nav-item {{ ($segment2 == 'access_code') ? 'active' : '' }}">
        <a href="{{ route('panel.access_codes.index')}}" class="a-item" ><i class="ik ik-share"></i><span>{{ 'Access Code' }}</span></a>
    </div>

    <div class="nav-item {{ ($segment2 == 'contact') ? 'active' : '' }}">
        <a href="{{ route('panel.support_ticket.index') }}" class="a-item" ><i class="ik ik-help-circle"></i><span>{{ 'Support Ticket' }}</span></a>
    </div>

@endcan