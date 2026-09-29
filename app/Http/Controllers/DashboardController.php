<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\Alerta;
use App\Models\Usuario;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ventas del día
        $ventasHoy = Venta::whereDate('fecha_venta', today())
                          ->where('estado', 'COMPLETADA')
                          ->sum('total');
        
        $cantidadVentasHoy = Venta::whereDate('fecha_venta', today())
                                  ->where('estado', 'COMPLETADA')
                                  ->count();
        
        // Total de productos activos
        $totalProductos = Producto::where('estado', 'ACTIVO')->count();
        
        // Alertas pendientes
        $alertasPendientes = Alerta::where('estado', 'PENDIENTE')->count();
        
        // Total de usuarios activos
        $totalUsuarios = Usuario::where('estado', 'ACTIVO')->count();
        
        // Productos con stock bajo (top 5)
        $productosStockBajo = Producto::whereColumn('stock', '<=', 'stock_minimo')
                                      ->where('estado', 'ACTIVO')
                                      ->orderBy('stock', 'asc')
                                      ->take(5)
                                      ->get();
        
        // Lotes próximos a vencer (top 5)
        $lotesProximosVencer = Lote::where('estado', 'DISPONIBLE')
                                  ->whereBetween('fecha_vencimiento', [today(), today()->addDays(30)])
                                  ->orderBy('fecha_vencimiento', 'asc')
                                  ->take(5)
                                  ->get();
        
        return view('modules.dashboard.home', compact(
            'ventasHoy',
            'cantidadVentasHoy',
            'totalProductos',
            'alertasPendientes',
            'totalUsuarios',
            'productosStockBajo',
            'lotesProximosVencer'
        ));
    }
}