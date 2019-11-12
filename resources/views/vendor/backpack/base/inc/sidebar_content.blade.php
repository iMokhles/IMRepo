<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<!-- Users, Roles Permissions -->
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
        <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
        <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>

<li><a href="{{ backpack_url('packages') }}"><i class="fa fa-list"></i> <span>{{ trans('backpack::crud.packages') }}</span></a></li>
<li><a href="{{ backpack_url('depictions') }}"><i class="fa fa-list-alt"></i> <span>{{ trans('backpack::crud.depictions') }}</span></a></li>
<li><a href="{{ backpack_url('change_logs') }}"><i class="fa fa-list-alt"></i> <span>{{ trans('backpack::crud.change_logs') }}</span></a></li>
<li><a href="{{ backpack_url('downloads') }}"><i class="fa fa-cloud-download"></i> <span>{{ trans('backpack::crud.downloads') }}</span></a></li>
<li><a href="{{ backpack_url('reviews') }}"><i class="fa fa-certificate"></i> <span>{{ trans('backpack::crud.reviews') }}</span></a></li>

<li><a href='{{ url(config('backpack.base.route_prefix', 'admin').'/backup') }}'><i class='fa fa-hdd-o'></i> <span>Backups</span></a></li>
<li><a href='{{route("log-viewer::logs.list")}}'><i class='fa fa-history'></i> <span>Logs</span></a></li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>


<li><a href='{{ url(config('backpack.base.route_prefix', 'admin') . '/settings') }}'><i class='fa fa-cog'></i> <span>Settings</span></a></li>

<li><a style="background-color: #165900; color: #ffffff;" href='{{ backpack_url('build_packages') }}'><i class='fa fa-refresh'></i> <span>Build Packages</span></a></li>
