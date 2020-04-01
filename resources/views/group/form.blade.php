@extends('layout.template')

@section('content')
<main class="page-container">
    <header class="page-header">
        <span class="default-color">
            @if (empty($group))
            Cadastro de grupo
            @else
            Editar grupo
            @endif
        </span>
    </header>

    <form class="page-form" method="POST" action="{{ !empty($group) ? "/grupos/{$group->id}": '/grupos' }} ">
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
            <input type="text" class="form-control" name="name" placeholder="Nome"
                value="{{!empty($group)? $group->name : old('name')}}" required>
        </div>
        </div>
        <input type="hidden" name="occupation" value="user">
        {{ csrf_field() }}
        @if (!empty($group))
        {{ method_field('PUT') }}
        @endif
        <button type="submit" class="btn btn-info mr-2">
            @if (empty($group))
            Cadastrar
            @else
            Editar
            @endif
        </button>
        <button type="button" class="btn btn-light" onclick="window.location='{{ url('/grupos') }}'">Voltar</button>
    </form>
</main>
@endsection