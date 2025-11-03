<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de Sesión</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #333; /* Fondo gris oscuro */
      color: white; /* Texto blanco */
    }
    .login-container {
      background-color: #444; /* Fondo gris más claro */
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    }
    h2 {
      color: #ff0000; /* Color rojo */
      text-align: center;
    }
    .btn-danger {
      background-color: #ff0000; /* Botón rojo */
      border: none;
    }
    .btn-danger:hover {
      background-color: #cc0000; /* Rojo más oscuro al pasar el ratón */
    }
  </style>
</head>
<body>
    <br><br><br><br><br><br>
  <div class="container">
      <div class="login-container mx-auto col-md-4">
          <h2>Iniciar Sesión</h2>
          <form action="{{ route('usuario') }}" method="POST"> <!-- Cambiado a POST -->
            @csrf <!-- Asegúrate de incluir el token CSRF -->
            <div class="form-group">
                <label for="name">Nombre de usuario</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-danger btn-block">Entrar</button>
        </form>

          @if ($errors->any())
              <div class="alert alert-danger mt-3">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
      </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="scripts.js"></script>
</body>
</html>
