function modal(text,func){
   modalBody = document.createElement('div');
          modalBody.className = 'modalConfirm shadow p-3 mb-5 bg-white rounded'
          modalMessage = document.createElement('h4');
          modalMessage.textContent = text;
          modalConfirm = document.createElement('input');
          modalConfirm.type = 'button';
          modalConfirm.value = "Ok";
          modalConfirm.className = "header-btn btn"
          modalCancel = document.createElement('input');
          modalBody.appendChild(modalMessage);
          modalBody.appendChild(modalConfirm);
          modalConfirm.addEventListener('click', function(e) {
              func();
              modalBody.remove();
          });
          document.body.appendChild(modalBody);
}