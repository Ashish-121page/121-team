@can('access_by_admin')
    <div class="nav-item {{ ($segment2 == 'brands') ? 'active' : '' }}">
        <a href="{{ route('panel.brands.index')}}" class="a-item" ><i class="ik ik-command"></i><span>Brands</span></a>
    </div>

    {{-- For New User --}}
    <div class="nav-item {{ activeClassIfRoutes(['panel.users.create','panel.access_codes.index','panel.create.user.bulk'], 'active open') }} has-sub">
        <a href="#"><i class="ik ik-user"></i><span>{{ __('New User')}}</span></a>
        <div class="submenu-content">
            @can('manage_user')
            <a href="{{route('panel.users.create')}}" class="menu-item a-item {{ activeClassIfRoute('panel.users.create', 'active')  }}">{{ __('Add User')}}</a>

            <a href="{{ route('panel.access_codes.index')}}" class="menu-item a-item {{ activeClassIfRoute('panel.access_codes.index', 'active')  }}">{{ __('Access Code')}}</a>

            <a href="{{ route('panel.create.user.bulk')}}" class="menu-item a-item {{ activeClassIfRoute('panel.create.user.bulk', 'active')  }}">{{ __('Bulk Import')}}</a>
            @endcan
        </div>
    </div>

    {{-- Adminstrator Work --}}
    <div class="nav-item {{ activeClassIfRoutes(['panel.users.index', 'panel.users.show','panel.user_shops.index','panel.user_shop_items.index'], 'active open') }} has-sub">
        <a href="#"><i class="ik ik-users"></i><span>{{ __('Adminstrator')}}</span></a>
        <div class="submenu-content">
            <!-- only those have manage_user permission will get access -->
            @can('manage_user')
            <a href="{{route('panel.users.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.users.index', 'panel.users.show',], 'active') }}">{{ __('Users')}}</a>
            @endcan

            {{-- Manage Micro Sites --}}
            <a href="{{route('panel.user_shops.index')}}" class="menu-item a-item {{ activeClassIfRoute('panel.user_shops.index', 'active')  }}">{{ __('Micro Sites')}}</a>

            {{-- Manage Product --}}
            <a href="{{route('panel.user_shop_items.index')}}" class="menu-item a-item {{ activeClassIfRoute('panel.user_shop_items.index', 'active')  }}">{{ __('Products')}}</a>

            
        </div>
    </div>

    {{-- Manage --}}
    <div class="nav-item {{ activeClassIfRoutes([ 'panel.catalogue-request', 'panel.admin.enquiry.index', 'panel.admin.enquiry.create','panel.admin.enquiry.edit', 'panel.admin.enquiry.show' , 'backend.constant-management.proposals.index','panel.constant_management.article.create','panel.constant_management.article.edit','panel.constant_management.article.show','backend.admin.coupons.index','backend/constant-management.news_letters.index','backend/constant-management.news_letters.create','backend/constant-management.news_letters.launchcampaign'], 'active open')  }} has-sub">
        <a href="#"><i class="ik ik-layers"></i><span>{{ __('Manage')}}</span></a>
        <div class="submenu-content">

            {{-- Manage Catelogue Requests --}}
            <a href="{{route('panel.catalogue-request')}}" class="menu-item a-item {{ activeClassIfRoute('panel.catalogue-request', 'active')  }}">{{ __('Catalogue Requests')}}</a>
        
            <a href="{{route('panel.admin.enquiry.index','type=enquiry')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.admin.enquiry.index', 'panel.admin.enquiry.create','panel.admin.enquiry.edit', 'panel.admin.enquiry.show'], 'active')  }}">{{ __('Enquiry')}}</a>

            <!-- Manage Proposals -->
            <a href="{{route('backend.constant-management.proposals.index')}}" class="menu-item {{ activeClassIfRoutes(['backend.constant-management.proposals.index','panel.constant_management.article.create','panel.constant_management.article.edit','panel.constant_management.article.show'], 'active')  }}">{{ __('Proposals')}}</a>

            {{-- Manage and Create Coupons and Voucher --}}
            <a href="{{route('backend.admin.coupons.index')}}" class="menu-item {{ activeClassIfRoutes(['backend.admin.coupons.index'], 'active')  }}">{{ __(' Coupons ')}}</a>

            {{-- Newsletters --}}
            <a href="{{route('backend/constant-management.news_letters.index')}}" class="menu-item {{ activeClassIfRoutes(['backend/constant-management.news_letters.index','backend/constant-management.news_letters.create','backend/constant-management.news_letters.launchcampaign'], 'active')  }}">{{ __(' Newsletters ')}}</a>
            
        </div>
    </div>


    {{-- Report --}}
    <div class="nav-item {{ activeClassIfRoutes(['panel.user_packages.index','panel.report.access-code','panel.report.user-packages','panel.report.user-acquisition','panel.short_url.manage_url','panel.short_url.edit_url'], 'active open')  }} has-sub">
        <a href="#"><i class="ik ik-bar-chart"></i><span>{{ __('Report')}}</span></a>
        <div class="submenu-content">
            <a href="{{ route('panel.user_packages.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.user_packages.index'], 'active')  }}"><span>{{ __('User Subscription')}}</span></a>
            <a href="{{ route('panel.report.access-code')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.report.access-code'], 'active')  }}"><span>{{ __('Access Code')}}</span></a>
            <a href="{{route('panel.report.user-packages')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.report.user-packages'], 'active')  }}">{{ __('User Packages')}}</a>
            <a href="{{route('panel.report.user-acquisition')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.report.user-acquisition'], 'active')  }}">{{ __('User Acquisition')}}</a>

            <a href="{{route('panel.short_url.manage_url')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.short_url.manage_url','panel.short_url.edit_url'], 'active')  }}">{{ __('Manage Short Url')}}</a>
        </div>
    </div>

    {{-- Website Settung --}}
    {{-- <div class="nav-item {{ activeClassIfRoutes(['panel.website_setting.pages','panel.website_setting.pages.create','panel.website_setting.pages.edit', 'panel.website_setting.appearance'] ,'active open' ) }} has-sub">
        <a href="#"><i class="ik ik-monitor"></i><span>{{ __('Website Set
        ')}}</span></a>
        <div class="submenu-content">
            <a href="{{route('panel.website_setting.pages')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.website_setting.pages','panel.website_setting.pages.create','panel.website_setting.pages.edit'], 'active')  }}">{{ __('Pages')}}</a>

        </div>
    </div> --}}
    
    {{-- 121 Site --}}
    <div class="nav-item {{ activeClassIfRoutes(['panel.constant_management.user_enquiry.index','panel.website_setting.footer','panel.website_setting.header','panel.website_setting.pages','panel.website_setting.pages.create','panel.website_setting.pages.edit','panel.packages.index','panel.website_setting.appearance','backend/constant-management.faqs.index','backend/constant-management.faqs.create','backend/constant-management.faqs.edit'], 'active open')  }} has-sub">
        <a href="#"><i class="ik ik-bar-chart"></i><span>{{ __('121 Website')}}</span></a>
        <div class="submenu-content">
            {{-- Manage Enquiries --}}
            <a href="{{route('panel.constant_management.user_enquiry.index')}}" class="menu-item a-item {{ activeClassIfRoute('panel.constant_management.user_enquiry.index', 'active')  }}">{{ __('Website Enquiry')}}</a>

            <a href="{{route('panel.website_setting.footer')}}" class="menu-item a-item {{ activeClassIfRoute('panel.website_setting.footer', 'active')  }}">{{ __('Basic Details')}}</a>

            <a href="{{route('panel.website_setting.header')}}" class="menu-item a-item {{ activeClassIfRoute('panel.website_setting.header', 'active')  }}">{{ __('Header')}}</a>
            
            <a href="{{route('panel.website_setting.pages')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.website_setting.pages','panel.website_setting.pages.create','panel.website_setting.pages.edit'], 'active')  }}">{{ __('Pages')}}</a>
            
            <a href="{{route('panel.constant_management.user_enquiry.index')}}" class="menu-item" ><span>{{ __('Contact')}}</span></a>
            
            <a href="{{ route('panel.packages.index')}}" class="menu-item" ><span>Plans</span></a>
            
            <a href="{{route('panel.website_setting.appearance')}}" class="menu-item a-item {{ activeClassIfRoute('panel.website_setting.appearance', 'active')  }}">{{ __('Appearance')}}</a>
            
            <a href="{{ route('backend/constant-management.faqs.index')}}" class="menu-item {{ activeClassIfRoutes(['backend/constant-management.faqs.index','backend/constant-management.faqs.create','backend/constant-management.faqs.edit',], 'active')  }}">{{ __('FAQ')}}</a>

        </div>
    </div>

    {{-- Global Settings and Configuration --}}
    <div class="nav-item {{ activeClassIfRoutes(['panel.constant_management.category_type.index','panel.constant_management.category_type.create','panel.constant_management.category_type.edit','panel.constant_management.category.index','panel.constant_management.category.create','panel.constant_management.category.edit','panel.product_attributes.index','panel.product_attributes.create','panel.product_attributes.edit','panel.constant_management.location.country','panel.constant_management.location.create','panel.constant_management.location.edit','panel.groups.index','panel.setting.general','panel.setting.mail','panel.constant_management.mail_sms_template.index','panel.constant_management.mail_sms_template.create','panel.constant_management.mail_sms_template.edit','panel.constant_management.mail_sms_template.show','panel.bulk.manage.bulk'], 'active open')  }} has-sub">
        <a href="#"><i class="ik ik-settings"></i><span>{{ __('Global Setup')}}</span></a>
        <div class="submenu-content">
            
            {{-- <a href="{{route('panel.setting.general')}}" class="menu-item a-item {{ activeClassIfRoute('panel.setting.general', 'active')  }}">{{ __('Content Group')}}</a> --}}
        
            <a href="{{route('panel.constant_management.category_type.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.constant_management.category_type.index','panel.constant_management.category_type.create','panel.constant_management.category_type.edit','panel.constant_management.category.index','panel.constant_management.category.create','panel.constant_management.category.edit',], 'active')  }}">{{ __('Category Group')}}</a>

            <a href="{{ route('panel.product_attributes.index')}}" class="menu-item {{ activeClassIfRoutes(['panel.product_attributes.index','panel.product_attributes.create','panel.product_attributes.edit',], 'active')  }}">{{ __('Product Attribute')}}</a>

            <a href="{{ route('panel.bulk.manage.bulk')}}" class="menu-item {{ activeClassIfRoutes(['panel.bulk.manage.bulk'], 'active')  }}">{{ __('Manage Bulk Sheet')}}</a>

            <a href="{{ route('panel.constant_management.location.country')}}" class="menu-item {{ activeClassIfRoutes(['panel.constant_management.location.country','panel.constant_management.location.create','panel.constant_management.location.edit',], 'active')  }}">{{ __('Location')}}</a>

            <a href="{{ route('panel.groups.index') }}" class="menu-item {{ activeClassIfRoutes(['panel.groups.index'], 'active')  }}">{{ __('Price Group')}}</a>

            <a href="{{route('panel.setting.general')}}" class="menu-item a-item {{ activeClassIfRoute('panel.setting.general', 'active')  }}">{{ __('General Settings')}}</a>

            <a href="{{route('panel.setting.mail')}}" class="menu-item a-item {{ activeClassIfRoute('panel.setting.mail', 'active')  }}">{{ __('Mail/SMS Configuration')}}</a>

            <a href="{{route('panel.constant_management.mail_sms_template.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.constant_management.mail_sms_template.index','panel.constant_management.mail_sms_template.create','panel.constant_management.mail_sms_template.edit','panel.constant_management.mail_sms_template.show'], 'active')  }}">{{ __('Mail/Text Templates')}}</a>

        </div>
    </div>


    {{-- Report --}}
    <div class="nav-item {{ activeClassIfRoutes(['panel.constant_management.support_ticket.index','panel.roles', 'panel.permission','panel.constant_management.article.index','panel.constant_management.article.create','panel.constant_management.article.edit','panel.constant_management.article.show','panel.carts.index','panel.orders.index', 'panel.orders.invoice','panel.orders.create', 'panel.orders.show','panel.admin.lead.index', 'panel.admin.lead.create','panel.admin.lead.edit','panel.admin.lead.show','backend.constant-management.slider_types.index','backend.constant-management.slider_types.create','backend.constant-management.slider_types.edit','backend.constant-management.sliders.index','backend.constant-management.sliders.create','backend.constant-management.sliders.edit','backend.site_content_managements.index','backend.site_content_managements.create','backend.site_content_managements.edit','panel.setting.payment','panel.website_setting.social-login'], 'active open')  }} has-sub">

        <a href="#"><i class="ik ik-link"></i><span>{{ __('Deactivated features')}}</span></a>
        <div class="submenu-content">
            {{-- Add Linke Here --}}
            <a href="{{route('panel.constant_management.support_ticket.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.constant_management.support_ticket.index'], 'active')  }}">{{ __('Support Ticket')}}</a>
            <!-- only those have manage_role permission will get access -->
            @can('manage_role')
            <a href="{{route('panel.roles')}}" class="menu-item a-item {{ activeClassIfRoute('panel.roles' ,'active')  }}">{{ __('Roles')}}</a>
            @endcan

            <!-- only those have manage_permission permission will get access -->
            @can('manage_permission')
            <a href="{{route('panel.permission')}}" class="menu-item a-item {{ activeClassIfRoute('panel.permission', 'active')  }}">{{ __('Permission')}}</a>
            @endcan

            <a href="{{route('panel.constant_management.article.index')}}" class="menu-item {{ activeClassIfRoutes(['panel.constant_management.article.index','panel.constant_management.article.create','panel.constant_management.article.edit','panel.constant_management.article.show'], 'active')  }}">{{ __('Articles')}}</a>

            <a href="{{ route('panel.carts.index') }}" class="menu-item {{ activeClassIfRoutes(['panel.carts.index'], 'active')  }}">{{ __('Cart')}}</a>
            
            @can('manage_order')
            <a href="{{ route('panel.orders.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.orders.index', 'panel.orders.invoice','panel.orders.create', 'panel.orders.show'], 'active')  }}"><span>Orders</span></a>
            @endcan
            <a href="{{route('panel.admin.lead.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['panel.admin.lead.index', 'panel.admin.lead.create','panel.admin.lead.edit','panel.admin.lead.show'], 'active')  }}">{{ __('Leads')}}</a>
            
            <a href="{{ route('backend.constant-management.slider_types.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['backend.constant-management.slider_types.index','backend.constant-management.slider_types.create','backend.constant-management.slider_types.edit'], 'active')  }}" ><span>Slider Group</span></a>

            <a href="{{ route('backend.constant-management.sliders.index')}}" class="menu-item a-item {{ activeClassIfRoutes(['backend.constant-management.sliders.index','backend.constant-management.sliders.create','backend.constant-management.sliders.edit',], 'active')  }}" ><span>Slider</span></a>

            <a href="{{ route('backend.site_content_managements.index')}}" class="menu-item {{ activeClassIfRoutes(['backend.site_content_managements.index','backend.site_content_managements.create','backend.site_content_managements.edit',], 'active')  }}">{{ __('Paragraph Content')}}</a>

               
            <a href="{{route('panel.setting.payment')}}" class="menu-item a-item {{ activeClassIfRoute('panel.setting.payment', 'active')  }}">{{ __('Payment Configuaration')}}</a>

            <a href="{{route('panel.website_setting.social-login')}}" class="menu-item a-item {{ activeClassIfRoute('panel.website_setting.social-login',  'active')  }}">{{ __('Social Login')}}</a>
            
        </div>
    </div>

@endcan