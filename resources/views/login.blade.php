<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="/logo.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/default.css">
    <link rel="stylesheet" href="/css/login.css">

    <title>PhoneBook</title>
</head>

<body>
    <main id="login-page">
        <div class="login-container">
            <?php $form = (Session::get('form') == 'signup') ? 'signup' : 'signin'; ?>
            <div class="login-tabs">
                <button class="tab-link <?= $form == 'signin' ? 'active' : ''?>"
                    onclick="openTab(event, 'login-signin')">Entrar</button>

                <button class="tab-link <?= $form == 'signup' ? 'active' : ''?>"
                    onclick="openTab(event, 'login-signup')">Cadastre-se</button>
            </div>

            <!-- SignIn -->
            <div id="login-signin" class="tab-content" style="display:<?= $form == 'signin' ? 'block' : 'none'?>">
                <div class="login-header">
                    Digite seu dados de acesso
                </div>
                @if (Session::get('form')=='signin')
                <div class="warning">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="login-content">
                    <form action="/auth" method="POST">
                        <input type="email" name="signin_email" placeholder="E-mail" value="{{ old('signin_email') }}">
                        <input type="password" name="password" placeholder="Senha">
                        {{ csrf_field() }}
                        <button type="submit">Entrar</button>
                    </form>
                </div>
            </div>
            <!------------>

            <!-- SignUp -->
            <div id="login-signup" class="tab-content" style="display:<?= $form == 'signup' ? 'block' : 'none'?>">
                <div class="login-header">
                    Informe seu dados para cadastro
                </div>
                @if (Session::get('form')=='signup')
                <div class="warning">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="login-content">
                    <form action="/users" method="POST">
                        <input type="text" name="name" placeholder="Nome" value="{{ old('name') }}" required>
                        <input type="email" name="signup_email" placeholder="E-mail" value="{{ old('signup_email') }}"
                            required>
                        <input type="password" name="password" placeholder="Senha" required>
                        <input type="hidden" name="occupation" value="admin">
                        {{ csrf_field() }}
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
            <!------------>
        </div>
    </main>

    <?php Session::forget('form'); ?>
    <script src="https://kit.fontawesome.com/e4bfd8d51e.js" crossorigin="anonymous"></script>
    <script src="/js/app.js"></script>
    <script src="/js/login.js"></script>
</body>

</html>