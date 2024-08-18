@if(session('success'))
    <div style="margin-top: 20px;margin-bottom: 0" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<section class="chat-window-wrapper" id="show_chat">
    @if(!$activeTicket)
    <div class="chat-start">
        <span class="bx bx-message chat-sidebar-toggle chat-start-icon font-large-3 p-3 mb-1"></span>
        <h4 class="d-none d-lg-block py-50 text-bold-500">یک گفت‌وگو را انتخاب نمایید!</h4>
        <button class="btn btn-light-primary chat-start-text chat-sidebar-toggle d-block d-lg-none py-50 px-1">Start
            Conversation!</button>
    </div>
    @else
        @php
        if ($activeTicket->userOne == $user->id) $otherUser = $activeTicket->userTwo2;
        else $otherUser = $activeTicket->userOne1;
        @endphp
    <div class="chat-area">
        <div class="chat-header">
            <header class="d-flex justify-content-between align-items-center border-bottom px-1 py-75">
                <div class="d-flex align-items-center">
                    <div class="chat-sidebar-toggle d-block d-lg-none mr-1"><i class="bx bx-menu font-large-1 cursor-pointer"></i>
                    </div>
                    <div class="avatar chat-profile-toggle m-0 mr-1">
                        <img src="{{ $otherUser->image ? asset('user/image/'.$otherUser->image) : "img/profile.png"}}" alt="avatar" height="36" width="36" />
                    </div>
                    <h6 class="mb-0">{{ $otherUser->name }}</h6>
                </div>
                <div class="chat-header-icons">
                    <span class="dropdown">
                        @if($activeTicket->active == 1)
                            <i class="bx bx-dots-vertical-rounded font-medium-4 ml-25 cursor-pointer dropdown-toggle nav-hide-arrow cursor-pointer" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></i>
                            <span class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <form action="{{ route('tickets.destroy',$activeTicket->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item" type="submit"><i class="bx bx-trash mr-25"></i> بستن تیکت</button>
                                </form>
                            </span>
                        @endif

                    </span>
                </div>
            </header>
        </div>
        <!-- chat card start -->
        <div class="card chat-wrapper shadow-none">
            <div class="card-content">
                <div class="card-body chat-container">
                    <div class="chat-content">

                        @foreach($activeTicket->chats as $chat)

                            @if($chat->text == '--end--')
                                <div class="badge badge-pill badge-light-secondary my-1">
                                    تیکت توسط
                                    {{ $chat->user->name }}
                                    بسته شد
                                </div>
                            @else
                                <div class="chat {{ $chat->user->id == $user->id ? '':'chat-left' }}">
                                    <div class="chat-avatar">
                                        <a class="avatar m-0">
                                            <img src="{{ $chat->user->image ? asset('user/image/'.$chat->user->image) : "img/profile.png"}}" alt="avatar" height="36" width="36" />
                                        </a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-message">
                                            <i class="small">{{ $chat->user->name }}:</i>
                                            <p class="rtl">{{ $chat->text }}</p>
                                            <span class="chat-time">{{ \Morilog\Jalali\Jalalian::forge($chat->TS)->format('Y/m/d H:i:s') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
<!--                        <span id="end_chat"></span>-->
                    </div>
                </div>
            </div>
            <div class="card-footer chat-footer border-top px-2 pt-0 pb-0 mb-1">
                <form action="{{ route('tickets.update',$activeTicket->id) }}" id="form" class="d-flex align-items-center" method="post">
                    @csrf
                    @method('PATCH')
                    <textarea onkeydown="submitFormsWithCtrlEnter()" name="text" class="form-control mx-1" placeholder="پیام خود را بنویسید..."></textarea>
                    <button type="submit" class="btn btn-primary glow send d-lg-flex"><i class="bx bx-paper-plane"></i>
                        <span class="d-none d-lg-block ml-1">ارسال</span></button>
                </form>
                <script>
                    function submitFormsWithCtrlEnter() {
                        $('form').keydown(function(event) {
                            if (event.ctrlKey && event.keyCode === 13) {
                                $(this).trigger('submit');
                            }
                        })
                    }
                </script>
            </div>
        </div>
        <!-- chat card ends -->
    </div>
    <section class="chat-profile">
            <header class="chat-profile-header text-center border-bottom">
                                <span class="chat-profile-close">
                                    <i class="bx bx-x"></i>
                                </span>
                <div class="my-2">
                    <div class="avatar">
                        <img src="{{ $otherUser->image ? asset('user/image/'.$otherUser->image) : "img/profile.png"}}" alt="chat avatar" height="100" width="100">
                    </div>
                    <h5 class="app-chat-user-name mb-0">{{ $otherUser->name }}</h5>
                    <span>آخرین ورود {{ \Morilog\Jalali\Jalalian::forge($otherUser->lastLoginTime)->format('Y/m/d H:i:s') }} </span>
                </div>
            </header>
            <div class="chat-profile-content p-2">
                <h6 class="mt-1">سطح: {{ @$otherUser->roles[0]->name }}</h6>
            </div>
        </section>
    @endif
</section>
