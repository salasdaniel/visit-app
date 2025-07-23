<?php
require '../../config/user_validation.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="img/favicon.png" rel="shortcut icon">
  <title>Inicio de Sesion | PROPOOL </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="../../../js/qrCode.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body>
  <div class="justify-content-center" style="height: 100vh; display:flex; align-items: center; background-color: #f8f8f8;">
    <div class="col-sm-4 p-3">
      <h5 class="text-center">Escanear codigo QR</h5>
      <div class="row text-center">
        <a id="btn-scan-qr" href="#">
          <img src="https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg" class="img-fluid text-center" width="175">
        <a/>
        <canvas hidden="" id="qr-canvas" class="img-fluid"></canvas>
        </div>
        <div class="row mx-5 my-3">
        <button class="btn btn-success btn-sm rounded-3 mb-2" onclick="encenderCamara()">Encender camara</button>
        <button class="btn btn-danger btn-sm rounded-3" onclick="cerrarCamara()">Detener camara</button>
        <!-- <form action="guardar_respuesta.php" method="post">
            <input type="text" id='respuesta' name="respuesta" value = 'hola'>
            <button type="submit" id='enviar_respuesta'>enviar</button>
        </form> -->
      </div>
    </div>
  </div>

</body>
</html>

<script>
//crea elemento
const video = document.createElement("video");

//nuestro camvas
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

//div donde llegara nuestro canvas
const btnScanQR = document.getElementById("btn-scan-qr");

//lectura desactivada
let scanning = false;

//funcion para encender la camara
const encenderCamara = () => {
  navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function (stream) {
      scanning = true;
      btnScanQR.hidden = true;
      canvasElement.hidden = false;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
      video.srcObject = stream;
      video.play();
      tick();
      scan();
    });
};

//funciones para levantar las funiones de encendido de la camara
function tick() {
  canvasElement.height = video.videoHeight;
  canvasElement.width = video.videoWidth;
  canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

  scanning && requestAnimationFrame(tick);
}

function scan() {
  try {
    qrcode.decode();
  } catch (e) {
    setTimeout(scan, 300);
  }
}

//apagara la camara
const cerrarCamara = () => {
  video.srcObject.getTracks().forEach((track) => {
    track.stop();
  });
  canvasElement.hidden = true;
  btnScanQR.hidden = false;
};

const activarSonido = () => {
  var audio = document.getElementById('audioScaner');
  audio.play();
}


qr = 'https://qrco.de/propool';

qrcode.callback = (respuesta) => {
  if (respuesta) {
    
    if (respuesta === qr){
       
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Entrada marcada con exito',
        showConfirmButton: false,
        timer: 1500
      })
      setTimeout(function(){
        window.location.href = 'vista_vendedor.php'
      },1500)
      
    }else {

      Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'codigo QR incorrecto',
        showConfirmButton: false,
        timer: 1500
      })
      cerrarCamara();
      return;

    }
    
    

    cerrarCamara();
  }
};
//evento para mostrar la camara sin el boton 
window.addEventListener('load', (e) => {
  encenderCamara();
})


</script>





