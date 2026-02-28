<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cafetería UTVT')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .navbar { background-color: #333; padding: 15px; color: white; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-warning { background-color: #ffc107; color: black; }
        .btn:hover { opacity: 0.8; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .actions { display: flex; gap: 10px; }
        h1 { margin-bottom: 20px; color: #333; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        /* ═══════════════════════════════════════════════════════════════════
           ESTILOS DEL LOGO CAFETERÍA UTV
           Inspirado en los colores de la Universidad Tecnológica del Valle de Toluca
           ═══════════════════════════════════════════════════════════════════ */
        .logo-container {
            background: linear-gradient(135deg, #1a5f2a 0%, #2d8a3e 50%, #1a5f2a 100%);
            padding: 20px 30px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .logo-icon {
            font-size: 2.5em;
            color: white;
        }
        .logo-text {
            text-align: center;
        }
        .logo-text .logo-main {
            font-size: 2.2em;
            font-weight: bold;
            color: white;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin: 0;
            line-height: 1;
        }
        .logo-text .logo-sub {
            font-size: 0.9em;
            color: #c8e6c9;
            margin-top: 5px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .logo-text .logo-university {
            font-size: 0.75em;
            color: #a5d6a7;
            margin-top: 8px;
            font-style: italic;
        }
        @media (max-width: 600px) {
            .logo-text .logo-main { font-size: 1.5em; }
            .logo-icon { font-size: 1.8em; }
            .logo-container { padding: 15px 20px; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('tipo_comidas.index') }}">Tipos de Comida</a>
        <a href="{{ route('comidas.index') }}">Comidas</a>
    </nav>

    <!-- ════════════════════════════════════════════════════════════════════════
         LOGO CAFETERÍA UTV
         ════════════════════════════════════════════════════════════════════════ -->
    <div class="container">
        <div class="logo-container">
            <div class="logo-icon">🍽️</div>
            <div class="logo-text">
                <div class="logo-main"> CAFETERÍA UTVT</div>
                <div class="logo-sub">Sistema de Gestión</div>
                <div class="logo-university">Universidad Tecnológica del Valle de Toluca</div>
            </div>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
