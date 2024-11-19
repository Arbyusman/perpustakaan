<!--begin::sidebar menu-->
<div class="s overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true"
            data-kt-menu-expand="false">
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <div class="menu-item">
                    <a class="menu-link" href={{ route('absen.index')}}>
                        <span class="menu-icon"></span>
                        <span class="menu-title">Absen</span>
                    </a>
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <div class="menu-item">
                    <a class="menu-link" href={{ route('users.index')}}>
                        <span class="menu-icon"></span>
                        <span class="menu-title">Users</span>
                    </a>
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <div class="menu-item">
                    <a class="menu-link" href={{ route('roles.index')}}>
                        <span class="menu-icon"></span>
                        <span class="menu-title">Role</span>
                    </a>
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <div class="menu-item">
                    <a class="menu-link" href={{ route('settings.edit')}}>
                        <span class="menu-icon"></span>
                        <span class="menu-title">Setting WEB</span>
                    </a>
                </div>
            </div>

        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
