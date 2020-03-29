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
                <td class="text-center">
                    <button type="button" class="btn"
                        onclick="loadPhoneNumbers({{ $customer->id }}, '{{ $customer->name }}')">
                        <img src="/phone.png" style="width:28px">
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>

<!-- Modal -->
<div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="phone-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title default-color" id="phone-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="default-color-dark">Detalhes do contato</span>
                <div style="padding:20px 15px 0px 20px">
                    <div style="" class="d-flex">
                        <ul style="list-style: none;margin-bottom: 10px" class="w-100">
                            <li class="mb-2 d-flex align-items-center  justify-content-between">
                                <div class="d-flex align-items-center" style="width: 80%; display:flex;">
                                    <img class="mr-3" style="height:20px" src="/img/phone-logo.png">
                                    <img class="mr-4" style="height:24px" src="/img/whatsapp-logo.png">
                                    <span>13 981245120</span>
                                </div>
                                <div class="d-flex w-20 justify-content-end">
                                    <button class="btn-img mr-2" onclick="alert('oi')">
                                        <img src="/img/edit-icon.png" style="width:22px">
                                    </button>
                                    <button class="btn-img" onclick="alert('oi')">
                                        <img src="/img/delete-phone-icon.png">
                                    </button>
                                </div>
                            </li>
                            <li class="mb-2 d-flex align-items-center  justify-content-between">
                                <div class="d-flex align-items-center" style="width: 80%; display:flex;">
                                    <img class="mr-3" style="height:20px" src="/img/phone-logo.png">
                                    <img class="mr-4" style="height:24px" src="/img/whatsapp-logo.png">
                                    <span>13 981245120</span>
                                </div>
                                <button class="btn-img" onclick="alert('oi')">
                                    <img src="/img/delete-phone-icon.png">
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="phone-add">
                    <form onsubmit="return addPhone(event)">
                        <div class="form-group">
                            <div class="d-flex">
                                <input type="text" class="form-control mr-3" id="phone-add-input" placeholder="Novo número" required>
                                <button type="submit" class="btn btn-info d-flex">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection