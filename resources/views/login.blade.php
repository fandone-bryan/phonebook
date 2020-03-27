@extends('layout.app')

@section('content')
<main id="login-page">
  <div class="login-container">
    <div class="login-tabs">
      <button onclick="openTab(event, 'login-signin')" class="tab-link active">Entrar</button>
      <button onclick="openTab(event, 'login-signup')" class="tab-link">Cadastre-se</button>
    </div>
    <!-- SignIn -->
    <div id="login-signin" class="tab-content">
      <div class="login-header">
        Digite seu dados de acesso
      </div>
      <div class="login-content">
        <input type="email" name="email" placeholder="E-mail">

        <input type="password" name="password" placeholder="Senha">
        <button type="submit">Entrar</button>
      </div>
    </div>
    <!------------>

    <!-- SignUp -->
    <div id="login-signup" class="tab-content" style="display:none">
      <div class="login-header">
        Informe seu dados para cadastro
      </div>
      <div class="login-content">
        <input type="text" name="name" placeholder="Nome">

        <input type="email" name="email" placeholder="E-mail">

        <input type="password" name="password" placeholder="Senha">
        <button type="submit">Cadastrar</button>
      </div>
    </div>
    <!------------>
  </div>
</main>
@endsection