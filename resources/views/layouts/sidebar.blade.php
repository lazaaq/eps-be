<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">
            @if(Auth::user()->hasAnyRole('admin'))
            <!-- Main -->
            <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
            <li><a href="{{url('admin/user-package')}}"><img src="{{asset('img/web_ic_home.png')}}" alt="" style="height:20px;margin-right:15px"><span>User dan Paket</span></a></li>
            <li><a href="{{url('admin/dashboard')}}"><img src="{{asset('img/web_ic_home.png')}}" alt="" style="height:20px;margin-right:15px"><span>Dashboard</span></a></li>
            <!-- <li><a href="{{url('admin/history')}}"><img src="{{asset('img/web_ic_home.png')}}" alt="" style="height:20px;margin-right:15px"><span>History</span></a></li> -->
            <li><a href="{{route('transaction.index')}}"><img src="{{asset('img/web_ic_home.png')}}" alt="" style="height:20px;margin-right:15px"><span>Transaction</span></a></li>
            <li class="navigation-header"><span>Package</span> <i class="icon-menu" title="Main pages"></i></li>
            <li><a href="{{route('package.index')}}"><img src="{{asset('img/web_ic_type.png')}}" alt="icon" style="height:20px;margin-right:15px"> <span>Schedule</span></a></li>
            <li><a href="{{route('noninteractive.index')}}"><img src="{{asset('img/web_ic_banner.png')}}" alt="icon" style="height:20px;margin-right:15px"> <span>Non Interactive</span></a></li>
            <li class="navigation-header"><span>Quiz</span> <i class="icon-menu" title="Main pages"></i></li>
            <li><a href="{{route('quiz.index')}}"><img src="{{asset('img/web_ic_quiz.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Quiz</span></a></li>
            <li><a href="{{route('uji-kemampuan.index')}}"><img src="{{asset('img/web_ic_quiz.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Uji Kemampuan</span></a></li>
            <li class="navigation-header"><span>Master Data</span> <i class="icon-menu" title="Main pages"></i></li>
            <li><a href="{{route('user.index')}}"><img src="{{asset('img/web_ic_user.png')}}" alt="" style="height:20px;margin-right:15px"> <span>User</span></a></li>
            <li><a href="{{route('lpk.index')}}"><img src="{{asset('img/web_ic_user.png')}}" alt="" style="height:20px;margin-right:15px"> <span>LPK</span></a></li>
            <li><a href="{{route('instructor.index')}}"><img src="{{asset('img/web_ic_user.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Instructor</span></a></li>
            <li><a href="{{route('quizcategory.index')}}"><img src="{{asset('img/web_ic_category.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Category</span></a></li>
            <li><a href="{{route('quiztype.index')}}"><img src="{{asset('img/web_ic_type.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Type</span></a></li>
            <li><a href="{{route('payment-method.index')}}"><img src="{{asset('img/web_ic_type.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Payment Method</span></a></li>
            <li class="navigation-header"><span>System</span> <i class="icon-menu" title="Main pages"></i></li>
            <li><a href="{{route('banner.index')}}"><img src="{{asset('img/web_ic_banner.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Banner</span></a></li>
            <li><a href="{{route('version.index')}}"><img src="{{asset('img/web_ic_version.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Version</span></a></li>
            <!-- /main -->
            @endif

            @if(Auth::user()->hasAnyRole('Admin LPK'))
                        <!-- Main -->
            <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
            <li><a href="{{url('admin/user-package')}}"><img src="{{asset('img/web_ic_home.png')}}" alt="" style="height:20px;margin-right:15px"><span>User dan Paket</span></a></li>
            <li><a href="{{route('transaction.index')}}"><img src="{{asset('img/web_ic_home.png')}}" alt="" style="height:20px;margin-right:15px"><span>Transaction</span></a></li>
            <!-- <li><a href="{{url('admin/history')}}"><img src="{{asset('img/web_ic_home.png')}}" alt="" style="height:20px;margin-right:15px"><span>History</span></a></li> -->
            <li class="navigation-header"><span>Master Data</span> <i class="icon-menu" title="Main pages"></i></li>
            <!-- <li><a href="{{route('user.index')}}"><img src="{{asset('img/web_ic_user.png')}}" alt="" style="height:20px;margin-right:15px"> <span>User</span></a></li> -->
            <li><a href="{{route('quizcategory.index')}}"><img src="{{asset('img/web_ic_category.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Category</span></a></li>
            <li><a href="{{route('quiztype.index')}}"><img src="{{asset('img/web_ic_type.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Type</span></a></li>
            <li><a href="{{route('quiz.index')}}"><img src="{{asset('img/web_ic_quiz.png')}}" alt="" style="height:20px;margin-right:15px"> <span>Quiz</span></a></li>
            <!-- /main -->
            @endif


        </ul>
    </div>
</div>
