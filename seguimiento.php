<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Trámite INCOCAT</title>
    <link rel="stylesheet" href="plantilla/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plantilla/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="plantilla/dist/css/adminlte.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Añadimos Google Font: Poppins para un diseño más moderno -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3a86ff;
            --secondary-color: #8338ec;
            --accent-color: #ff006e;
            --light-bg: #f8f9fa;
            --dark-text: #343a40;
            --light-text: #f8f9fa;
            --success-color: #06d6a0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, sans-serif;
        }

        body {
            background-image: url('img/img3.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 16px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .logo img {
            max-width: 280px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }
        
        .logo img:hover {
            transform: scale(1.02);
        }

        .form-description {
            text-align: center;
            color: #555;
            font-size: 1rem;
            margin-bottom: 2.5rem;
            line-height: 1.5;
            font-weight: 300;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.7rem;
            font-weight: 500;
            color: var(--dark-text);
            font-size: 0.95rem;
        }

        select,
        input[type="text"] {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
            color: var(--dark-text);
        }
        
        select:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(58, 134, 255, 0.2);
            background-color: white;
        }
        
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23343a40' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
            padding-right: 2.5rem;
        }

        .btn {
            transition: all 0.3s ease;
        }
        
        .btn-success {
            background: linear-gradient(45deg, #06d6a0, #1b9aaa);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(6, 214, 160, 0.3);
        }
        
        .btn-success:hover {
            background: linear-gradient(45deg, #05c091, #1a8b9a);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(6, 214, 160, 0.4);
        }
        
        .btn-success:active {
            transform: translateY(1px);
        }
        
        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .search-icon {
            font-size: 1.1rem;
        }
        
        /* Efectos decorativos */
        .bg-shape {
            position: absolute;
            opacity: 0.05;
            z-index: -1;
        }
        
        .shape-1 {
            top: -10%;
            left: -10%;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: var(--accent-color);
        }
        
        .shape-2 {
            bottom: -15%;
            right: -15%;
            width: 250px;
            height: 250px;
            background: var(--primary-color);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-container {
                padding: 2rem 1.5rem;
                width: 90%;
            }
            
            .logo img {
                max-width: 220px;
            }
            
            .form-description {
                font-size: 0.9rem;
                margin-bottom: 2rem;
            }
            
            .btn-lg {
                padding: 0.9rem 1.5rem;
                font-size: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }
            
            .form-container {
                padding: 1.8rem 1.2rem;
                border-radius: 12px;
            }
            
            .logo img {
                max-width: 180px;
            }
            
            .form-group {
                margin-bottom: 1.5rem;
            }
            
            select, 
            input[type="text"] {
                padding: 0.7rem 0.8rem;
                font-size: 0.95rem;
            }
            
            .btn-lg {
                padding: 0.8rem 1.2rem;
                width: 100%;
            }
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-container {
            animation: fadeIn 0.6s ease forwards;
        }
        
        .form-group {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }
        
        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }
        .form-group:nth-child(3) { animation-delay: 0.4s; }
        
        .col-12 {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
            animation-delay: 0.5s;
        }
        
        /* Select2 customization */
        .select2-container .select2-selection--single {
            height: 45px !important;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px;
        }
    </style>
</head>

<body>
    <!-- Formas decorativas de fondo -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    
    <div class="form-container">
        <div class="logo">
            <img src="img/incocat.png" alt="INCOCAT Logo" class="img-fluid">
        </div>

        <p class="form-description">
            Realiza el seguimiento de tu trámite, conoce el contenido de un título presentado o haz seguimiento de tus pagos
        </p>

        <form method="POST" action="">
            <div class="form-group">
                <label><i class="fas fa-id-card mr-2" style="color: var(--primary-color);"></i>Tipo de Documento</label>
                <select name="tipo_documento" id="select_tipo_documento" required>
                    <option value="">Seleccione tipo</option>
                    <option value="DNI">DNI</option>
                    <option value="RUC">RUC</option>
                    <option value="CE">Carné de Extranjería</option>
                    <option value="PAS">Pasaporte</option>
                    <!-- Puedes agregar más tipos si quieres -->
                </select>
            </div>

            <div class="form-group">
                <label><i class="fas fa-fingerprint mr-2" style="color: var(--secondary-color);"></i>Número de Documento</label>
                <input type="text" name="numero_documento" id="txt_documento" placeholder="Ingrese su número de documento" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-file-alt mr-2" style="color: var(--accent-color);"></i>Número de Expediente</label>
                <input type="text" name="numero_expediente" id="txt_expediente" placeholder="Ingrese su número de expediente" required>
            </div>
            
            <div class="col-12" style="text-align:center">
                <button type="button" class="btn btn-success btn-lg" onclick="Buscar_expediente()" id="btn_registro">
                    <i class="fas fa-search search-icon"></i><b>Buscar expediente</b>
                </button>
            </div>
        </form>
    </div>
</body>

</html>
<script src="js/console_seguimiento.js?rev=<?php echo time(); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="plantilla/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="plantilla/dist/js/adminlte.min.js"></script>
<script>
    // Inicialización de Select2
    $(document).ready(function() {
        $('#select_tipo_documento').select2({
            placeholder: "Seleccione tipo de documento",
            width: '100%'
        });
    });
</script>