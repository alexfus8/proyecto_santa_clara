<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turno;
use Illuminate\Support\Facades\DB;

class TurnoController extends Controller
{
    public function _construct()
    {
    	$this->middleware('auth');
    }

    public function index(Request $request)
    {
		$turnos = Turno::all();

    	return view('admin.turno.index' , ['turnos' => $turnos]);
    }

    public function registro(Request $request)
    {
    	$newTurno = new Turno();
    	$newTurno->hora = $request->hora;
        $newTurno->estado = 1;
    	$newTurno->save();

    	return redirect()->back();
    }

    public function actualizar(Request $request, $turnoId)
    {
    	$turno = Turno::find($turnoId);
    	$turno->hora = $request->hora;
    	$turno->save();

    	return redirect()->back();
    	//dd($request->all());
    }

    public function eliminar(Request $request, $turnoId)
    {
    	$turno = Turno::find($turnoId);
    	$turno->delete();

    	return redirect()->back();
    	//dd($request->all());
    }

    public function cambiarEstado(Request $request, $turnoId){
        $turno = Turno::find($turnoId);
        $turno->estado = 0;
        $turno->save();

        return redirect()->back();
      }
}
