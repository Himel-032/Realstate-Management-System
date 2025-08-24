<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin_dashboard') }}">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin_dashboard') }}"></a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_dashboard') }}"><i class="fas fa-home"></i>
                    <span>Dashboard</span></a></li>
            <li class="{{ Request::is('admin/profile') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_profile') }}"><i class="fas fa-file"></i>
                    <span>Edit Profile</span></a></li>
            <li><a class="nav-link" href="{{ route('admin_logout') }}"><i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a></li>

            <!-- <li class="nav-item dropdown active">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i><span>Dropdown
                        Items</span></a>
                <ul class="dropdown-menu">
                    <li class="active"><a class="nav-link" href=""><i class="fas fa-file"></i> Item 1</a></li>
                    <li class=""><a class="nav-link" href=""><i class="fas fa-file"></i> Item 2</a></li>
                </ul>
            </li> -->

            <!-- <li class=""><a class="nav-link" href="setting.html"><i class="fas fa-file"></i>
                    <span>Setting</span></a></li>

            <li class=""><a class="nav-link" href="form.html"><i class="fas fa-file"></i>
                    <span>Form</span></a></li>

            <li class=""><a class="nav-link" href="table.html"><i class="fas fa-file"></i>
                    <span>Table</span></a></li>

            <li class=""><a class="nav-link" href="invoice.html"><i class="fas fa-file"></i>
                    <span>Invoice</span></a></li> -->

        </ul>
    </aside>
</div>