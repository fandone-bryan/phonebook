@extends('layout.template')

@section('content')

<main class="page-container">
    <header class="page-header">
        <span class="default-color">Clientes</span>
        <a href="/clientes/criar" class="btn btn-info"><i class="fas fa-plus"></i>&nbsp;Adicionar cliente</a>
    </header>
    <table class="table">
        <thead class="default-background text-white">
            <tr>
                <th scope="col" class="w-15">#</th>
                <th scope="col" class="w-30">Nome</th>
                <th scope="col" class="w-35">E-mail</th>
                <th scope="col" class="text-center w-20">Telefone(s)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr>
                <th scope="row">{{ $customer->id }}</th>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td class="text-center"><img src="/phone.png" style="width:28px"></td>
            </tr>
            @endforeach            
        </tbody>
    </table>
</main>
@endsection