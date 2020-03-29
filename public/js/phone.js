function openPhoneModal(id, name) {
  $("#phone-modal-title").html(name)
  $("#phone-add-customer-id").val(id)

  loadPhoneNumbers(id)

  $("#phoneModal").modal()
}

function loadPhoneNumbers(id) {
  $("#phonenumber-list").html('')
  $.getJSON(`/clientes/${id}/telefones`, function (numbers) {
    var html = ''
    if (numbers.length > 0) {
      for (var number of numbers) {
        html += `
        <li class="mb-2 d-flex align-items-center  justify-content-between">
          <div class="d-flex align-items-center" style="width: 80%; display:flex;">
            <img class="mr-3" style="height:20px" src="/img/phone-logo.png">
            <img class="mr-4" style="height:24px" src="/img/whatsapp-logo.png">
            <span>${number.number}</span>
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
        `
      }
    } else {
      html = '<span class="default-color-dark"> Não há telefones cadastrados</span>';
    }

    $("#phonenumber-list").html(html)
  });

}

function addPhone(event) {
  event.preventDefault();

  var data = {
    number: $("#phone-add-input").val(),
    customer_id: $("#phone-add-customer-id").val(),
  };

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.post("/telefones", data, function () {
    loadPhoneNumbers($("#phone-add-customer-id").val())
  });
  
}