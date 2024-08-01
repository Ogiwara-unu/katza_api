<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
            <!--Css de terceros-->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" integrity="sha512-UuQ/zJlbMVAw/UU8vVBhnI4op+/tFOpQZVT+FormmIEhRSCnJWyHiBbEVgM4Uztsht41f3FzVWgLuwzUqOObKw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="container bg-ligth justify-content-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header text-center">
                        <h1>Aplicación web dinámica SPA</h1>
                        <h5>Vistas por componentes</h5>
                    </div>
                    <div class="col-12">
                      
                        <!--SEGMENTO DE DOS COLUMNAS-->
                        <div class="row">
                            <div class="col-3 sidebar-expanded d-none d-md-block" id="sidebar-container">
                                <ul class="list-group">
                                    <li class="list-group-item sidebar-separatio-title text-muted d-flex align-items-center menu-collapsed">
                                       <small>Modulo</small> 
                                    </li>
                                    <a id="mn-departamento" class="bg-dark text-light list-group-item list-group-item-action">
                                        <span class="fa-solid fa-graduation-cap"></span>
                                        <span>departamento</span>
                                        <span class="sbmenu-icon ml-auto"></span>
                                    </a>
                                    <a id="mn-professors" class="bg-dark text-light list-group-item list-group-item-action">
                                        <span class="fa-solid fa-graduation-cap"></span>
                                        <span>Profesores</span>
                                        <span class="sbmenu-icon ml-auto"></span>
                                    </a>
                                    <a id="mn-courses" class="bg-dark text-light list-group-item list-group-item-action">
                                        <span class="fa-solid fa-graduation-cap"></span>
                                        <span>Cursos</span>
                                        <span class="sbmenu-icon ml-auto"></span>
                                    </a>
                                    <li class="list-group-item sidebar-separatio-title text-muted d-flex align-items-center menu-collapsed">
                                    <small>Administracion</small> 
                                     </li>
                                     <a id="mn-users" class="bg-dark text-light list-group-item list-group-item-action">
                                        <span class="fa-solid fa-graduation-cap"></span>
                                        <span>Usuarios</span>
                                        <span class="sbmenu-icon ml-auto"></span>
                                </a>
                                </ul>
                            </div>
                                <div id="main-container" class="col-9">
    
                                </div>
                            </div>
                            <!--FIN DEL SEGMENTO DE DOS COLUMNAS-->
                        <!--FOOTER-->
                        <div class="footer text-center well bg-secondary">
                            <p>Todos los derechos reservados&copy:2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Scripts de terceros-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!--Script propios-->
        <script src=".../resource/js/router.js"></script>


</body>

</html>