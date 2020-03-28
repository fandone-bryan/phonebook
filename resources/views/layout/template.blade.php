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
    <div style="background:#3f4a59">
        <nav class="navbar navbar-dark navbar-expand-md" style="width:100%; max-width:980px;margin: 0 auto;">
            <div class="navbar-left">
                <a class="navbar-brand" href="/">
                    <img src="/logo.png" style="height: 32px;" />
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
                        <?php $pagina = Request::route()->uri; ?>
                        <li class="nav-item <?= $pagina == '/' ? 'active' : ''?>">
                            <a class="nav-link" href="#">Clientes</a>
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
                            aria-haspopup="true" aria-expanded="false"><span>Bryan Alves</span>&nbsp;<i
                                class="fas fa-user fa-fw"></i></a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">Alterar senha</a>
                            <a class="dropdown-item" href="#">Logs</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="login.html">Sair</a>
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