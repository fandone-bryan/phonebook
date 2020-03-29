@extends('layout.template')

@section('content')

<main class="page-container">
    <header class="page-header">
        <span class="default-color">Clientes</span>
        <button class="btn btn-info"><i class="fas fa-plus"></i>&nbsp;Adicionar cliente</button>
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
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td class="text-center"><img src="/phone.png" style="width:28px"></td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td class="text-center"><img src="/phone.png" style="width:28px"></td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td class="text-center"><img src="/phone.png" style="width:28px"></td>
            </tr>
        </tbody>
    </table>
</main>
@endsection