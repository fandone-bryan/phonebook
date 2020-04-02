function openPhoneModal(id, name) {
  $("#phone-modal-title").html(name)
  $("#phone-customer-id").val(id)

  loadPhoneNumbers(id)

  $("#phone-message").hide()
  $("#phoneModal").modal()
}

function phoneEdit(id, number) {
  var html = `
    <form class="d-flex" onsubmit="return phoneUpdate(event, ${id})">
      <input type="text" class="form-control mr-1"
       onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" minlength="8" maxlength="11" 
       id="phone-edit-number" value="${number}" style="height:25px">
      <button type="submit" class="btn btn-info" style="height: 25px;
      width: 25px;
      display: flex;
      justify-content: center;"><i class="fas fa-check"></i></botton>
    </form>
  `

  $(`#phone-edit-${id}`).html(html);
}

function phoneUpdate(event, id) {
  $("#phone-message-warning").hide()
  $("#phone-message").hide()

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
    },
    complete: function (xhr, textStatus) {
      if (xhr.status == 403) {
        $("#phone-message-warning").html('Você não possui permissão para alterar telefone!')
        $("#phone-message-warning").show()
      }
    }
  });


}

function phoneStore(event) {
  $("#phone-message-warning").hide()
  $("#phone-message").hide()

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

  $.ajax("/telefones", {
    type: "POST",
    data: data,
    success: function (data, textStatus, xhr) {
      loadPhoneNumbers($("#phone-customer-id").val())
      $("#phone-message").html('Número cadastrado com sucesso!')
      $("#phone-message").show()
      $("#phone-add-input").val('')
    },
    complete: function (xhr, textStatus) {
      if (xhr.status == 403) {
        $("#phone-message-warning").html('Você não possui permissão para cadastrar telefone!')
        $("#phone-message-warning").show()
      }
    }
  });

}

function phoneDelete(event, id) {
  $("#phone-message-warning").hide()
  $("#phone-message").hide()

  event.preventDefault();

  var data = {
    number: $("#phone-add-input").val(),
  };

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: `/telefones/${id}`,
    type: 'DELETE',
    success: function (result) {
      loadPhoneNumbers($("#phone-customer-id").val())
      $("#phone-message").html('Número excluído com sucesso!')
      $("#phone-message").show()
    },
    complete: function (xhr, textStatus) {
      if (xhr.status == 403) {
        $("#phone-message-warning").html('Você não possui permissão para excluir telefone!')
        $("#phone-message-warning").show()
      }
    }
  });
}

function loadPhoneNumbers(id) {
  $("#phonenumber-list").html('')
  $("#phone-message-warning").hide()
  $.ajax(`/clientes/${id}/telefones`, {
    success: function (numbers) {

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
            <form onsubmit="phoneDelete(event, ${number.id})">
              <button type="submit" class="btn-img">
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
    },
    complete: function (xhr, textStatus) {
      if (xhr.status == 403) {
        $("#phone-message-warning").html('Você não possui permissão para ver os telefones!')
        $("#phone-message-warning").show()
      }
    }
  });

}