<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>PHP PRG</title>
</head>

<body>
    <main id='main'>
            <button id='buttonSample' type="submit">Donate</button>
    </main>

</body>
<script>
  document.getElementById('buttonSample').addEventListener('click',function(e){
      createModal('fuckyou');
  });

function createModal(text){
   modalBody =  document.createElement('div');
   modalMessage = document.createElement('h4');
   modalMessage.textContent = text;
   modalConfirm = document.createElement('input');
   modalConfirm.type ='button';
   modalConfirm.value = "Confirm";
   modalCancel = document.createElement('input');
   modalCancel.type='button';
   modalCancel.value = "Cancel";
   modalBody.appendChild(modalMessage);
   modalBody.appendChild(modalConfirm);
   modalBody.appendChild(modalCancel);

document.body.appendChild(modalBody);
}


</script>
</html>