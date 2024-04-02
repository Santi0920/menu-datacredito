<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Alerta de registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            width: 490px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #005E56;
            font-size: 28px;
            margin-top: 0;
            text-align: center;
        }
        p {
            color: #333333;
            font-size: 18px;
            line-height: 1.5;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 250px;
            height: auto;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            
        }
        .footer p {
            color: #999999;
            font-size: 14px;
            
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="logo">
            <img src="https://porritacoopserp.com/img/LogoCoopserp2014-PNG.png" alt="Coopserp.icono" width="250px" height="120px" id="data" class="navbar-brand mb-2 mt-2">
        </div>
        <h1>¡Bienvenido, {{ $user->name }}!</h1>

        <p style="color: black; text-align: justify;">Por favor, verifica tu dirección de correo electrónico haciendo clic en el siguiente enlace:
            <br><a href="{{ route('verification.verify', ['id' => $user->id]) }}">Verificar correo electrónico</a>
        </p>
    </div>
    <div class="footer">
    <p>Si no has solicitado esta verificación, puedes ignorar este correo electrónico.</p>
    </div>
</body>
</html>