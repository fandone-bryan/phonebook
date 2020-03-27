@extends('layout.app')

@section('content')
<main id="login-page">
  <div class="login-container">
    <?php
    $form = 'signin';
    if (Session::get('form') == 'signup') {
      $form = 'signup';
    }
    ?>
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
      <div class="login-content">
        <form>
          <input type="email" name="email" placeholder="E-mail">

          <input type="password" name="password" placeholder="Senha">
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
      @if ($errors->any())
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
          <input type="text" name="name" placeholder="Nome" required>

          <input type="email" name="email" placeholder="E-mail" required>

          <input type="password" name="password" placeholder="Senha" required>
          <input type="hidden" name="occupation" value="admin">
          <button type="submit">Cadastrar</button>
          {{ csrf_field() }}
        </form>
      </div>
    </div>
    <!------------>
  </div>
</main>
<?php Session::forget('form');?>
@endsection