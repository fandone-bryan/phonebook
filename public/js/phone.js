function loadPhoneNumbers(id, name) {
  $("#phone-modal-title").html(name)
  $("#phoneModal").modal()
}

function addPhone(event) {
  event.preventDefault();
  
  var number = $("#phone-add-input").val()
  
}