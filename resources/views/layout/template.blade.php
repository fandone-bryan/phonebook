<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="/logo.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/default.css">
    <link rel="stylesheet" href="/css/template.css">

    <title>PhoneBook</title>
</head>

<body>
    <div class="navbar-container">
        <nav class="navbar navbar-dark navbar-expand-md">
            <div class="navbar-left">
                <a class="navbar-brand" href="/">
                    <img class="navbar-logo" src="/logo.png">
                    PhoneBook
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse navbar-right" id="navbarNav">
                <div class="nav-links">
                    <ul class="navbar-nav">
                        <?php $pagina = explode('/',Request::route()->uri)[0]; ?>
                        
                        <li class="nav-item <?= $pagina == '' || $pagina == 'clientes' ? 'active' : ''?>">
                            <a class="nav-link" href="/">Clientes</a>
                        </li>
                        <li class="nav-item <?= $pagina == 'usuarios' ? 'active' : ''?>">
                            <a class="nav-link" href="#">Usuários</a>
                        </li>
                        <li class="nav-item <?= $pagina == 'grupos' ? 'active' : ''?>">
                            <a class="nav-link" href="#">Grupos</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-user">
                    <div class="dropdown">
                        <a class="dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><span>{{ Session::get('user.name') }}</span>&nbsp;<i
                                class="fas fa-user fa-fw"></i></a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">Alterar senha</a>
                            <a class="dropdown-item" href="#">Logs</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout">Sair</a>
                        </div>
                    </div>
                </div>

        </nav>
    </div>

    @yield('content')
    <script src="https://kit.fontawesome.com/e4bfd8d51e.js" crossorigin="anonymous"></script>
    <script src="/js/app.js"></script>
</body>

</html>