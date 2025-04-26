<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Trámite INCOCAT</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url('img/img3.jpg'); /* Reemplaza con tu imagen de fondo */
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
            background: white;
            padding: 2rem;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo img {
            max-width: 200px;
        }

        .form-description {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .radio-group {
            display: flex;
            gap: 1rem;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .captcha-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .captcha-image {
            background: #f5f5f5;
            padding: 0.5rem;
            border-radius: 4px;
        }

        .refresh-button {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
        }

        .search-button {
            width: 100%;
            padding: 0.8rem;
            background: #8BC34A;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }

        .search-button:hover {
            background: #7CB342;
        }

        .terms {
            text-align: center;
            font-size: 0.8rem;
            color: #666;
            margin-top: 1rem;
        }

        .terms a {
            color: #E91E63;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="logo">
            <img src="img/incocat.png" alt="Síguelo Plus Logo" class="img-fluid" style="max-width: 400px;">
        </div>
        
        <p class="form-description">
            Realiza el seguimiento de tu trámite, conoce el contenido de un título presentado o haz seguimiento de tus pagos
        </p>

        <form method="POST" action="">
            <div class="form-group">
                <label>Tipo de Documento</label>
                <select name="tipo_documento" required>
                    <option value="">Seleccione tipo</option>
                    <option value="DNI">DNI</option>
                    <option value="RUC">RUC</option>
                    <option value="CE">Carné de Extranjería</option>
                    <option value="PAS">Pasaporte</option>
                    <!-- Puedes agregar más tipos si quieres -->
                </select>
            </div>

            <div class="form-group">
                <label>Número de Documento</label>
                <input type="text" name="numero_documento" placeholder="Ingrese su número de documento" required>
            </div>

            <div class="form-group">
                <label>Número de Expediente</label>
                <input type="text" name="numero_expediente" placeholder="Ingrese su número de expediente" required>
            </div>

            <button type="submit" class="search-button">Buscar</button>

            <p class="terms">
                Para utilizar este servicio debe aceptar los términos y condiciones siguientes: 
                <a href="#">Ingresar</a>
            </p>
        </form>
    </div>
</body>

</html>