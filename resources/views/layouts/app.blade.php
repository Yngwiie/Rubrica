<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        @livewireScripts
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ asset('js/scripts-sidebar.js') }}" defer></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.scss') }}">
        <link rel="stylesheet" href="{{ asset('css/bd-wizard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pantallacarga.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
        <script src="{{ asset('js/jquery.doubleScroll.js') }}" defer></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.double-scroll').doubleScroll({resetOnWindowResize: true});
            });
        </script>
    </head>

    <body class="sb-nav-fixed">
        <div id="contenedor_carga" >
            <div id="carga"></div>
        </div> 
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
                                <a class="nav-link" href="{{route('rubric.index')}}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                                    Constructor de Rúbricas
                                </a>
                                <a class="nav-link" href="{{route('misrubricas')}}">
                                    <div class="sb-nav-link-icon"><i class="far fa-list-alt"></i></div>
                                    Mis Rúbricas
                                </a>
                                <a class="nav-link" href="{{route('rubricas.aplicadas')}}">
                                    <div class="sb-nav-link-icon"><i class="far fa-list-alt"></i></div>
                                    Rúbricas asociadas
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
        @stack('scripts')
        <livewire:scripts />
        @livewireChartsScripts

        <script>
            $( function() {
                $( document ).tooltip({
                position: {
                    my: "center bottom", 
                    at: "center top", 
                }
                });
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "6000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                }
            } );

            window.Livewire.on('show-modal-confirmation', ()=>{
                $('#modal-confirmation').modal('show');
            })
            window.Livewire.on('salvado',()=>{
                toastr.success('Rúbrica Guardada.');  
                $('.double-scroll').doubleScroll({resetOnWindowResize: true});
                /* window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000); */
            })
            window.Livewire.on('moduloAgregado',()=>{
                $('#addModulo').modal('hide');
                $('#editModulo').modal('hide'); 
            })
            window.Livewire.on('notaAplicada',()=>{
                toastr.success('Rúbrica Aplicada.');  
            })
            window.Livewire.on('aspectosNoAplicados',()=>{
                toastr.error('Todos los aspectos deben estar aplicados.');  
            })

            window.Livewire.on('modalAspectoAvanzadoClose', aspectoId=>{
                $('#aplicarAspecto'+aspectoId).modal('hide');  
            })

            window.Livewire.on('notaFinalAplicada',()=>{
                toastr.success('Rúbrica Aplicada');  
                $('#eleccionNota').modal('hide'); 
            })
            window.Livewire.on('eleccionNota',()=>{
                $('#eleccionNota').modal('show');  
            })
            
           
            window.Livewire.on('quitarLoadingSubcriteriosVacios',()=>{
                var contenedor = document.getElementById('contenedor_carga');

                contenedor.style.display = 'none';
                contenedor.style.opacity = '1';
                contenedor.style.visibility = 'hidden';
                contenedor.style.display = 'block'; 
                toastr.info('No hay subcriterios que agregar.');  
            })
            window.Livewire.on('quitarLoading',()=>{
                var contenedor = document.getElementById('contenedor_carga');

                contenedor.style.display = 'none';
                contenedor.style.opacity = '1';
                contenedor.style.visibility = 'hidden';
                contenedor.style.display = 'block'; 
            })
            window.Livewire.on('closeModalAspectosAvanzados',()=>{
                $('#addAspectoCriterios').modal('hide');  
            })
            window.Livewire.on('alertaNuevaVersion',()=>{
                var contenedor = document.getElementById('contenedor_carga');

                contenedor.style.display = 'none';
                contenedor.style.opacity = '1';
                $('#confirmarNewVersion').modal('show');
                contenedor.style.visibility = 'hidden';
                contenedor.style.display = 'block';
            })
            Livewire.on('closeConfirmPlantilla',()=>{
                $('#confirmPlantilla').modal('hide');
            })
            window.Livewire.on('pantallaCarga',()=>{
                var contenedor = document.getElementById('contenedor_carga');

                contenedor.style.visibility = 'visible';
                contenedor.style.opacity = '0.9';
            })
            window.Livewire.on('moduloEliminado',()=>{
                $('#deleteModulo').modal('hide');
            })
            window.Livewire.on('addScroll',()=>{
                $('.double-scroll').doubleScroll({resetOnWindowResize: true});
            })
            window.Livewire.on('evaluacionEliminada',()=>{
                $('#deleteEvaluacion').modal('hide');
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            })
            window.Livewire.on('evaluacionEditada',()=>{
                $('#editEvaluacion').modal('hide');
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            })
            
            window.Livewire.on('rubricaEliminada',()=>{
                $('#deleteRubrica').modal('hide');
            })
            window.Livewire.on('aspectoEliminado',()=>{
                $('#deleteAspecto').modal('hide');
            })
            window.Livewire.on('estudianteAgregado',()=>{
                $('#addEstudiante').modal('hide');
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            })
            window.Livewire.on('evaluacionAgregada',()=>{
                $('#addEvaluacion').modal('hide');
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            })
            window.Livewire.on('estudianteEliminado',()=>{
                $('#deleteEstudiante').modal('hide');
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            })
            window.Livewire.on('estudianteUpdate',()=>{
                $('#editEstudiante').modal('hide');
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            })
            window.Livewire.on('estudiantesImportados',()=>{
                $('#importEstudiantes').modal('hide');
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
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
        <script>
        window.onload = function(){
            var contenedor = document.getElementById('contenedor_carga');

            contenedor.style.visibility = 'hidden';
            contenedor.style.opacity = '0';
        }
        
        </script>
        

</body>

<script src="{{ asset('js/jquery.steps.min.js') }}"></script>
<script src="{{ asset('js/bd-wizard.js') }}"></script>


</html>
