<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Síguelo Plus - Plataforma Virtual Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-color: #4CAF50;
            --primary-gradient: linear-gradient(135deg, #4CAF50, #8BC34A);
            --secondary-color: #00BCD4;
            --secondary-gradient: linear-gradient(135deg, #00BCD4, #03A9F4);
            --accent-color: #FF5722;
            --dark-color: #263238;
            --light-color: #ECEFF1;
            --border-color: #CFD8DC;
            --card-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #F5F7FA;
            color: var(--dark-color);
            overflow-x: hidden;
        }

        .header {
            background: var(--dark-color);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 100;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
        }

        .header-links {
            display: flex;
            gap: 25px;
        }

        .header-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            position: relative;
            padding: 5px 0;
            transition: var(--transition);
        }

        .header-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-gradient);
            transition: var(--transition);
        }

        .header-links a:hover::after {
            width: 100%;
        }

        .header-links a.active {
            color: var(--primary-color);
        }

        .platform-name {
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
        }

        .platform-name span {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-left: 5px;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
            display: flex;
            gap: 30px;
        }

        .content-container {
            flex: 1;
        }

        .logos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .logo-sunarp {
            max-width: 200px;
            transition: var(--transition);
        }

        .logo-siguelo {
            max-width: 300px;
            transition: var(--transition);
        }

        .logo-sunarp:hover,
        .logo-siguelo:hover {
            transform: scale(1.05);
        }

        .welcome-banner {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-gradient);
        }

        .welcome-banner:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-5px);
        }

        .welcome-banner p {
            font-size: 16px;
            line-height: 1.6;
        }

        .welcome-banner span {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 700;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--dark-color);
            position: relative;
            padding-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .card-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-gradient);
            transition: var(--transition);
        }

        .card:hover .card-title::after {
            width: 100px;
        }

        .card-title i {
            margin-right: 10px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: var(--dark-color);
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: var(--transition);
            background-color: #FAFAFA;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
            background-color: white;
        }

        .form-group:hover label {
            color: var(--primary-color);
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            text-align: center;
            box-shadow: 0 4px 6px rgba(76, 175, 80, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 12px rgba(76, 175, 80, 0.4);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--secondary-gradient);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 188, 212, 0.3);
        }

        .btn-secondary:hover {
            box-shadow: 0 6px 12px rgba(0, 188, 212, 0.4);
            transform: translateY(-2px);
        }

        .status-container {
            background: var(--primary-gradient);
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 700;
            border-radius: 8px;
            margin: 30px 0;
            box-shadow: 0 4px 6px rgba(76, 175, 80, 0.3);
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .status-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(76, 175, 80, 0.4);
        }

        .status-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            animation: shimmer 3s infinite linear;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        .status-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 25px 0;
            justify-content: center;
        }

        .status-item {
            display: flex;
            align-items: center;
            font-size: 13px;
            background: white;
            padding: 8px 12px;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .status-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
            position: relative;
        }

        .status-dot::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 50%;
            border: 2px solid transparent;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            70% {
                transform: scale(1.5);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 0;
            }
        }

        .dot-presentado {
            background-color: #17A2B8;
        }

        .dot-presentado::after {
            border-color: #17A2B8;
        }

        .dot-ingresado {
            background-color: #007BFF;
        }

        .dot-ingresado::after {
            border-color: #007BFF;
        }

        .dot-apelado {
            background-color: #DC3545;
        }

        .dot-apelado::after {
            border-color: #DC3545;
        }

        .dot-proceso {
            background-color: #FFC107;
        }

        .dot-proceso::after {
            border-color: #FFC107;
        }

        .dot-calificacion {
            background-color: #28A745;
        }

        .dot-calificacion::after {
            border-color: #28A745;
        }



        .warning-message {
            color: #e74c3c;
            text-align: center;
            margin: 25px 0;
            font-size: 15px;
            font-weight: 500;
            padding: 15px;
            background-color: rgba(231, 76, 60, 0.1);
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tabs {
            display: flex;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .tab {
            padding: 15px 25px;
            cursor: pointer;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            background-color: #f5f5f5;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .tab i {
            margin-right: 8px;
            font-size: 18px;
        }

        .tab::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0;
            transition: var(--transition);
            z-index: -1;
        }

        .tab:hover::before {
            opacity: 0.1;
        }

        .tab.active {
            background-color: white;
            color: var(--primary-color);
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.05);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-gradient);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
        }

        table th {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        table tr {
            background-color: white;
            transition: var(--transition);
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: rgba(76, 175, 80, 0.05);
        }

        table td {
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar {
            width: 350px;
            min-width: 300px;
            margin-top: 110px;
            /* Ajustado para alinear con el contenido principal */
            position: sticky;
            top: 30px;
            align-self: flex-start;
        }

        .sidebar-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            position: relative;
        }

        .sidebar-card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-5px);
        }

        .sidebar-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 16px;
            /* Aumenta el valor para que sea más ancho */
            height: 100%;
            background: var(--secondary-gradient);
            border-radius: 12px 0 0 12px;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 900;
            margin-bottom: 20px;
            color: var(--dark-color);
            display: flex;
            align-items: center;
        }

        .sidebar-title i {
            margin-right: 10px;
            background: var(--secondary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 24px;
        }

        .amount {
            font-size: 28px;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin: 15px 0;
            text-align: center;
        }

        .amount-detail {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .amount-detail p {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed var(--border-color);
        }

        .amount-detail p:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .amount-detail p span:first-child {
            font-weight: 600;
            color: var(--dark-color);
        }

        .amount-detail p span:last-child {
            font-weight: 700;
        }

        .amount-detail p:nth-child(1) span:last-child {
            color: var(--primary-color);
        }

        .amount-detail p:nth-child(2) span:last-child {
            color: var(--secondary-color);
        }

        .amount-detail p:nth-child(3) span:last-child {
            color: var(--accent-color);
        }

        .actions {
            margin-top: 25px;
        }

        .action-link {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: var(--dark-color);
            text-decoration: none;
            font-size: 14px;
            padding: 10px 15px;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .action-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0;
            transition: var(--transition);
            z-index: -1;
        }

        .action-link:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .action-link:hover::before {
            opacity: 0.05;
        }

        .action-link i {
            margin-right: 10px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 18px;
            transition: var(--transition);
        }

        .action-link:hover i {
            transform: scale(1.2);
        }

        .action-link .new {
            color: white;
            background: var(--accent-color);
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 4px;
            margin-left: 8px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background-color: rgba(39, 174, 96, 0.1);
            color: #27ae60;
        }

        .badge-pending {
            background-color: rgba(243, 156, 18, 0.1);
            color: #f39c12;
        }

        .badge-danger {
            background-color: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .floating-action {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(76, 175, 80, 0.4);
            cursor: pointer;
            transition: var(--transition);
            z-index: 1000;
        }

        .floating-action:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 6px 15px rgba(76, 175, 80, 0.5);
        }

        .floating-action i {
            font-size: 24px;
        }

        /* Animaciones adicionales */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .animate-slide-up {
            animation: slideUp 0.5s ease-in-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-scale {
            animation: scale 0.3s ease-in-out;
        }

        @keyframes scale {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Efecto de carga */
        .loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: var(--primary-gradient);
            z-index: 9999;
            animation: loading 2s ease-in-out;
            width: 100%;
        }

        @keyframes loading {
            0% {
                width: 0;
            }

            50% {
                width: 65%;
            }

            100% {
                width: 100%;
            }
        }

        /* Media queries para responsividad */
        @media (max-width: 1200px) {
            .main-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-width: 100%;
                margin-top: 0;
                position: static;
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }

            .main-container {
                padding: 15px;
            }

            .tab {
                padding: 10px 15px;
                font-size: 13px;
            }

            .tab i {
                margin-right: 5px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="loading-bar"></div>

    <header class="header">
        <div class="header-links">
            <a href="http://localhost/incocat_abancay/formulario_seguimiento.php#"><i class="fas fa-search-location"></i> Detalle Seguimiento</a>
            <a href="http://localhost/incocat_abancay/index.php" style="color: var(--primary-color);"><i class="fas fa-sign-out-alt"></i> Salir</a>
        </div>
        <div class="platform-name">
            <i class="fas fa-desktop"></i> Plataforma Virtual <span>Síguelo Incocat</span>
        </div>
    </header>

    <div class="main-container">
        <div class="content-container">
            <div class="logos animate-fade-in">
                <img src="img/incocat.png" alt="Logo Síguelo Incocat" class="logo-siguelo">
            </div>

            <div class="welcome-banner animate-slide-up">
                <p><i class="fas fa-hand-sparkles"></i> ¡BIENVENIDO a <span>Síguelo Incocat!</span> En esta plataforma puedes hacer el seguimiento de tu trámite, conocer el contenido del expediente presentado o hacer un pago a cuenta de dicho título.</p>
            </div>

            <div class="card animate-scale">
                <h2 class="card-title"><i class="fas fa-file-invoice"></i> Datos del expediente consultado</h2>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="txt_nro_expediente"><i class="fas fa-hashtag"></i> Número de expediente</label>
                        <input type="text" class="form-control" id="txt_nro_expediente" readonly>
                    </div>
                    <div class="form-group">
                        <label for="txt_tipo_documento"><i class="fas fa-id-card"></i> Tipo de documento</label>
                        <input type="text" id="txt_tipo_documento" class="form-control" class="campo-resaltado" readonly>
                    </div>
                    <div class="form-group">
                        <label for="txt_nro_documento"><i class="fas fa-file-alt"></i> Nro. documento</label>
                        <input type="text" id="txt_nro_documento" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="txt_nombre"><i class="fas fa-user"></i> Nombres</label>
                        <input type="text" class="form-control" id="txt_nombre" readonly>
                    </div>
                    <div class="form-group">
                        <label for="txt_apellido"><i class="fas fa-user"></i> Apellidos</label>
                        <input type="text" id="txt_apellido" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="txt_celular"><i class="fas fa-phone"></i> Celular</label>
                        <input type="text" id="txt_celular" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="txt_email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="text" class="form-control" id="txt_email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="txt_direccion"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                        <input type="text" id="txt_direccion" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="txt_departamento"><i class="fas fa-map"></i> Departamento</label>
                        <input type="text" id="txt_departamento" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="txt_provincia"><i class="fas fa-map-pin"></i> Provincia</label>
                        <input type="text" id="txt_provincia" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="txt_distrito"><i class="fas fa-map-signs"></i> Distrito</label>
                        <input type="text" id="txt_distrito" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="txt_fecha_presentacion"><i class="fas fa-clock"></i> Fecha y Hora de Presentación</label>
                        <input type="text" id="txt_fecha_presentacion" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fecha-vencimiento"><i class="fas fa-copy"></i> Folios</label>
                        <input type="text" id="fecha-vencimiento" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="txt_servicio"><i class="fas fa-concierge-bell"></i> Servicio</label>
                    <input type="text" id="txt_servicio" class="form-control" readonly>
                </div>

                <div class="form-group" style="margin-bottom: 0; text-align: center;">
                    <button class="btn btn-primary" onclick="generarReporteResumen()">
                        <i class="fas fa-file-pdf"></i> Generar Reporte Resumen
                    </button>
                </div>
            </div>

            <div class="status-container2 animate-scale2" id="estadoExpediente">
                <i class="fas fa-check-circle"></i> <span id="estadoTexto"></span>
            </div>


            <div class="card animate-fade-in">
                <p>
                    <i class="fas fa-palette"></i> Conoce el color de tu estado -
                    <a href="#" id="toggleLegend" style="color: var(--primary-color);">Click aquí</a>
                </p>

                <div class="status-legend" id="statusLegend" style="display: none;">
                    <div class="status-item">
                        <div class="status-dot dot-presentado"></div>
                        <span><b>EN PROCESO:</b> Documentación en revisión interna y con documentos faltantes.</span>
                    </div>
                    <div class="status-item">
                        <div class="status-dot dot-ingresado"></div>
                        <span><b>EN TRÁMITE:</b> Enviado para trámite con entidad correspondiente.</span>
                    </div>
                    <div class="status-item">
                        <div class="status-dot dot-apelado"></div>
                        <span><b>OBSERVADO:</b> Tiene observaciones por parte de la entidad correspondiente que deben ser subsanadas. </span>
                    </div>
                    <div class="status-item">
                        <div class="status-dot dot-proceso"></div>
                        <span><b>REINGRESADO:</b>Se reenvía a la entidad correspondiente para su revisión.</span>
                    </div>
                    <div class="status-item">
                        <div class="status-dot dot-calificacion"></div>
                        <span><b>FINALIZADO:</b> Cuando se recibe la aprobación de la entidad correspondiente y se confirma la aprobación, el expediente se marca como finalizado.</span>
                    </div>
                </div>
            </div>



            <div class="card animate-slide-up">
                <div class="tabs">
                    <div class="tab active" data-tab="documentos"><i class="fas fa-file-alt"></i> Documentos Presentados</div>
                    <div class="tab" data-tab="pagos"><i class="fas fa-money-bill-wave"></i> Pagos</div>
                </div>

                <div class="tab-content active" id="documentos-content">
                    <table id="tabla_documentos" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th><i class="fas fa-file-alt"></i> Documento</th>
                                <th><i class="fas fa-calendar-alt"></i> Fecha de presentación</th>
                                <th><i class="fas fa-info-circle"></i> Estado</th>
                            </tr>

                        </thead>

                    </table>
                </div>

                <div class="tab-content" id="pagos-content">
                    <table id="tabla_pagos" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th><i class="fas fa-calculator"></i> Subtotal</th>
                                <th><i class="fas fa-receipt"></i> IGV</th>
                                <th><i class="fas fa-dollar-sign"></i> Total</th>
                                <th><i class="fas fa-calendar-alt"></i> Fecha de Pago</th>
                                <th><i class="fas fa-check-circle"></i> Estado</th>
                            </tr>

                        </thead>
                        <tbody></tbody>

                    </table>
                </div>
            </div>
        </div>

        <div class="sidebar animate-scale">
            <div class="sidebar-card">
                <h3 class="sidebar-title">
                    <i class="fas fa-chart-pie"></i> Información Financiera
                </h3>

                <div class="amount-detail">
                    <p>
                        <span>Monto Total:</span>
                        <span id="monto-total">S/ 0.00</span> <!-- Aquí se mostrará monto_total -->
                    </p>
                    <p>
                        <span>Saldo Cobrado:</span>
                        <span id="saldo-cobrado">S/ 0.00</span> <!-- Aquí se mostrará saldo_cobrado -->
                    </p>
                    <p>
                        <span>Saldo Pendiente:</span>
                        <span id="saldo-pendiente">S/ 0.00</span> <!-- Aquí se mostrará saldo_pendiente -->
                    </p>
                    <p>
                        <span>Estado:</span>
                        <span id="estado"></span> <!-- Aquí se mostrará saldo_pendiente -->
                    </p>
                </div>
            </div>
        </div>

        <div class="floating-action">
            <i class="fas fa-question"></i>
        </div>
    </div>
    <style>
        /* Estilo base para el contenedor del estado */
        /* Estilo base del contenedor de estado */
        .status-container2 {
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 700;
            border-radius: 8px;
            margin: 30px 0;
            box-shadow: 0 4px 6px rgba(76, 175, 80, 0.3);
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        /* Hover */
        .status-container2:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(76, 175, 80, 0.4);
        }

        /* Shimmer */
        .status-container2::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            animation: shimmer 3s infinite linear;
        }

        /* Escalado animado */
        .animate-scale2 {
            animation: scale 0.3s ease-in-out;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        @keyframes scale {
            0% {
                transform: scale(0.95);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Colores dinámicos por estado */
        .estado-en-proceso {
            background-color: #17A2B8 !important;
            color: #fff !important;

        }

        .estado-en-tramite {
            background-color: #007BFF !important;
            color: #fff !important;

        }

        .estado-observado {
            background-color: #DC3545 !important;
            color: #fff !important;

        }

        .estado-reingresado {
            background-color: #FFC107 !important;
            color: #fff !important;

        }

        .estado-finalizado {
            background-color: #28A745 !important;
            color: #000 !important;

        }
        .estado-pendiente {
    background-color: #ffc107;
    color: #000;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.estado-pagado {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.estado-desconocido {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}
.campo-resaltado {
    font-weight: 800;
    font-size: 1.2rem;
    color: #333;
}

    </style>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<script>
        // Animación de carga
        document.addEventListener('DOMContentLoaded', function() {
            cargarPagosPorExpediente(); // se ejecuta al cargar la página
            cargarHistorialPorExpediente(); // se ejecuta al cargar la página
            setTimeout(function() {
                document.querySelector('.loading-bar').style.display = 'none';
            }, 2000);

            // Funcionalidad para las pestañas
            const tabs = document.querySelectorAll('.tab');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remover clase active de todas las pestañas
                    tabs.forEach(t => t.classList.remove('active'));

                    // Agregar clase active a la pestaña actual
                    this.classList.add('active');

                    // Ocultar todos los contenidos de pestañas
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('active');
                    });

                    // Mostrar el contenido de la pestaña actual
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId + '-content').classList.add('active');
                });
            });

            // Botón flotante de ayuda
            document.querySelector('.floating-action').addEventListener('click', function() {
                alert('¿Necesitas ayuda? Contáctanos al 0800-27164');
            });
        });
    </script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="js/console_seguimiento.js?rev=<?php echo time(); ?>"></script><!-- Asegúrate de colocar esta línea antes de cualquier script que utilice jQuery -->

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Mostrar la leyenda al cargar
    document.getElementById("statusLegend").style.display = "block";

    // Alternar visibilidad al hacer clic
    document.getElementById("toggleLegend").addEventListener("click", function (e) {
      e.preventDefault();
      const legend = document.getElementById("statusLegend");
      legend.style.display = legend.style.display === "none" ? "block" : "none";
    });
  });
