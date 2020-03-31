@extends('layout.template')

@section('content')
<main class="page-container">
  <header class="page-header">
    <span class="default-color">Alterar senha</span>
  </header>

  <form class="page-form" method="POST" action="/usuarios/{{ Session::get('user.id') }}/editar">
    <span class="default-color-dark mb-5">Informe os dados</span>
    @if (isset($success))
    <div class="alert alert-info">
      Senha altera com sucesso!
    </div>
    @endif
    @if ($errors->any())
    <div class="warning">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="form-group">
      <input type="password" class="form-control" name="old_password" placeholder="Senha antiga"required>
    </div>
    <div class="form-group">
      <input type="password" class="form-control" name="new_password" placeholder="Nova senha" required>
    </div>
    <div class="form-group">
      <input type="password" class="form-control" name="re_new_password" placeholder="Repetir nova senha" required>
    </div>
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <button type="submit" class="btn btn-info mr-2">Alterar</button>
    <button type="button" class="btn btn-light" onclick="window.location='{{ url('/') }}'">Voltar</button>
  </form>
</main>
@endsection