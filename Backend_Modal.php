function modal(text,func){
   modalBody = document.createElement('div');
          modalBody.className = 'modalConfirm shadow p-3 mb-5 bg-white rounded'
          modalMessage = document.createElement('h4');
          modalMessage.textContent = text;
          modalConfirm = document.createElement('input');
          modalConfirm.className = 'btn btn-primary';
          modalConfirm.type = 'button';
          modalConfirm.style= "font-size:15px; margin-left:45%;"
          modalConfirm.value = "Ok";

          modalCancel = document.createElement('input');
          modalBody.appendChild(modalMessage);
          modalBody.appendChild(modalConfirm);
          modalConfirm.addEventListener('click', function(e) {
              func();
              modalBody.remove();
          });
          document.body.appendChild(modalBody);
}