<!DOCTYPE html>

<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/persian_date_picker/persianDatepicker-default.css') }}"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-rtl_4.0.css') }}" rel="stylesheet">
    <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
@yield('style')

<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body @yield('body-changes')>
<div>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">

        <a class="navbar-brand active " href="{{ url('/home') }}">پارک علم و فناوری دانشگاه سمنان
            <img class="img-fluid" src="{{ asset('img/logo-s.png') }}" >
        </a>
        {{--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>--}}
        @if(Auth::check())
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <div class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="{{url('/home')}}">صفحه اصلی </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('/assigns')}}">بودجه </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('/select_year')}}">هزینه </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('/companies')}}">واحد های فناور</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('/reports')}}">گزارش</a></li>
                    {{--  <li class="nav-item dropdown">
                          <a href="{{url('/reports')}}" class="nav-link dropdown-toggle"
                             data-toggle="dropdown">گزارشگیری</a>
                          <div class="dropdown-menu " aria-labelledby="navbarDropdown" style="width: 400px;">

                          </div>
                      </li>--}}
                </div>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ url('/users/changePassword') }}">تغییر کلمه
                                عبور</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('خروج') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>


                </ul>
            </div>
        @endif

    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>




@include('sweetalert::alert')


<script src="{{ asset('js/jquery.js') }}"></script>
@yield('bottom_script')
<script>
    $(function () {
        $('.DatePicker').persianDatepicker({

            calendar: {
                persian: {
                    locale: 'en'
                }
            },
            initialValueType: 'persian',
            format: 'YYYY/MM/DD',
            autoClose: true,
            initialValue:false,
        });
        $("#give_date_picker").pDatepicker({

            calendar: {
                persian: {
                    locale: 'en'
                }
            },
            initialValueType: 'persian',
            format: 'YYYY/MM/DD',
            autoClose: true,
            initialValue:false,
        });
        $("#start_date_picker").pDatepicker({

            calendar: {
                persian: {
                    locale: 'en'
                }
            },
            initialValueType: 'persian',
            format: 'YYYY/MM/DD',
            autoClose: true,
            initialValue:false,
        });
        /*     $(document).on('keyup', '.numberformat', function (e) {
         e.preventDefault();
         var input=$(this).val();
         var nStr = input.value + '';
         nStr = nStr.replace( /\,/g, "");
         var x = nStr.split( '.' );
         var x1 = x[0];
         var x2 = x.length > 1 ? '.' + x[1] : '';
         var rgx = /(\d+)(\d{3})/;
         while ( rgx.test(x1) ) {
         x1 = x1.replace( rgx, '$1' + ',' + '$2' );
         }
         x= x1 + x2;
         console.log(x);



         $(this).val(x);

         });*/

    });
</script>
</body>

</html>