</script>

<script>
    $(document).ready(function() {
        // 1. Recupera los datos del sessionStorage
        const datos = JSON.parse(sessionStorage.getItem("expedienteDatos"));

        if (!datos) {
            alert("No se encontró información del expediente.");
            return;
        }

        // 2. Aplica el estado al contenedor visual
        aplicarEstadoExpediente(datos.ESTADO_EXPE);

        // 3. Rellenar los campos con los datos del expediente
       // 3. Rellenar los campos con los datos del expediente
    $("#txt_nro_expediente").val(datos.nro_expediente);
    $("#txt_tipo_documento").val(datos.tipo_documento);
    $("#txt_nro_documento").val(datos.nro_documento);

    // 4. Aplicar los estilos a los campos
    $("#txt_nro_expediente, #txt_tipo_documento, #txt_nro_documento").addClass("campo-resaltado");

        $("#txt_nombre").val(datos.nombres);
        $("#txt_apellido").val(datos.apellidos);
        $("#txt_celular").val(datos.celular);
        $("#txt_email").val(datos.email);
        $("#txt_direccion").val(datos.direccion);
        $("#txt_departamento").val(datos.REGION);
        $("#txt_provincia").val(datos.PROVINCIA);
        $("#txt_distrito").val(datos.DISTRITO);
        $("#txt_fecha_presentacion").val(datos.fecha_formateada);
        $("#fecha-vencimiento").val(datos.folios);
        $("#txt_servicio").val(datos.nombre);

        // 4. Asignar los datos financieros al sidebar
        $("#monto-total").text(`S/ ${parseFloat(datos.monto_total).toFixed(2)}`);
        $("#saldo-cobrado").text(`S/ ${parseFloat(datos.saldro_cobrado).toFixed(2)}`);
        $("#saldo-pendiente").text(`S/ ${parseFloat(datos.saldo_pendiente).toFixed(2)}`);
        const estadoFinanciero = datos.estado ? datos.estado.toUpperCase() : "DESCONOCIDO";
const $estadoSpan = $("#estado");

$estadoSpan.text(estadoFinanciero);

// Limpiar clases anteriores
$estadoSpan.removeClass("estado-pendiente estado-pagado estado-desconocido");

// Asignar clase según estado
if (estadoFinanciero === "PENDIENTE") {
    $estadoSpan.addClass("estado-pendiente");
} else if (estadoFinanciero === "PAGADA" || estadoFinanciero === "PAGADO") {
    $estadoSpan.addClass("estado-pagado");
} else {
    $estadoSpan.addClass("estado-desconocido");
}

    });
</script>
