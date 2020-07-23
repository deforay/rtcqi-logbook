<?php 

if(session('loginType')=='users'){

    $profileURl="/user/profile/".base64_encode(session('userId'));
}else{
    $profileURl="/vendors/profile/".base64_encode(session('userId'));
}
?>
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="/dashboard">
                    <!-- <h3 class="text-center ml-2"><b></b></h3> -->
                        <!-- <img class="brand-logo" alt="modern admin logo" src="{{ asset('app-assets/images/logo/asm_logo.png')}}"> -->
                            <h3 class="brand-text">P &amp; I Management</h3>
                        </a></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container container center-layout">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700">@if (session('username')) {{ ucfirst(session('username')) }} @endif</span><span class="avatar avatar-online"><img src="{{ asset('app-assets/images/portrait/small/avatar-s-19.png')}}" alt="avatar"><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{$profileURl}}"><i class="ft-user"></i> Edit Profile</a>
                                <a class="dropdown-item" href="/changePassword/{{ base64_encode(session('userId'))}}"><i class="ft-user"></i> Change Password</a>
                                <!-- <a class="dropdown-item" href="app-kanban.html"><i class="ft-clipboard"></i> Todo</a>
                                <a class="dropdown-item" href="user-cards.html"><i class="ft-check-square"></i> Task</a> -->
                                <div class="dropdown-divider"></div>
                                <form action="/logout" name="logoutForm" id="logoutForm" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="ft-power"></i> Logout</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>