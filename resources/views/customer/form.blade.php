@extends('layout.template')

@section('content')
<main class="page-container">
  <header class="page-header">
    <span class="default-color">Cadastro de cliente</span>
  </header>

  <form class="page-form" method="POST" action="/clientes">
    <span class="default-color-dark mb-5">Informe os dados do cliente</span>
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
      <input type="text" class="form-control" name="name" placeholder="Nome" value="{{old('name')}}" required>
    </div>
    <div class="form-group">
      <input type="email" class="form-control" name="email" placeholder="E-mail" value="{{old('email')}}" required>
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-info mr-2">Cadastrar</button>
    <button type="button" class="btn btn-light" onclick="window.location='{{ url('/') }}'">Voltar</button>
  </form>
</main>
@endsection