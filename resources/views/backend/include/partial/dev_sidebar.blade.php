@can('manage_dev')

        <div class="nav-item {{ ($segment2 == 'users' || $segment2 == 'roles'||$segment2 == 'permission' ||$segment2 == 'user') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
            <div class="submenu-content">
                <!-- only those have manage_user permission will get access -->
                @can('manage_user')
                <a href="{{url('panel/users')}}" class="menu-item a-item {{ ($segment2 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                <a href="{{url('panel/user/create')}}" class="menu-item a-item {{ ($segment2 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                @endcan
                <!-- only those have manage_role permission will get access -->
                @can('manage_role')
                <a href="{{url('panel/roles')}}" class="menu-item a-item {{ ($segment2 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                @endcan
                <!-- only those have manage_permission permission will get access -->
                @can('manage_permission')
                <a href="{{url('panel/permission')}}" class="menu-item a-item {{ ($segment2 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
                @endcan
            </div>
        </div>

        <div class="nav-lavel">{{ __('Crud Genrator')}} </div>
        <div class="nav-item {{ ($segment2 == 'crudgen') ? 'active' : '' }}">
            <a href="{{route('crudgen.index')}}"><i class="ik ik-grid"></i><span>{{ __('CRUD Genrator')}}</span></a>
        </div>
        <div class="nav-item {{ ($segment2 == 'crudgen') ? 'active' : '' }}">
            <a href="{{route('crudgen.bulkimport')}}"><i class="ik ik-upload"></i><span>{{ __('Bulk Import')}}</span></a>
        </div>
        <div class="nav-lavel">{{ __('Documentation')}} </div>

        <div class="nav-item {{ ($segment2 == 'icons') ? 'active' : '' }}">
            <a href="{{url('dev/icons')}}"><i class="ik ik-command"></i><span>{{ __('Icons')}}</span></a>
        </div>
        <div class="nav-item {{ ($segment2 == 'rest-api') ? 'active' : '' }}">
            <a href="{{url('dev/rest-api')}}"><i class="ik ik-cloud"></i><span>{{ __('REST API')}}</span> <span class=" badge badge-success badge-right">{{ __('New')}}</span></a>
        </div>

        <div class="nav-item {{ ($segment2 == 'form-components' || $segment2 == 'form-advance'||$segment2 == 'form-addon') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-edit"></i><span>{{ __('Forms')}}</span></a>
            <div class="submenu-content">
                <a href="{{url('dev/form-components')}}" class="menu-item {{ ($segment2 == 'form-components') ? 'active' : '' }}">{{ __('Components')}}</a>
                <a href="{{url('dev/form-addon')}}" class="menu-item {{ ($segment2 == 'form-addon') ? 'active' : '' }}">{{ __('Add-On')}}</a>
                <a href="{{url('dev/form-advance')}}" class="menu-item {{ ($segment2 == 'form-advance') ? 'active' : '' }}">{{ __('Advance')}}</a>
            </div>
        </div>
        <div class="nav-item {{ ($segment2 == 'form-picker') ? 'active' : '' }}">
            <a href="{{url('dev/form-picker')}}"><i class="ik ik-cloud"></i><span>{{ _('Form Picker')}}</span> </a>
        </div>
        <div class="nav-item {{ ($segment2 == 'client-datatable' || $segment2 == 'server-datatable') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-edit"></i><span>{{ __('Datatable')}}</span></a>
            <div class="submenu-content">
                <a href="{{url('dev/client-datatable')}}" class="menu-item {{ ($segment2 == 'client-datatable') ? 'active' : '' }}">{{ __('Client Side')}}</a>
                <a href="{{url('dev/server-datatable')}}" class="menu-item {{ ($segment2 == 'server-datatable') ? 'active' : '' }}">{{ __('Server Side')}}</a>
            </div>
        </div>
        <div class="nav-item {{ ($segment2 == 'widgets' || $segment2 == 'widget-statistic'||$segment2 == 'widget-data'||$segment2 == 'widget-chart') ? 'active open' : '' }} has-sub">
            <a href="javascript:void(0)"><i class="ik ik-layers"></i><span>{{ __('Widgets')}}</span> <span class="badge badge-danger">{{ __('150+')}}</span></a>
            <div class="submenu-content">
                <a href="{{url('dev/widgets')}}" class="menu-item {{ ($segment2 == 'widgets') ? 'active' : '' }}">{{ __('Basic')}}</a>
                <a href="{{url('dev/widget-statistic')}}" class="menu-item {{ ($segment2 == 'widget-statistic') ? 'active' : '' }}">{{ __('Statistic')}}</a>
                <a href="{{url('dev/widget-data')}}" class="menu-item {{ ($segment2 == 'widget-data') ? 'active' : '' }}">{{ __('Data')}}</a>
                <a href="{{url('dev/widget-chart')}}" class="menu-item {{ ($segment2 == 'widget-chart') ? 'active' : '' }}">{{ __('Chart Widget')}}</a>
            </div>
        </div>
        <div class="nav-item {{ ($segment2 == 'alerts' || $segment2 == 'buttons'||$segment2 == 'badges'||$segment2 == 'navigation' ||$segment2 =='accordion-collapse') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-box"></i><span>{{ __('Basic')}}</span></a>
            <div class="submenu-content">
                <a href="{{url('dev/alerts')}}" class="menu-item {{ ($segment2 == 'alerts') ? 'active' : '' }}">{{ __('Alerts')}}</a>
                <a href="{{url('dev/badges')}}" class="menu-item {{ ($segment2 == 'badges') ? 'active' : '' }}">{{ __('Badges')}}</a>
                <a href="{{url('dev/buttons')}}" class="menu-item {{ ($segment2 == 'buttons') ? 'active' : '' }}">{{ __('Buttons')}}</a>
                <a href="{{url('dev/navigation')}}" class="menu-item {{ ($segment2 == 'navigation') ? 'active' : '' }}">{{ __('Navigation')}}</a>
                <a href="{{url('dev/accordion-collapse')}}" class="menu-item {{ ($segment2 == 'accordion-collapse') ? 'active' : '' }}">{{ __('Accordion-Collapse')}}</a>
            </div>
        </div>
        <div class="nav-item {{ ($segment2 == 'modals' || $segment2 == 'notifications'||$segment2 == 'carousel'||$segment2 == 'range-slider' ||$segment2 == 'rating') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-gitlab"></i><span>{{ __('Advance')}}</span> </a>
            <div class="submenu-content">
                <a href="{{url('dev/modals')}}" class="menu-item {{ ($segment2 == 'modals') ? 'active' : '' }}">{{ __('Modals')}}</a>
                <a href="{{url('dev/notifications')}}" class="menu-item {{ ($segment2 == 'notifications') ? 'active' : '' }}" >{{ __('Notifications')}}</a>
                <a href="{{url('dev/carousel')}}" class="menu-item {{ ($segment2 == 'carousel') ? 'active' : '' }}">{{ __('Slider')}}</a>
                <a href="{{url('dev/range-slider')}}" class="menu-item {{ ($segment2 == 'range-slider') ? 'active' : '' }}">{{ __('Range Slider')}}</a>
                <a href="{{url('dev/rating')}}" class="menu-item {{ ($segment2 == 'rating') ? 'active' : '' }}">{{ __('Rating')}}</a>
            </div>
        </div>


        <div class="nav-item {{ ($segment2 == 'charts-chartist' || $segment2 == 'charts-flot'||$segment2 == 'charts-knob'||$segment2 == 'charts-amcharts') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-pie-chart"></i><span>{{ __('Charts')}}</span> </a>
            <div class="submenu-content">
                <a href="{{url('dev/charts-chartist')}}" class="menu-item {{ ($segment2 == 'charts-chartist') ? 'active' : '' }}">{{ __('Chartist')}}</a>
                <a href="{{url('dev/charts-flot')}}" class="menu-item {{ ($segment2 == 'charts-flot') ? 'active' : '' }}">{{ __('Flot')}}</a>
                <a href="{{url('dev/charts-knob')}}" class="menu-item {{ ($segment2 == 'charts-knob') ? 'active' : '' }}">{{ __('Knob')}}</a>
                <a href="{{url('dev/charts-amcharts')}}" class="menu-item {{ ($segment2 == 'charts-amcharts') ? 'active' : '' }}">{{ __('Amcharts')}}</a>
            </div>
        </div>
        <div class="nav-item {{ ($segment2 == 'pricing') ? 'active' : '' }}">
            <a href="{{url('dev/pricing')}}"><i class="ik ik-dollar-sign"></i><span>{{ __('Pricing')}}</span></a>
        </div>
        <div class="nav-item {{ ($segment2 == 'calendar') ? 'active' : '' }}">
            <a href="{{url('dev/calendar')}}"><i class="ik ik-dollar-sign"></i><span>{{ __('Calendar')}}</span><span class=" badge badge-success badge-right">{{ __('New')}}</span></a>
        </div>
        <div class="nav-item {{ ($segment2 == 'file-manager' || $segment2 == 'pdf-viewer'|| $segment2 == 'image-cropper') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-pie-chart"></i><span>{{ __('Dev Tools')}}</span> </a>
            <div class="submenu-content">
                <a href="{{url('dev/file-manager')}}" class="menu-item {{ ($segment2 == 'file-manager') ? 'active' : '' }}">{{ __('File Manager')}}</a>
                <a href="{{url('dev/pdf-viewer')}}" class="menu-item {{ ($segment2 == 'pdf-viewer') ? 'active' : '' }}">{{ __('Pdf Viewer') }}</a>
                <a href="{{url('dev/image-cropper')}}" class="menu-item {{ ($segment2 == 'image-cropper') ? 'active' : '' }}">{{ __('Image Cropper')}}</a>
                <a href="{{url('dev/drag-cropper')}}" class="menu-item {{ ($segment2 == 'drag-cropper') ? 'active' : '' }}">{{ __('Image Drag & Cropper')}}</a>
                <a href="{{url('dev/notes')}}" class="menu-item {{ ($segment2 == 'notes') ? 'active' : '' }}">{{ __('Notes')}}</a>
            </div>
        </div>
        <div class="nav-item has-sub">
            <a href="javascript:void(0)"><i class="ik ik-list"></i><span>{{ __('Menu Levels')}}</span></a>
            <div class="submenu-content">
                <a href="javascript:void(0)" class="menu-item">{{ __('Menu Level 2.1')}}</a>
                <div class="nav-item {{ ($segment2 == '') ? 'active' : '' }} has-sub">
                    <a href="javascript:void(0)" class="menu-item">{{ __('Menu Level 2.2')}}</a>
                    <div class="submenu-content">
                        <a href="javascript:void(0)" class="menu-item">{{ __('Menu Level 3.1')}}</a>
                    </div>
                </div> 
                <a href="javascript:void(0)" class="menu-item">{{ __('Menu Level 2.3')}}</a>
            </div>
        </div>
        <div class="nav-item">
            <a href="javascript:void(0)" class="disabled"><i class="ik ik-slash"></i><span>{{ __('Disabled Menu')}}</span></a>
        </div>


@endcan