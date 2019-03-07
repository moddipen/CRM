<ul id="menu" class="page-sidebar-menu">
    @if(Auth::user()->hasAnyPermission(['dashboard']))
        <li {!! (Request::is('admin/home') ? 'class="active"' : '') !!}>
            <a href="{{ route('home') }}">
                <i class="livicon" data-name="dashboard" data-size="25" data-c="#01bc8c" data-hc="#01bc8c"
                   data-loop="true"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['view-user']))    
    <li {!! (Request::is('admin/user') ? 'class="active"' : '') !!} {!! (Request::is('admin/edit/user/*') ? 'class="active"' : '') !!} {!! (Request::is('admin/create/user') ? 'class="active"' : '') !!}>
        <a href="{{ route('user.index') }}">
            <i class="livicon" data-name="users" title="Users List" data-size="25" data-c="#01bc8c" data-hc="#01bc8c" data-loop="true"></i>
            <span class="title">User</span>
        </a>
    </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['view-permission']))    
    <li {!! (Request::is('admin/permission') ? 'class="active"' : '') !!} {!! (Request::is('admin/edit/permission/*') ? 'class="active"' : '') !!} {!! (Request::is('admin/create/permission') ? 'class="active"' : '') !!}>
        <a href="{{ route('permission.index')}}">
            <i class="livicon" data-name="folder-lock" data-size="25" data-c="#00bc8c" data-hc="#00bc8c"
               data-loop="true"></i>
            <span class="title">Permission</span>
        </a>
    </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['view-role']))    
    <li {!! (Request::is('admin/role') ? 'class="active"' : '') !!} {!! (Request::is('admin/edit/role/*') ? 'class="active"' : '') !!}  {!! (Request::is('admin/create/role') ? 'class="active"' : '') !!}>
        <a href="{{ route('role')}}">
            <i class="livicon" data-name="users-add" data-size="25" data-c="#00bc8c" data-hc="#00bc8c"
               data-loop="true"></i>
            <span class="title">Role</span>
        </a>
    </li>
    @endif

    <?php 
        if (Auth::user()->hasAnyPermission(['view-general-leave']) || Auth::user()->hasAnyPermission(['view-employee-leave'])) {
    ?>
    
     <li {!! (Request::is('admin/general/leaves') ? 'class="active"' : '') !!} {!! (Request::is('admin/employee/leaves') ? 'class="active"' : '') !!} {!! (Request::is('admin/edit/general/leave/*') ? 'class="active"' : '') !!}  {!! (Request::is('admin/edit/employee/leave/*') ? 'class="active"' : '') !!} > 
        <a href="#">
            <i class="livicon" data-name="medal" data-size="25" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
            <span class="title">Leave</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            @if(Auth::user()->hasAnyPermission(['view-general-leave']))
            <li {!! (Request::is('admin/general/leaves') ? 'class="active"' : '') !!} {!! (Request::is('admin/create/general/leave') ? 'class="active"' : '') !!} {!! (Request::is('admin/edit/general/leave/*') ? 'class="active"' : '') !!} >
                <a href="{{route('general.leave.index')}}">
                    <i class="fa fa-angle-double-right"></i>General Leave 
                </a> 
            </li>
            @endif
            @if(Auth::user()->hasAnyPermission(['view-employee-leave']))
            <li {!! (Request::is('admin/employee/leaves','admin/create/employee/leave','admin/edit/employee/leave/*') ? 'class="active"' : '') !!} >
                <a href="{{route('employee.leave.index')}}">
                    <i class="fa fa-angle-double-right"></i>Employee Leave
                </a>
            </li>
            @endif
        </ul>
    </li>
    <?php 
        } 
    ?>
    @if(Auth::user()->hasanyrole('Employee'))
        @if(Auth::user()->hasAnyPermission(['apply-for-leave']))
            <li {!! (Request::is('admin/applyForLeave') ? 'class="active"' : '') !!} >
                <a href="{{ route('applyForLeave')}}">
                    <i class="livicon" data-name="users-add" data-size="25" data-c="#00bc8c" data-hc="#00bc8c"
                       data-loop="true"></i>
                    <span class="title">Apply For Leave</span>
                </a>
            </li>
        @endif
    @endif
    @if(Auth::user()->hasAnyPermission(['view-error']))
    <li {!! (Request::is('admin/error','admin/create/error','admin/edit/error/*','admin/view/error/{id}','admin/view/error/*') ? 'class="active"' : '') !!} >
        <a href="{{ route('error.index')}}">
            <i class="livicon" data-name="map" data-size="25" data-c="#00bc8c" data-hc="#00bc8c"
               data-loop="true"></i>
            <span class="title">Error Report</span>
        </a>
    </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['view-ticket']))
    <li {!! (Request::is('admin/ticket') ? 'class="active"' : '') !!} >
        <a href="{{ route('ticket.index')}}">
            <i class="livicon" data-name="list-ul" data-size="25" data-c="#00bc8c" data-hc="#00bc8c"
               data-loop="true"></i>

            <span class="title">Tickets</span>
        </a>
    </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['env-setting']))
    <li {!! (Request::is('admin/env') ? 'class="active"' : '') !!} >
        <a href="{{URL::to('admin/env')}}" >
            <i class="livicon" data-name="flag" data-size="25" data-c="#00bc8c" data-hc="#00bc8c"
               data-loop="true"></i>
            <span class="title">Env Settings</span>
        </a>
    </li>
    @endif
    @include('layouts/menu')
</ul>