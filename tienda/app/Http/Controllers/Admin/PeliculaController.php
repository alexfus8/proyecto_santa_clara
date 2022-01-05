<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelicula;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Response;

class PeliculaController extends Controller
{
    public function _construct()
    {
    	$this->middleware('auth');
    }

    public function index(Request $request)
    {
		$peliculas = Pelicula::all();

    	return view('admin.pelicula.index' , ['peliculas' => $peliculas]);
    }

    public function registro(Request $request)
    {

    	$newPelicula = new Pelicula();
    	$newPelicula->nombre = $request->nombre;
        $newPelicula->fecha_publicacion = $request->fecha_publicacion;
        $newPelicula->estado = 1;
        if($request->hasfile('imagen')){
            $file=$request->file('imagen');
            $destinationPath= 'images/administracion/imagen/';
            $filename= time() . '-' . $file->getClientOriginalName();
            $uploadSuccess= $request->file('imagen')->move($destinationPath,$filename);
            $newPelicula->imagen=$destinationPath . $filename;
        }
    	$newPelicula->save();

        if($newPelicula!=null){
            return redirect()->back();
        }
    }

    public function actualizar(Request $request, $peliculaId)
    {
    	$pelicula = Pelicula::find($peliculaId);
    	$pelicula->nombre = $request->nombre;
        $pelicula->fecha_publicacion = $request->fecha_publicacion;
        if($request->hasfile('imagen')){
            $file=$request->file('imagen');
            $destinationPath= 'images/administracion/imagen/';
            $filename= time() . '-' . $file->getClientOriginalName();
            $uploadSuccess= $request->file('imagen')->move($destinationPath,$filename);
            $pelicula->imagen=$destinationPath . $filename;
        }
    	$pelicula->save();

    	return redirect()->back();
    	//dd($request->all());
    }

    public function eliminar(Request $request, $peliculaId)
    {
    	$pelicula = Pelicula::find($peliculaId);
    	$pelicula->delete();

    	return redirect()->back();
    	//dd($request->all());
    }

    public function cambiarEstado(Request $request, $peliculaId){
        $pelicula = Pelicula::find($peliculaId);
        $pelicula->estado = 0;
        $pelicula->save();

        return redirect()->back();
      }
}
