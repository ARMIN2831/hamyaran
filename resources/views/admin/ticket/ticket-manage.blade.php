@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-area-wrapper">
        <div class="sidebar-left">
            <div class="sidebar">
                <!-- app chat user profile left sidebar start -->
                <div class="chat-user-profile">
                    <header class="chat-user-profile-header text-center border-bottom">
                            <span class="chat-profile-close">
                                <i class="bx bx-x"></i>
                            </span>
                        <div class="my-2">
                            <div class="avatar">
                                <img src="{{ $user->image ? asset('public/user/image/'.$user->image) : "public/img/profile.png"}}" alt="user_avatar" height="100" width="100">
                            </div>
                            <h5 class="mb-0">{{ $user->name }}</h5>
                            <span>{{ @$user->roles[0]->name }}</span>
                        </div>
                    </header>
                    <div class="chat-user-profile-content">
                        <div class="chat-user-profile-scroll">
                            <h6 class="text-uppercase mb-1">فعالیت‌ها</h6>
                            <ul class="list-unstyled">
                                <li class="mb-50 "><a href="{{ route('tickets.manage') }}" class="d-flex align-items-center">
                                        <i class="bx bx-loader mr-50"></i>بروزرسانی لیست تیکت‌ها</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- app chat user profile left sidebar ends -->
                <!-- app chat sidebar start -->
                <div class="chat-sidebar card">
                        <span class="chat-sidebar-close">
                            <i class="bx bx-x"></i>
                        </span>
                    <div class="chat-sidebar-search">
                        <div class="d-flex align-items-center">
                            <div class="chat-sidebar-profile-toggle">
                                <div class="avatar">
                                    <img src="{{ $user->image ? asset('public/user/image/'.$user->image) : "public/img/profile.png"}}" alt="user_avatar" height="36" width="36">
                                </div>
                            </div>
                            <fieldset class="form-group position-relative has-icon-left mx-75 mb-0">
                                <input type="text" class="form-control round" id="chat-search" placeholder="Search">
                                <div class="form-control-position">
                                    <i class="bx bx-search-alt text-dark"></i>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="chat-sidebar-list-wrapper pt-0">
                        <h6 class="px-2 pt-2 pb-25 mb-0">همه تیکت‌های </h6>
                        <ul class="chat-sidebar-list">
                            @foreach($tickets as $ticket)
                                <a href="{{ route('tickets.manage',['ticket'=>$ticket->id]) }}">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar m-0 mr-50">
                                                <img src="{{ $ticket->userOne1->image ? asset('public/user/image/'.$ticket->userOne1->image) : "public/img/profile.png"}}" height="36" width="36" alt="sidebar user image">
                                                <img src="{{ $ticket->userTwo2->image ? asset('public/user/image/'.$ticket->userTwo2->image) : "public/img/profile.png"}}" height="36" width="36" alt="sidebar user image">
                                                <span class="avatar-status-'.($tkt->active?'online':'offline').'"></span>
                                            </div>
                                            <div class="chat-sidebar-name">
                                                <h6 class="mb-0">{{ $ticket->title }}</h6>
                                                <span class="text-muted">{{ $ticket->userOne1->name }}</span><br>
                                                <span class="text-muted">{{ $ticket->userTwo2->name }}</span><br>
                                                <span class="small">{{ \Morilog\Jalali\Jalalian::forge($ticket->srartTS)->format('Y/m/d H:i:s') }}</span>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <!-- app chat sidebar ends -->
            </div>
        </div>
        <div class="content-right bg-white">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- app chat overlay -->
                    <div class="chat-overlay"></div>
                    @include('admin.ticket.ticket-manage-show',['activeTicket'=>$activeTicket, 'user'=>$user])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
