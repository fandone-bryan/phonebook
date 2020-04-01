@extends('layout.template')

@section('content')
<main class="page-container">
    <header class="page-header">
        <span class="default-color">
            @if (empty($user))
            Cadastro de usuário
            @else
            Editar usuário
            @endif
        </span>
    </header>

    <form class="page-form" method="POST" action="{{ !empty($user) ? "/usuarios/{$user->id}/editar": '/users' }} ">
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
            <select class="form-control" required name="group_id">
                <option value="">Selecione um grupo</option>
                @foreach ($groups as $group)
                <option value="{{$group->id}}" {{!empty($user) && $user->group_id == $group->id ? "selected" : ""}}>
                    {{$group->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nome"
                value="{{!empty($user)? $user->name : old('name')}}" required>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="signup_email" placeholder="E-mail"
                value="{{!empty($user)? $user->email : old('signup_email')}}" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Senha" value="{{old('password')}}"
                {{ empty($user) ? "required" : ""}}>
            <small>{{ !empty($user) ?"Deixe o campo de senha vazio, caso não deseje alterar a senha!" : ""}}</small>
        </div>
        <input type="hidden" name="occupation" value="user">
        {{ csrf_field() }}
        @if (!empty($user))
        {{ method_field('PUT') }}
        @endif
        <button type="submit" class="btn btn-info mr-2">
            @if (empty($user))
            Cadastrar
            @else
            Editar
            @endif
        </button>
        <button type="button" class="btn btn-light" onclick="window.location='{{ url('/usuarios') }}'">Voltar</button>
    </form>
</main>
@endsection