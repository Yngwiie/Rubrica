<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        
        <!-- Styles -->
        
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"> 
        <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet"> <!--Totally optional :) -->
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
        @livewireStyles
        <!-- <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css"> -->
        <link rel="stylesheet" href="{{ asset('css/styles-sidebar.css') }}">
        

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ asset('js/scripts-sidebar.js') }}" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.scss') }}">
        <link rel="stylesheet" href="{{ asset('css/bd-wizard.css') }}">

    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="{{route('dashboard')}}"><span class="text-2xl font-extrabold pl-2 text-gray-300"><span class="text-2xl font-extrabold pl-2 text-white">Rubric</span>App</span></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{route('profile.show')}}"><i class="fas fa-id-card"></i> Perfil</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt"></i>{{ __(' Cerrar Sesión') }}
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Principal</div>
                                <a class="nav-link" href="{{route('dashboard')}}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                    Módulos
                                </a>
                                <a class="nav-link" href="{{route('misrubricas')}}">
                                    <div class="sb-nav-link-icon"><i class="far fa-list-alt"></i></div>
                                    Mis Rúbricas
                                </a>
                                <a class="nav-link" href="#2">
                                    <div class="sb-nav-link-icon"><i class="far fa-list-alt"></i></div>
                                    Rúbricas asociadas
                                </a>
                                <a class="nav-link" href="{{route('rubric.index')}}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                                    Constructor de Rúbricas
                                </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        {{$slot}}
                    </div>
                </main>
            </div>
        </div>

        @stack('modals')

        @livewireScripts

        <script>
            window.Livewire.on('moduloAgregado',()=>{
                $('#addModulo').modal('hide');
                $('#editModulo').modal('hide'); 
            })
            window.Livewire.on('moduloEliminado',()=>{
                $('#deleteModulo').modal('hide');
            })
            window.Livewire.on('evaluacionAgregada',()=>{
                $('#addEvaluacion').modal('hide');
            })
            window.Livewire.on('evaluacionEliminada',()=>{
                $('#deleteEvaluacion').modal('hide');
            })
            window.Livewire.on('evaluacionEditada',()=>{
                $('#editEvaluacion').modal('hide');
            })
            
            window.Livewire.on('rubricaEliminada',()=>{
                $('#deleteRubrica').modal('hide');
            })
        </script>

        <script>
            /*Toggle dropdown list*/
            function toggleDD(myDropMenu) {
                document.getElementById(myDropMenu).classList.toggle("invisible");
            }
            /*Filter dropdown options*/
            function filterDD(myDropMenu, myDropMenuSearch) {
                var input, filter, ul, li, a, i;
                input = document.getElementById(myDropMenuSearch);
                filter = input.value.toUpperCase();
                div = document.getElementById(myDropMenu);
                a = div.getElementsByTagName("a");
                for (i = 0; i < a.length; i++) {
                    if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    } else {
                        a[i].style.display = "none";
                    }
                }
            }
            // Close the dropdown menu if the user clicks outside of it
            window.onclick = function(event) {
                if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
                    var dropdowns = document.getElementsByClassName("dropdownlist");
                    for (var i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (!openDropdown.classList.contains('invisible')) {
                            openDropdown.classList.add('invisible');
                        }
                    }
                }
            }
        </script>
        <script>
            $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
            });
        </script>


</body>

<script src="{{ asset('js/jquery.steps.min.js') }}"></script>
<script src="{{ asset('js/bd-wizard.js') }}"></script>

</html>
