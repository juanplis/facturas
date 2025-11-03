<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0; /* Fondo gris claro */
    }
    .menu {
        background-color: #333333 ; /*  Fondo del menú gris oscuro */
        color: white;
        display: flex;
        justify-content: space-around;
        padding: 15px 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }     
    .menu a {
        color: #FF6347; /* Color de los enlaces (rojo) */
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .menu a:hover {
        background-color: #555; /* Fondo gris más claro al pasar el mouse */
        transform: scale(1.05);
    }
    .menu a.active {
        background-color: #FF6347; /* Fondo rojo para el enlace activo */
        color: white;
    }
</style>

@php
    $userName = session('user_name');
    $profileType = session('profile_type');

@endphp
@if(session('token'))

<div class="menu">
      <!--  super admin -->

  
@if( $profileType==1) 
    <a href="{{ route('factura.index') }}" class="active">Inicio</a>
    <a href="{{ route('users.index') }}">Usuarios</a>
    <a href="{{ route('profile.index') }}">Perfiles</a>
    <a href="{{ route('empresas.index') }}">Empresas</a>
    <a href="{{ route('tasa_bcv.index') }}">Tasa BCV</a>
    <a href="{{ route('iva.index') }}">Iva</a>
    <a href="{{ route('user.index') }}">Cliente</a>
    <a href="{{ route('inventario.index') }}">Inventario</a>
@endif  
      <!--  admin steel -->

@if( $profileType==2)
    <a href="{{ route('factura.index') }}" class="active">Inicio</a>
    <a href="{{ route('users.index') }}">Usuarios</a>
    <a href="{{ route('empresas.index') }}">Empresas</a>
    <!--a href="{{ route('tasa_bcv.index') }}">Tasa BCV</a>
    <a href="{{ route('iva.index') }}">Iva</a-->
    <a href="{{ route('user.index') }}">Cliente</a>
    <a href="{{ route('inventario.index') }}">Inventario</a>
@endif  
      <!--  ventas tucocina 3-->    


@if( $profileType==3)
    <a href="{{ route('factura.index') }}" class="active">Inicio</a>
    <a href="{{ route('user.index') }}">Cliente</a>
@endif  
  
    <!--  usurio web 4 -->
@if( $profileType==4 )
    <a href="{{ route('factura.index') }}" class="active">Inicio</a>
@endif  
    
  
    <!--a href="{{ route('welcome') }}">Salir</a-->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button class="btn btn-danger" type="submit">Salir</button>
</form>
</div>
    <div class="welcome-message"> <br>
       <strong> Estás conectado como {{ $userName }} <!-- ! Perfil {{ $profileType }}.--></strong>
       <!--strong> Perfil {{ $profileType }} </strong-->
	   <strong> Perfil {{ session('profile_name') }}</strong>

    </div>
    <!--div class="token-message">
        Tienes un token válido.
    </div-->
@else
    <script>
        window.location.href = "{{ route('welcome') }}"; // Redirigir al índice si no tiene token
    </script>
@endif

<!--style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .menu {
        background-color: black;
        color: white;
        display: flex;
        justify-content: space-around;
        padding: 10px 0;
    }     
    .menu a {
        color: red;
        text-decoration: none;
        padding: 10px 15px;
        transition: background 0.3s;
    }
    .menu a:hover {
        background-color: grey;
    }
</style>

<div class="menu">
    <a href="{{ route('factura.index') }}">Inicio</a>
    <a href="{{ route('empresas.index') }}">Empresas</a>
    <a href="{{ route('tasa_bcv.index') }}">Tasa BCV</a>
    <a href="{{ route('user.index') }}">Cliente</a>
    <!--a href="#sobre-nosotros">Sobre Nosotros</a>-->
  <!--a href="{{ route('inventario.index') }}">Inventario</a>
    <a href="{{ route('welcome') }}">Salir</a>
</div-->
