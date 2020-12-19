<?php
    $user = \Illuminate\Support\Facades\Session::get('user');
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ ($menu=='home') ? 'active':'' }}">
                <a href="{{ url('/') }}/">
                    <i class="fa fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ ($menu=='items') ? 'active':'' }}">
                <a href="{{ url('/items') }}/">
                    <i class="fa fa-tv"></i> <span>Equipments</span>
                </a>
            </li>
            <li class="{{ ($menu=='reservation') ? 'active':'' }}">
                <a href="{{ url('/reservation') }}/">
                    <i class="fa fa-book"></i> <span>Reservation</span>
                </a>
            </li>
            <li class="hidden treeview @if($menu=='documents' || $menu=='accept' || $menu=='pending') menu-open @endif ">
                <a href="#">
                    <i class="fa fa-tv"></i> <span>Equipments</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" @if($menu=='documents' || $menu=='accept' || $menu=='pending') style="display:block;" @endif >
                    <li class="{{ ($menu=='documents') ? 'active':'' }}"><a href="{{ url('/documents') }}"><i class="fa fa-folder-open-o"></i> Available</a></li>
                    <li class="{{ ($menu=='accept') ? 'active':'' }}"><a href="#acceptDocument" data-toggle="modal"><i class="fa fa-clock-o"></i> Borrowed</a></li>
                    <li class="{{ ($menu=='accept') ? 'active':'' }}"><a href="#acceptDocument" data-toggle="modal"><i class="fa fa-calendar-plus-o"></i> Reserved</a></li>
                </ul>
            </li>
            <li class="{{ ($menu=='job') ? 'active':'' }}">
                <a href="{{ url('/job') }}/">
                    <i class="fa fa-fax"></i> <span>Job Request</span>
                    <span class="pull-right-container">
                      <span class="label label-success pull-right">{{ \App\Http\Controllers\JobController::countPendingJob() }}</span>
                    </span>
                </a>
            </li>
            <li class="{{ ($menu=='task') ? 'active':'' }}">
                <a href="{{ url('/tasks') }}/">
                    <i class="fa fa-file-text-o"></i> <span>Tasks</span>

                    <span class="pull-right-container">
                      <span class="label label-warning pull-right">{{ \App\Http\Controllers\TaskController::countPendingTask() }}</span>
                    </span>
                </a>
            </li>
            <li class="treeview {{ ($menu=='ip') ? 'active menu-open':'' }}">
                <a href="#">
                    <i class="fa fa-code-fork"></i> <span>IP Address</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(isset($sub) && $sub=='5.5') active @endif"><a href="{{ url('/ip/5') }}"><i class="fa fa-code-fork"></i> 192.168.5.*</a></li>
                    <li class="@if(isset($sub) && $sub=='10.10') active @endif"><a href="{{ url('/ip/10') }}"><i class="fa fa-code-fork"></i> 192.168.10.*</a></li>
                </ul>
            </li>
            <li class="{{ ($menu=='system') ? 'active':'' }}">
                <a href="{{ url('/') }}/">
                    <i class="fa fa-chrome"></i> <span>System Request</span>
                </a>
            </li>


            <li class="treeview hidden">
                <a href="#">
                    <i class="fa fa-bar-chart"></i> <span>Generate Report</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/report/personal') }}"><i class="fa fa-user"></i> Personal Logs</a></li>
                    <li><a href="{{ url('/report/section') }}"><i class="fa fa-users"></i> Section Logs</a></li>
                    @if($user->level=='admin')
                        <li><a href="{{ url('/admin/report/logs') }}"><i class="fa fa-print"></i> All Logs</a></li>
                    @endif
                </ul>
            </li>
            <div class="hidden">
            @if($user->level=='admin')
                <li class="header">SYSTEM PARAMETERS</li>
                <li class="{{ ($menu=='users') ? 'active':'' }}">
                    <a href="{{ url('/admin/users') }}">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>
                <li class="{{ ($menu=='designation') ? 'active':'' }}">
                    <a href="{{ url('/admin/designation') }}">
                        <i class="fa fa-user-md"></i> <span>Designation</span>
                    </a>
                </li>
                <li class="{{ ($menu=='section') ? 'active':'' }}">
                    <a href="{{ url('/admin/section') }}">
                        <i class="fa fa-building"></i> <span>Section/Unit</span>
                    </a>
                </li>
                <li class="{{ ($menu=='division') ? 'active':'' }}">
                    <a href="{{ url('/admin/division') }}">
                        <i class="fa fa-building-o"></i> <span>Division</span>
                    </a>
                </li>
            @endif
            </div>
            <li class="header">ACCOUNT SETTINGS</li>
            <li class="{{ ($menu=='profile') ? 'active':'' }} hidden">
                <a href="{{ url('/user/profile') }}">
                    <i class="fa fa-user"></i> <span>Update Profile</span>
                </a>
            </li>
            <li class="{{ ($menu=='calendar') ? 'active':'' }} hidden">
                <a href="{{ url('/user/calendar') }}">
                    <i class="fa fa-calendar"></i> <span>My Calendar</span>
                </a>
            </li>
            <li>
                <a href="#changePassword" data-toggle="modal">
                    <i class="fa fa-unlock-alt"></i> <span>Change Password</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/logout') }}">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>