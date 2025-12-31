<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <style>
             .open{
        display: block;
    }
    .close{
        display: none;
    }
    .side{
       margin-left:380px;
    }
    
.breadcrumb {
    padding: 8px 15px;
    margin-bottom: 20px;
}
.header-breadcrumb{
    /* margin-top: 10px;
    padding: 10px 10px; */
     float: right;
    background: transparent;
    margin-top: 0;
    margin-bottom: 0;
    font-size: 12px;
    padding: 7px 5px;
    position: absolute;
    top: 15px;
    right: 10px;
    border-radius: 2px;
}
.breadcrumb>li {
    display: inline-block;
}
.breadcrumb>li>a {
    color: #444;
    text-decoration: none;
    display: inline-block;
}
.breadcrumb>.activee {
    color: #777;
}
.breadcrumb>li+li:before {
    content: '>\00a0';
        padding: 0 5px;
    color: #ccc;
}
.fa{
    margin-right: 5px;
}
        </style>
    </head>
   <body class="font-sans antialiased" style="background-size: cover; background-repeat: no-repeat; background-position: center; ">


        <x-banner />

  @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
               
                    <header class="" >
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" style="position: absolute; top:0px; left:40%; font-size: 2em;">
                          <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                              {{ $header }}
                          </h2>
                        </div>
                        <div class="header-breadcrumb">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="activee">{{ $header }}</li>
    </ol>
</div>
                    </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            $('#sidebtn').on('click', function (event) {
                event.preventDefault();
                // $('#sidebar').toggleClass('close open');

                const sidebarstatus = $('#sidebar').hasClass('close');
                console.log(sidebarstatus);
                if (sidebarstatus) {

                    $('#sidebar').removeClass('close');
                    $('#sidebar').addClass('open');
                    $('body').addClass('side');
                    $('#icon').removeClass('icon');

                    $('#icon').addClass('currency');



                }
                else {
                    $('#sidebar').removeClass('open');
                    $('body').removeClass('side');

                    $('#sidebar').addClass('close');
                    $('#icon').removeClass('currency');
                    $('#icon').addClass('icon');
                }


            });
           
        </script>
    </body>
</html>
