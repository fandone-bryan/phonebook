@extends('layout.template')

@section('content')

<main class="page-container">
    <header class="page-header">
        <span class="default-color">Logs</span>        
    </header>
    <div class="table-responsive-md">
        <table class="table">
            <thead class="default-background text-white">
                <tr>
                    <th scope="col" class="w-20 text-center">Data</th>
                    <th scope="col" class="text-center">Usuário</th>
                    <th scope="col">Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td class="text-center">{{ date('d/m/Y H:i:s', strtotime($log["created_at"])) }}</td>
                    <td class="text-center">{{ $log["user_name"] }}</td>
                    <td>{{ $log["description"] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

@endsection