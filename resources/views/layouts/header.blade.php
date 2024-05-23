<!DOCTYPE html>

<html lang="en">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cenntrum | Admin</title>
    <link href="{{asset('assets/dist/logo.png')}}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{asset('assets/dist/css/app.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="app">
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Admin" class="img-fluid" style="width:50px" src="{{asset('assets/dist/logo.png')}}">
                <span class="hidden xl:block text-white text-lg ml-3"> Cenntrum  </span>
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <ul class="border-t border-theme-24 py-5 hidden">
            <li>
                <a href="{{ route('dashboard') }}" class="menu <?php if($pagename=="
                dashboard")echo 'menu--active' ; ?>">
                    <div class="menu__icon"> <i data-feather="grid"></i> </div>
                    <div class="menu__title"> Dashboard </div>
                </a>
            </li>
             <li>
                <a href="{{ route('giftcards') }}" class="menu <?php if($pagename=="
                users")echo 'menu--active' ; ?>">
                    <div class="menu__icon"> <i data-feather="grid"></i> </div>
                    <div class="menu__title"> Gift Cards </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_logout') }}" class="menu">
                    <div class="menu__icon"> <i data-feather="grid"></i> </div>
                    <div class="menu__title"> Logout </div>
                </a>
            </li>
     
        </ul>
    </div>
    <!-- END: Mobile Menu -->
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Admin Template" class="img-fluid " style="width:20%;"
                    src="{{asset('assets/dist/logo.png')}}">
                <span class="hidden xl:block text-white text-lg ml-3">Cenntrum</span>
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="side-menu <?php if($pagename=='dashboard' || !isset($pagename))echo 'side-menu--active'; ?>">
                        <div class="side-menu__icon"> <i data-feather="grid"></i> </div>
                        <div class="side-menu__title"> Dashboard </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('giftcards') }}"
                        class="side-menu <?php if($pagename=='users' || !isset($pagename))echo 'side-menu--active'; ?>">
                        <div class="side-menu__icon"> <i data-feather="grid"></i> </div>
                        <div class="side-menu__title"> Gift Cards </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin_logout') }}"
                        class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="grid"></i> </div>
                        <div class="side-menu__title"> Logout </div>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            <!-- BEGIN: Top Bar -->
            <div class="top-bar">
                <!-- BEGIN: Breadcrumb -->
                <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">CMS</a> <i
                        data-feather="chevron-right" class="breadcrumb__icon"></i> <a href=""
                        class="breadcrumb--active">Dashboard</a> </div>
                <!-- END: Breadcrumb -->


                <!-- BEGIN: Account Menu -->
                {{-- <div class="intro-x dropdown w-8 h-8 relative">
                    <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
                        <img alt="Admin" src="{{asset('assets/dist/images/profile-2.jpg')}}">
                    </div>
                    <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                        <div class="dropdown-box__content box bg-theme-1 dark:bg-dark-6 text-white">
                            <div class="p-4 border-b border-theme">
                                <div class="font-medium">Admin</div>

                            </div>
                            <div class="p-2">
                                <!--<a href="profile.php" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>-->

                                <!--<a href="change-password.php" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>-->
                                <!--<a href="web-setting.php" class="flex items-center blok p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Settings </a>-->

                            </div>
                            <div class="">
                                <a href="{{route('admin_logout')}}"
                                    class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                    <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- END: Account Menu -->
            </div>
            @if(Session::has('login_message'))
            <div id="mydiv" class="rounded-md px-5 mt-2 lg:mx-20 py-4 mb-2 bg-theme-18 text-theme-9"><i
                    class="fa fa-check text-theme-9 mr-2"></i>Your Account has been <strong>Login Successfully!</strong>
            </div>
            @endif
            @if(Session::has('delete_message'))
            <div id="mydiv" class="rounded-md px-5 lg:mx-20 py-4 mb-2 mt-2 bg-theme-31 text-theme-6"><i
                    class="fa fa-times text-theme-6 mr-2"></i> Record has been Deleted <strong>Successfully!</strong>
            </div>
            @endif
            @if(Session::has('update_message'))
            <div id="mydiv" class="rounded-md mt-2 px-5 lg:mx-20 py-4 mb-2 bg-theme-17 text-theme-11"><i
                    class="fa fa-edit text-theme-11 mr-2"></i> Record has been Updated <strong>Successfully!</strong>
            </div>
            @endif
            @if(Session::has('add_message'))
            <div id="mydiv" class="rounded-md mt-2 px-5 lg:mx-20 py-4 mb-2 bg-theme-18 text-theme-9"><i
                    class="fa fa-check text-theme-9 mr-2"></i>New Record has been Added <strong>Successfully!</strong>
            </div>
            @endif
            @if(Session::has('error_message'))
            <div id="mydiv" class="rounded-md mt-2 px-5 lg:mx-20 py-4 mb-2 bg-theme-31 text-theme-6"><i
                    class="fa fa-exclamation-circle text-theme-6 mr-2"></i> Error Alert <strong>Something went
                    wrong!</strong></div>
            @endif
            @if(Session::has('error'))
            <div id="mydiv" class="rounded-md mt-2 px-5 lg:mx-20 py-4 mb-2 bg-theme-31 text-theme-6"><i
                    class="fa fa-exclamation-circle text-theme-6 mr-2"></i>{{session('error')}}</strong></div>
            @endif

            <script>
                setTimeout(function () {

                    $('#mydiv').fadeOut('fast');
                }, 3000);

                function divout() {
                    $('#mydiv').fadeOut('fast');
                }
            </script>

            <!-- END: Top Bar -->
            <!-- Redeem model -->
<div class="modal" id="delete-modal-redeem">
    <div class="modal__content">
       <div class="p-5 text-center">
           <h1>Redeem Gift Card</h1>
            </div>
        <div class="px-5 pb-8">
            <form type="submit" action="{{ route('redeem') }}" method="post">
                @csrf
                @method('POST')
                <input type="hidden" name="business_id" id="deleting_id" value="">
                <div class="intro-y col-span-12 sm:col-span-12 px-2 mb-3">
                        <div class="mb-2">Enter Gift Card Code</div>
                        <input type="text" name="code" class="input w-full border flex-1"
                            placeholder="Enter Code..." required>
                      
                    </div>
                     <div class="p-5 text-center">
            
       
                <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                <button type="submit" class="button w-24 bg-theme-3 text-white p-3 pl-5 pr-5">Redeem</button>
                 </div>
            </form>
        </div>
    </div>
</div>