@extends('layout.template')

@section('content')

<main class="page-container">
    <header class="page-header">
        <span class="default-color">Usuários</span>
        <a href="/usuarios/criar" class="btn btn-info"><i class="fas fa-plus"></i>&nbsp;Adicionar usuário</a>
    </header>
    @if (!empty(Session::get('message')))
    <div class="alert alert-info">
        {{ Session::get('message') }}
        <?php Session::forget('message'); ?>
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
    <div class="table-responsive-md">
        <table class="table">
            <thead class="default-background text-white">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Grupo</th>
                    <th scope="col" class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->group["name"] }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="/usuarios/{{$user->id}}/editar" class="mr-2">
                            <img src="/img/edit-icon.png" style="height:36px">
                        </a>
                        <form action="/usuarios/{{$user->id}}" method="POST">
                            <button type="submit" class="btn-img">
                                <img src="/img/delete-icon.png" style="height:36px">
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </td>
                </tr>
                @endforeach
                @if (empty($users->toArray()))
                <tr><td colspan="4" class="text-center">Não há usuários cadastrados.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</main>

@endsection