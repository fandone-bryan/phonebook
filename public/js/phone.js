function openPhoneModal(id, name) {
  $("#phone-modal-title").html(name)
  $("#phone-customer-id").val(id)
  
  loadPhoneNumbers(id)
  
  $("#phone-message").hide()
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
          <div class="d-flex align-items-center" style="display:flex;">
            <a class="d-flex" href='tel:+55${number.number}'>
              <img class="mr-3" style="height:20px" src="/img/phone-logo.png">
            </a>
            <a class="d-flex" target="_blank" href="https://api.whatsapp.com/send?phone=+55${number.number}&text=Ol%C3%A1%2C+boa+tarde">
              <img class="mr-1" style="height:24px" src="/img/whatsapp-logo.png">
            </a>     
          </div>
          <div id="phone-edit-${number.id}" class="phone-edit">
            <span>${number.number}</span>
          </div>  
          <div class="phone-actions">            
            <button class="btn-img mr-2" onclick="phoneEdit(${number.id},'${number.number}')">
              <img src="/img/edit-icon.png" style="width:23px">
            </button>
            <form>
            <button class="btn-img" onclick="">
              <img src="/img/delete-phone-icon.png">
            </button>
            </form>
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

function phoneEdit(id, number) {
  var html = `
    <form class="d-flex" onsubmit="return phoneUpdate(event, ${id})">
      <input type="text" class="form-control mr-1" minlength="8" id="phone-edit-number" value="${number}" style="height:25px">
      <button type="submit" class="btn btn-info" style="height: 25px;
      width: 25px;
      display: flex;
      justify-content: center;"><i class="fas fa-check"></i></botton>
    </form>
  `

  $(`#phone-edit-${id}`).html(html);
}

function phoneUpdate(event, id) {
  event.preventDefault();
  $("#phone-edit-number").val()

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    url: `/telefones/${id}`,
    type: 'PUT',
    data: `number=${$("#phone-edit-number").val()}`,
    success: function (result) {
      loadPhoneNumbers($("#phone-customer-id").val())
      $("#phone-message").html('Número atualizado com sucesso!')
      $("#phone-message").show()
    }
  });
  
}

function addPhone(event) {
  event.preventDefault();

  var data = {
    number: $("#phone-add-input").val(),
    customer_id: $("#phone-customer-id").val(),
  };

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.post("/telefones", data, function () {
    loadPhoneNumbers($("#phone-customer-id").val())
    $("#phone-add-input").val('')
  });

}