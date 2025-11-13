<?php

namespace App\Http\Controllers; // Namespace correcto para los controladores
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Inventario;
use App\Models\Clientes;
use App\Models\Usuarios;
use App\Models\Items;
use App\Models\Empresa;
use App\Models\Factura;
use App\Models\Iva;
use App\Models\PorcentajeInventario;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

use Session;
use Illuminate\Support\Str;

use App\Models\Profile; // Asegúrate de incluir el modelo Profile

class Facturas extends Controller{


    public function login()
    {
        // Lógica para mostrar la vista de bienvenida
        return view('welcome'); // Asegúrate de que la vista exista
    }

    public function indexqq()
{

    $presupuestos = Presupuesto::all(); // Obtén todos los elementos de la lista
    return view('factura.index', compact('presupuestos')); // Pasa la variable a la vista



}
  /*
public function index()
{
    // Cambia 5 por el número de presupuestos que deseas mostrar por página
    $presupuestos = Presupuesto::with('estado')->orderBy('id', 'desc')->paginate(5);

    return view('factura.index', compact('presupuestos'));
}

*/

  public function index(Request $request)
    {
        $search = $request->input('search');

        // Filtrar los presupuestos según el término de búsqueda
        $presupuestos = Presupuesto::with(['estado', 'user'])
            ->when($search, function($query) use ($search) {
                return $query->whereHas('cliente', function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%");
                })

                ->orWhereHas('empresa', function($q) use ($search) {
                    $q->where('razon_social', 'LIKE', "%{$search}%");
                })
                ->orWhere('fecha', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('factura.index', compact('presupuestos'));
    }

    public function usuarios(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    // Buscar el usuario por nombre
    $usuario = Usuarios::where('name', $request->name)->first();

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($usuario && Hash::check($request->password, $usuario->password)) {
 // Las credenciales son correctas
                session(['user_id'=> $usuario->id]);
                session(['user_name' => $usuario->name]);
                session(['profile_type' => $usuario->perfil_id]);

        // Obtener el nombre del perfil
        $perfil = Profile::where('id', $usuario->perfil_id)->first();

        if ($perfil) {
            // Almacenar el nombre del perfil en la sesión
            session(['profile_name' => $perfil->name]);
        }
  // Autenticación exitosa, generar un token
        $token = Str::random(60); // Generar un token aleatorio

        // Almacenar el token en la sesión
        $request->session()->put('token', $token);
      return redirect()->route('factura.index'); // Redirigir a la vista factura.index
    } else {
        // Las credenciales son incorrectas
        return back()->withErrors([
            'name' => 'El nombre de usuario o la contraseña son incorrectos.',
        ]);
    }
}

  public function logout(Request $request)
{
    // Cerrar la sesión
    $request->session()->flush(); // Elimina todos los datos de la sesión
    $request->session()->forget('token'); // Eliminar el token de la sesión
    // Redirigir a la página de inicio o a donde desees
    return redirect()->route('welcome'); // Cambia 'home' por la ruta que desees
}


/************************************************
   public function buscar(Request $request, $id)
{
    // Obtener todos los clientes
    $clientes = Clientes::all(); // Cambié $cliente a $clientes para mayor claridad

    // Obtener productos
    $inventarios = Inventario::all(); // Cambié $inventario a $inventarios para mayor claridad

    // Buscar la empresa por ID
    // Obtener empresas que coincidan con el ID recibido
    $empresas = Empresa::where('id', $id)->get();

    // Verificar si se encontró la empresa
    if ($empresas->isEmpty()) {
        return redirect()->back()->withErrors(['error' => 'Empresa no encontrada.']);
    }

    // Retornar la vista con los datos necesarios
    return view('factura.presupuesto', compact('clientes', 'inventarios', 'empresas'));
}*************************************************/



  //************* Nuevo controlador***********


public function buscar(Request $request, $id)
{



    // Obtener el monto del IVA
   $ivaModel = Iva::orderBy('id', 'desc')->first(); // Obtiene el último registro de IVA
    $iva = $ivaModel ? $ivaModel->monto_iva : 0; // Manejar el caso donde no haya registro
    // Obtener todos los clientes
    $clientes = Clientes::all();

    // Obtener productos
    $inventarios = Inventario::all();

    // Buscar la empresa por ID
    $empresas = Empresa::where('id', $id)->get();

    // Verificar si se encontró la empresa
    if ($empresas->isEmpty()) {
        return redirect()->back()->withErrors(['error' => 'Empresa no encontrada.']);
    }

    // Obtener el correlativo para la empresa
    $correlativo = $this->obtenerCorrelativo($id); // Suponiendo que $id es el tipo de empresa

    $porcentaje = PorcentajeInventario::latest()->first();
    // Retornar la vista con los datos necesarios
    return view('factura.presupuesto', compact('clientes', 'inventarios', 'empresas', 'correlativo', 'iva', 'porcentaje'));
}



public function cargar(Request $request)
{
    // 1. Validar los datos recibidos
    $request->validate([
        'cliente_id' => 'required|integer',
        'fecha' => 'required|date',
        'subtotal' => 'required|numeric',
        'iva' => 'required|numeric',
        'descuento' => 'nullable|numeric',
        'condiciones_pago' => 'nullable|string',
        'validez' => 'nullable|date',
        'descripcion' => 'required|array', // Aquí se espera que contenga los IDs de los productos
        'cantidad' => 'required|array',
        'empresa_id' => 'required|integer',
        'correlativo' => 'required|integer', // Asegúrate de que el correlativo sea requerido y sea un entero
        'porcentaje_aplicado' => 'required|numeric', // ¡NUEVA VALIDACIÓN!
		'user_id' => 'required|integer'
    ]);

    //dd( $request);

    // 2. Calcular el total considerando IVA y descuento
    $subtotal = $request->subtotal;
    $iva = $request->iva;
    $descuento = $request->descuento ?? 0;

    $subtotalConDescuento = $subtotal - ($subtotal * $descuento / 100);
    $total = $subtotalConDescuento + ($subtotalConDescuento * $iva / 100);

    // 3. Sumar 1 al correlativo recibido
    $correlativoIncrementado = $request->correlativo + 1;

    // 4. Crear un nuevo registro de Presupuesto
    $presupuesto = Presupuesto::create([
        'cliente_id' => $request->cliente_id,
        'fecha' => $request->fecha,
        'subtotal' => $subtotal,
        'total' => $total,
        'iva' => $iva,
        'descuento' => $descuento,
        'condiciones_pago' => $request->condiciones_pago ?: null,
        'validez' => $request->validez ?: null,
        'empresa_id' => $request->empresa_id,
        'correlativo' => $correlativoIncrementado,
        'porcentaje' => $request->porcentaje_aplicado, // ¡GUARDAR EL PORCENTAJE APLICADO!
		'user_id' => $request->user_id,
        'status' => 1
    ]);

    // 5. Actualizar el correlativo en la tabla de facturas
    Factura::where('empresa_id', $request->empresa_id)->update(['correlativo' => $correlativoIncrementado]);

    // 6. Crear los ítems asociados a este presupuesto
    foreach ($request->descripcion as $index => $productoId) {
        $cantidad = $request->cantidad[$productoId];

        // Obtener el precio unitario del inventario
        $inventarioItem = Inventario::find($productoId);
        if (!$inventarioItem) {
            return redirect()->back()->withErrors(['error' => "El producto con ID {$productoId} no fue encontrado."]);
        }

        // Ajustar el precio unitario según la empresa
        $preciounitario = $inventarioItem->precio_unitario;

        if ($request->empresa_id != 1) {
            // Obtener el valor dinámico del porcentaje aplicado
            $porcentajeAplicado = $request->porcentaje_aplicado;
            $factorPorcentaje = $porcentajeAplicado ;

            // Lógica de cálculo dinámica
            if ($factorPorcentaje > 0) {
                $preciounitario /= $factorPorcentaje;
            }
            // ELSE: Si factorPorcentaje es 0, no hacemos nada (mantenemos precio unitario base).

            // LÍNEA COMENTADA QUE REEMPLAZA AL VALOR FIJO ANTERIOR:
            // $preciounitario /= 0.45; // Este era el cálculo anterior
        }

        $preciototal = $cantidad * $preciounitario;

        Items::create([
            'presupuesto_id' => $presupuesto->id,
            'codigo' => $inventarioItem->codigo, // Guardar el código del producto
            'descripcion' => $inventarioItem->descripcion,
            'cantidad' => $cantidad,
            'precio_unitario' => $preciounitario,
            'precio_total' => $preciototal
        ]);
    }

    // 7. Cargar los ítems recién creados para mostrarlos en la vista de confirmación
    $presupuesto->load(['items', 'cliente', 'empresa']);

    // 8. Retornar la vista con los datos del presupuesto y sus ítems
    return view('factura.cargar', [
        'presupuesto' => $presupuesto,
        'items' => $presupuesto->items
    ])->with('success', 'Presupuesto creado con éxito.');
}


  private function obtenerCorrelativo($tipo_empresa)
{
    // Obtener el último correlativo de la tabla de facturas para el tipo de empresa
    $ultimoCorrelativo = Factura::where('empresa_id', $tipo_empresa)
        ->max('correlativo');

    // Si no hay correlativos previos, iniciar en 1001 (o el número que desees)
    if (!$ultimoCorrelativo) {
        return '1001'; // Cambia esto si deseas un inicio diferente
    }

    // Incrementar el correlativo y formatearlo
    $nuevoCorrelativo = str_pad((intval($ultimoCorrelativo) + 1), 4, '0', STR_PAD_LEFT);
    return $nuevoCorrelativo;
}



  //**************************** pruebas de correlativos

 /* private function obtenerCorrelativo($tipo_empresa)
{
    // Obtener el último correlativo para el tipo de empresa
    $ultimoCorrelativo = Presupuesto::where('empresa_id', $tipo_empresa)
        ->max('correlativo');

    // Si no hay correlativos previos, iniciar en 0001
    if (!$ultimoCorrelativo) {
        return '1000';
    }

    // Incrementar el correlativo y formatearlo
    $nuevoCorrelativo = str_pad((intval($ultimoCorrelativo) + 1), 4, '0', STR_PAD_LEFT);
    return $nuevoCorrelativo;
}*/

  //****************************////







/*public function cargar(Request $request)
{
    // 1. Validar los datos recibidos
    $request->validate([
        'cliente_id' => 'required|integer',
        'fecha' => 'required|date',
        'subtotal' => 'required|numeric',
        'iva' => 'required|numeric',
        'descuento' => 'nullable|numeric',
        'condiciones_pago' => 'nullable|string',
        'validez' => 'nullable|date',
        'descripcion' => 'required|array', // Aquí se espera que contenga los IDs de los productos
        'cantidad' => 'required|array',
        'empresa_id' => 'required|integer'
    ]);

    // 2. Calcular el total considerando IVA y descuento
    $subtotal = $request->subtotal;
    $iva = $request->iva;
    $descuento = $request->descuento ?? 0;

    $subtotalConDescuento = $subtotal - ($subtotal * $descuento / 100);
    $total = $subtotalConDescuento + ($subtotalConDescuento * $iva / 100);

    // 3. Crear un nuevo registro de Presupuesto
    $presupuesto = Presupuesto::create([
        'cliente_id' => $request->cliente_id,
        'fecha' => $request->fecha,
        'subtotal' => $subtotal,
        'total' => $total,
        'iva' => $iva,
        'descuento' => $descuento,
        'condiciones_pago' => $request->condiciones_pago ?: null,
        'validez' => $request->validez ?: null,
        'empresa_id' => $request->empresa_id,
        'status' => 1
    ]);

    // 4. Crear los ítems asociados a este presupuesto
    foreach ($request->descripcion as $index => $productoId) {
        $cantidad = $request->cantidad[$productoId];

        // Obtener el precio unitario del inventario
        $inventarioItem = Inventario::find($productoId);
        if (!$inventarioItem) {
            return redirect()->back()->withErrors(['error' => "El producto con ID {$productoId} no fue encontrado."]);
        }

        // Ajustar el precio unitario según la empresa
        $preciounitario = $inventarioItem->precio_unitario;
        if ($request->empresa_id != 1) {
           // $preciounitario /= 0.57; // Ajustar el precio
           $preciounitario /= 0.45; // Ajustar el precio

        }

        $preciototal = $cantidad * $preciounitario;

        Items::create([
            'presupuesto_id' => $presupuesto->id,
            'codigo' => $inventarioItem->codigo, // Guardar el código del producto
            'descripcion' => $inventarioItem->descripcion,
            'cantidad' => $cantidad,
            'precio_unitario' => $preciounitario,
            'precio_total' => $preciototal
        ]);
    }

    // 5. Cargar los ítems recién creados para mostrarlos en la vista de confirmación
    $presupuesto->load(['items', 'cliente', 'empresa']);

    // 6. Retornar la vista con los datos del presupuesto y sus ítems
    return view('factura.cargar', [
        'presupuesto' => $presupuesto,
        'items' => $presupuesto->items
    ])->with('success', 'Presupuesto creado con éxito.');
}
*/

public function ver($id)
{
    // Busca el presupuesto por ID
    $presupuesto = Presupuesto::findOrFail($id);

    // Retorna la vista con los detalles del presupuesto
    return view('factura.ver', compact('presupuesto'));
}


public function eliminar($id)
{
    $presupuesto = Presupuesto::find($id);

    if ($presupuesto) {
        // Primero, eliminar los items relacionados con el presupuesto
        $itemsEliminados = items::where('presupuesto_id', $id)->delete();

        // Luego, eliminar el presupuesto
        $presupuesto->delete();

        return redirect()->back()->with('success', 'Presupuesto y sus items eliminados con éxito.');
    }

    return redirect()->back()->with('error', 'Presupuesto no encontrado.');
}


public function eliminar2($id)
{
    try {
        $presupuesto = Presupuesto::findOrFail($id);
         items::where('presupuesto_id', $id)->delete();

        $presupuesto->delete();
        return redirect()->route('factura.index')->with('success', 'Registro eliminado exitosamente.');
    } catch (\Exception $e) {
        return redirect()->route('factura.index')->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
    }
}

  public function editar11112025($id)
    {
        // 1. Obtener el monto del IVA
        $ivaModel = Iva::orderBy('id', 'desc')->first(); // Obtiene el último registro de IVA
        $iva = $ivaModel ? $ivaModel->monto_iva : 0; // Manejar el caso donde no haya registro

        // 2. Obtener el porcentaje de inventario
        $porcentajeInventarioModel = PorcentajeInventario::orderBy('id', 'desc')->first();
        $porcentaje = $porcentajeInventarioModel ? $porcentajeInventarioModel : null;

        // 3. Obtener el presupuesto por ID
        $presupuesto = Presupuesto::find($id);

        if (!$presupuesto) {
            return redirect()->route('factura.index')->with('error', 'Presupuesto no encontrado.');
        }

        // 4. Obtener todos los clientes
        $clientes = Clientes::all();

        // 5. Obtener los ítems relacionados con el presupuesto
        $items = $presupuesto->items; // Asegúrate de que la relación esté definida en el modelo Presupuesto

        // 6. Obtener todos los productos del inventario
        $productos = Inventario::all(); // Cambia esto si necesitas filtrar productos específicos

        // 7. Pasar datos a la vista
        return view('factura.editar', compact('presupuesto', 'clientes', 'items', 'productos', 'iva', 'porcentaje'));
    }

public function editar($id)
{
    // 1. Obtener el monto del IVA
    $ivaModel = Iva::orderBy('id', 'desc')->first(); // Obtiene el último registro de IVA
    $iva = $ivaModel ? $ivaModel->monto_iva : 0; // Manejar el caso donde no haya registro

    // 2. Obtener el porcentaje de inventario
    $porcentajeInventarioModel = PorcentajeInventario::orderBy('id', 'desc')->first();
    $porcentaje = $porcentajeInventarioModel ? $porcentajeInventarioModel : null;

    // 3. Obtener el presupuesto por ID
    $presupuesto = Presupuesto::find($id);

    if (!$presupuesto) {
        return redirect()->route('factura.index')->with('error', 'Presupuesto no encontrado.');
    }

    // 4. Obtener todos los clientes
    $clientes = Clientes::all();

    // 5. Obtener los ítems relacionados con el presupuesto
    $items = $presupuesto->items; // Asegúrate de que la relación esté definida en el modelo Presupuesto

    // 6. Obtener todos los productos del inventario
    $productos = Inventario::all(); // Cambia esto si necesitas filtrar productos específicos

    // 7. Obtener el nombre de la empresa utilizando el empresa_id
    $empresa = Empresa::find($presupuesto->empresa_id); // Asegúrate de que 'empresa_id' está en el modelo Presupuesto
    $nombreEmpresa = $empresa ? $empresa->razon_social : 'Empresa no encontrada';

    // 8. Pasar datos a la vista
    return view('factura.editar', compact('presupuesto', 'clientes', 'items', 'productos', 'iva', 'porcentaje', 'nombreEmpresa'));
}

public function update(Request $request, $id)
{
    // 1. Validar los datos recibidos
    $request->validate([
        'cliente_id' => 'required|integer',
        'fecha' => 'required|date',
        'subtotal' => 'required|numeric',
        'iva' => 'required|numeric',
        'descuento' => 'nullable|numeric',
        'total' => 'required|numeric',
        'condiciones_pago' => 'nullable|string',
        'validez' => 'nullable|date',
        'descripcion' => 'required|array', // Códigos de producto (ahora son IDs)
        'cantidad' => 'required|array', // Cantidades (array asociativo)
        'empresa_id' => 'required|integer',
        'user_id' => 'required|integer',
        'porcentaje_aplicado' => 'required|numeric' // Validación del porcentaje aplicado
    ]);

    // Usar una transacción asegura que si algo falla, los cambios se revierten.
    DB::beginTransaction();
    try {
        // 2. Encontrar el presupuesto existente
        $presupuesto = Presupuesto::findOrFail($id);

        // 3. Preparar los datos para la actualización
        $dataToUpdate = [
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'subtotal' => $request->subtotal,
            'iva' => $request->iva,
            'descuento' => $request->descuento ?? 0,
            'total' => $request->total,
            'condiciones_pago' => $request->condiciones_pago ?: null,
            'validez' => $request->validez ?: null,
            'empresa_id' => $request->empresa_id,
            'user_id' => $request->user_id,
            'porcentaje' => $request->porcentaje_aplicado, // Guardar el porcentaje aplicado
            'status' => 1
        ];

        // 4. Actualizar el presupuesto (El correlativo se mantiene si no se envía)
        $presupuesto->update($dataToUpdate);

        // 5. Actualizar los ítems asociados a este presupuesto
        // a. Eliminar ítems antiguos
        $presupuesto->items()->delete();

        // b. Crear nuevos ítems
        foreach ($request->descripcion as $productoCodigo) {
            $cantidad = $request->cantidad[$productoCodigo];

            // Obtener el precio unitario BASE del inventario buscando por 'código'
            $inventarioItem = Inventario::where('codigo', $productoCodigo)->first();
            if (!$inventarioItem) {
                throw new \Exception("El producto con código {$productoCodigo} no fue encontrado.");
            }

            // Ajustar el precio unitario según la empresa (Lógica de Precio)
            $precioUnitario = $inventarioItem->precio_unitario;

            if ($request->empresa_id != 1) {
                // Obtener el valor dinámico del porcentaje aplicado
                $porcentajeAplicado = $request->porcentaje_aplicado;
                $factorPorcentaje = $porcentajeAplicado;

                // Lógica de cálculo dinámica
                if ($factorPorcentaje > 0) {
                    $precioUnitario /= $factorPorcentaje;
                }
            }

            $precioTotal = $cantidad * $precioUnitario;

            Items::create([
                'presupuesto_id' => $presupuesto->id,
                'codigo' => $inventarioItem->codigo,
                'descripcion' => $inventarioItem->descripcion,
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario,
                'precio_total' => $precioTotal
            ]);
        }

        DB::commit(); // Confirmar los cambios

    } catch (\Exception $e) {
        DB::rollBack(); // Deshacer si hubo un error
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }

    // 6. Cargar los ítems recién creados y retornar la vista de confirmación
    $presupuesto->load(['items', 'cliente', 'empresa']);

    return view('factura.cargar', [
        'presupuesto' => $presupuesto,
        'items' => $presupuesto->items
    ])->with('success', 'Presupuesto actualizado con éxito.');
}

/* public function update(Request $request, $id)
{
    // 1. Validar los datos recibidos
    $request->validate([
        'cliente_id' => 'required|integer',
        'fecha' => 'required|date',
        'subtotal' => 'required|numeric',
        'iva' => 'required|numeric',
        'descuento' => 'nullable|numeric',
        'total' => 'required|numeric',
        'condiciones_pago' => 'nullable|string',
        'validez' => 'nullable|date',
        'descripcion' => 'required|array',
        'cantidad' => 'required|array',
        'empresa_id' => 'required|integer'
    ]);

    // 2. Encontrar el presupuesto existente
    $presupuesto = Presupuesto::findOrFail($id);

    // 3. Actualizar los datos del presupuesto
    $presupuesto->update([
        'cliente_id' => $request->cliente_id,
        'fecha' => $request->fecha,
        'subtotal' => $request->subtotal,
        'iva' => $request->iva,
        'descuento' => $request->descuento ?? 0,
        'total' => $request->total,
        'condiciones_pago' => $request->condiciones_pago ?: null,
        'validez' => $request->validez ?: null,
        'empresa_id' => $request->empresa_id,
        'status' => 1
    ]);

    // 4. Actualizar los ítems asociados a este presupuesto
    $presupuesto->items()->delete();

    // Ahora, en lugar de usar find(), busca por la columna 'codigo'
    foreach ($request->descripcion as $codigoproducto) {
        $cantidad = $request->cantidad[$codigoproducto];

        // Obtener el precio unitario del inventario buscando por 'codigo'
        $inventarioItem = Inventario::where('codigo', $codigoproducto)->first();
        if (!$inventarioItem) {
            return redirect()->back()->withErrors(['error' => "El producto con código {$codigoproducto} no fue encontrado."]);
        }
        $preciounitario = $inventarioItem->precio_unitario;
        $preciototal = $cantidad * $preciounitario;

        Items::create([
            'presupuesto_id' => $presupuesto->id,
            'codigo' => $codigoproducto,
            'descripcion' => $inventarioItem->descripcion,
            'cantidad' => $cantidad,
            'precio_unitario' => $preciounitario,
            'precio_total' => $preciototal
        ]);
    }

    // 5. Cargar los ítems recién creados para mostrarlos en la vista de confirmación
    $presupuesto->load(['items', 'cliente', 'empresa']);

    // 6. Retornar la vista con los datos del presupuesto y sus ítems
    return view('factura.cargar', [
        'presupuesto' => $presupuesto,
        'items' => $presupuesto->items
    ])->with('success', 'Presupuesto actualizado con éxito.');
}*/

public function status($id) {
    // Encuentra el presupuesto por ID
    $presupuesto = Presupuesto::find($id);

    // Verifica si el presupuesto existe
    if (!$presupuesto) {
        return redirect()->back()->with('error', 'Presupuesto no encontrado');
    }

    // Actualiza el campo 'presupuesto' con el nuevo estado que enviaste
    $nuevoEstado = request()->input('nuevo_estado'); // Obtiene el nuevo estado del formulario
    $presupuesto->estatus_presupuesto = $nuevoEstado; // Asigna el nuevo estado al campo 'presupuesto'

    // Guarda los cambios en la base de datos
    $presupuesto->save();

    // Devuelve una respuesta exitosa redirigiendo a la vista con un mensaje de éxito
    return redirect()->back()->with('success', 'Presupuesto actualizado con éxito');
}


 }
