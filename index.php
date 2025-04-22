<?php
session_start();
if (isset($_SESSION['S_ID'])) {
    header('Location: view/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plantilla/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plantilla/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="plantilla/dist/css/adminlte.min.css">
  <link rel="icon" href="img/incoca.png" type="image/jpg">
  <style>
    body {
      background-image: url('img/img1.jpg');
      background-size: cover;
      background-position: center;
      position: relative;
    }
    .overlay {
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background-color: rgba(255, 100, 100, 0.5);
      z-index: 0;
    }
    .title-container {
      position: absolute;
      top: 5%;
      width: 100%;
      text-align: center;
      z-index: 1;
    }
    .title-container h1 {
      color: white;
      font-family: 'Georgia', serif;
      font-size: clamp(28px, 4vw, 58px);
      letter-spacing: 0.1em;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
      margin-bottom: 10px;
    }
    .title-container h2 {
      color: white;
      font-family: 'Garamond', serif;
      font-size: clamp(16px, 2vw, 32px);
      font-style: italic;
      letter-spacing: 0.05em;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
    }

    .btn:hover {
      background-color: #002b6e !important;
      color: white !important;
    }

    input[type="checkbox"]:checked {
      background-color: #023D77;
      border-color: #023D77;
    }

    .input-group .form-control:focus {
      border-color: #80bdff;
      box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
      z-index: 1;
    }

    .input-group-text {
      border-color: #ced4da;
    }

    footer {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      text-align: center;
      padding: 10px 0;
      font-family: 'Georgia', serif;
      font-size: 14px;
      color: white;
      letter-spacing: 0.5px;
      border-top: 2px solid rgba(255, 255, 255, 0.5);
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    @media (max-width: 768px) {
      .title-container h1 {
        font-size: 6vw;
      }
      .title-container h2 {
        font-size: 4vw;
      }
    }
    @media (max-width: 480px) {
      .title-container h1 {
        font-size: 7vw;
      }
      .title-container h2 {
        font-size: 5vw;
      }
    }
  </style>
</head>
<body class="hold-transition login-page">
  <div class="overlay"></div>

  <!-- Títulos -->
  <div class="title-container">
    <h1><b>Empresa de Saneamiento de Títulos de Propiedad INCOCAT S.R.L.</b></h1>
    <h2><b>"SISTEMA WEB DE SANEAMIENTO DE TÍTULOS DE PROPIEDAD"</b></h2>
  </div>

  <!-- Login -->
  <div class="login-box" style="z-index: 2; position: relative;">
    <div class="card" style="border-radius: 15px;">
      <div class="card-body login-card-body" style="border-radius: 15px;">
        <img src="img/incocat.png" alt="" width="100%" height="100%">
        <p class="login-box-msg" style="font-family:Arial black; font-size:15px; color:black">
          <b>DATOS DEL USUARIO</b>
        </p>

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Ingrese su usuario" id="txt_usuario" 
                 style="border-radius: 8px 0 0 8px; height: 38px; border-right: none;">
          <div class="input-group-append">
            <div class="input-group-text" style="background: #fff; border-radius: 0 8px 8px 0; height: 38px; border-left: none;">
              <span class="fas fa-user" style="color: #666;"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Ingrese su contraseña" id="txt_contra" 
                 style="border-radius: 8px 0 0 8px; height: 38px; border-right: none;">
          <div class="input-group-append">
            <div class="input-group-text" style="background: #fff; height: 38px; border-left: none; border-right: none;">
              <span class="fas fa-lock" style="color: #666;"></span>
            </div>
            <div class="input-group-text" style="background: #fff; border-radius: 0 8px 8px 0; height: 38px; border-left: none;">
              <i class="fas fa-eye" id="togglePassword" style="color: #666; cursor: pointer;"></i>
            </div>
          </div>
        </div>

        <div class="row align-items-center">
          <div class="col-8 d-flex align-items-center">
            <div class="icheck-primary" style="color:#023D77;">
              <input type="checkbox" id="remember" style="accent-color: #023D77;">
              <label for="remember" style="color: #023D77;">Recuérdame</label>
            </div>
          </div>
          <div class="col-12 mt-2">
            <button class="btn btn-block" id="entrar" onclick="Iniciar_Sesion()" 
                    style="border-radius: 15px; background-color: #023D77; color: white;">
              <i class='fas fa-share-square ml-1 mr-1'></i>&nbsp;<b>Iniciar Sesión</b>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    Empresa de Saneamiento de Títulos de Propiedad INCOCAT S.R.L.
  </footer>

  <!-- Scripts -->
  <script src="plantilla/plugins/jquery/jquery.min.js"></script>
  <script src="plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plantilla/dist/js/adminlte.min.js"></script>
  <script src="js/console_usuario.js?rev=<?php echo time(); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const rmcheck = document.getElementById('remember'),
          usuarioInput = document.getElementById('txt_usuario'),
          passInput = document.getElementById('txt_contra'),
          togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function () {
      const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passInput.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
    });

    if (localStorage.checkbox && localStorage.checkbox !== "") {
      rmcheck.setAttribute("checked", "checked");
      usuarioInput.value = localStorage.usuario;
      passInput.value = localStorage.pass;
    } else {
      rmcheck.removeAttribute("checked");
      usuarioInput.value = "";
      passInput.value = "";
    }

    usuarioInput.focus();
    passInput.addEventListener("keyup", function(event) {
      if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("entrar").click();
      }
    });
  </script>
</body>
</html>
