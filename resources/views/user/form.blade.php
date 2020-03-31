@extends('layout.template')

@section('content')
<main class="page-container">
    <header class="page-header">
        <span class="default-color">Cadastro de usuário</span>
    </header>

    <form class="page-form" method="POST" action="/users">
        <span class="default-color-dark mb-5">Informe os dados do usuário</span>
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
            <input type="email" class="form-control" name="signup_email" placeholder="E-mail" value="{{old('signup_email')}}"
                required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Senha" value="{{old('password')}}"
                required>
        </div>
        <input type="hidden" name="occupation" value="user">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-info mr-2">Cadastrar</button>
        <button type="button" class="btn btn-light" onclick="window.location='{{ url('/') }}'">Voltar</button>
    </form>
</main>
@endsection