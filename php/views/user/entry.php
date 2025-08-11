<?php
require dirname(__DIR__, 2) . '/config/user_validation.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="img/favicon.png" rel="shortcut icon">
  <title> Entry | VisitApp</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="../../../js/qrCode.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body>
  <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="row w-100 justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg p-4" style="border-radius: 20px; background: rgba(255,255,255,0.95);">
          <div class="card-body">
      <h3 class="card-title text-center mb-4 font-weight-bold">
        <i class="fas fa-qrcode mr-2"></i>QR Code Scanner
      </h3>
            <div class="text-center mb-3">
              <a id="btn-scan-qr" href="#">
                <img src="https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg" alt="QR Icon" style="width: 70%;">
              </a>
              <canvas hidden id="qr-canvas" class="img-fluid" style="border-radius: 15px"></canvas>
            </div>
            <div class="d-flex justify-content-center gap-2 mb-2">
              <button class="btn btn-primary mr-2" style="border-radius: 25px; padding: 12px 24px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;" onclick="turnOn()">
                <i class="fas fa-camera"></i> Start</button>
              <button class="btn btn-secondary" style="border-radius: 25px; padding: 12px 24px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;" onclick="turnOff()">
                <i class="fas fa-stop-circle"></i> Stop</button>
            </div>
            <div class="text-center mt-3">
              <small class="text-muted">Scan the QR code to mark your entry.</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>

<script>
// Create video element
const video = document.createElement("video");

// Our canvas
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

// Div where our canvas will be displayed
const btnScanQR = document.getElementById("btn-scan-qr");

// Scanning state
let scanning = false;

// Function to start the camera (requests access every click)
const turnOn = () => {
  // If already scanning, stop previous stream before requesting again
  if (video.srcObject) {
    video.srcObject.getTracks().forEach((track) => track.stop());
    video.srcObject = null;
  }
  if (navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === 'function') {
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
      })
      .catch(function (err) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Camera access denied',
          text: 'Please allow camera access to scan QR codes.',
          showConfirmButton: true
        });
      });
  } else {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Camera not supported',
      text: 'Your browser does not support camera access required for QR scanning.',
      showConfirmButton: true
    });
  }
};

// Functions to handle camera activation
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

// Function to stop the camera
const turnOff = () => {
  video.srcObject.getTracks().forEach((track) => {
    track.stop();
  });
  canvasElement.hidden = true;
  btnScanQR.hidden = false;
};

const playSound = () => {
  var audio = document.getElementById('audioScaner');
  audio.play();
}

const qr = 'https://qrco.de/propool';

qrcode.callback = (response) => {
  if (response) {
    if (response === qr) {
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Entry marked successfully',
        showConfirmButton: false,
        timer: 1500
      });
      setTimeout(function () {
        window.location.href = 'advisor.php';
      }, 1500);
    } else {
      Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Incorrect QR code',
        text: 'Please try again with a valid QR code.',
        showConfirmButton: false,
        timer: 1500
      });
      turnOff();
      return;
    }
    turnOff();
  }
};
// Event to show the camera automatically
// window.addEventListener('load', (e) => {
//   turnOn();
// })

</script>





