<style>
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
    <a href="{{ route('user.index') }}">cliente</a>
       <a href="{{ route('inventario.index') }}">Inventario</a>
    <a href=" #contacto">Empresa</a>
</div>
