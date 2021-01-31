<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumnos=Alumnos::orderBy('nombre')->paginate(5);
        return view('academia.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //validaciones genericas
        $request->validate([
            'nombre' => ['required'],
            'apellidos' => ['required'],
            'email' => ['required', 'unique:alumnos,mail'],
            'telefono' => ['nullable'],
        ]);
        //cojo los datos por que voy a modificar del request
        //voy a poner nom y ape la primera letra en mayusculas
        $alumno = new Alumnos();
        $alumno->nombre = ucwords($request->nombre);
        $alumno->apellidos = ucwords($request->apellidos);
        $alumno->mail = $request->mail;
        $alumno->teñefono = $request->telefono;
        //Comprobamos si hemos subido una foto
        if ($request->has('foto')) {
            $request->validate([
                'foto' => ['image'],
            ]);
            $file = $request->file('foto');
            $nom = 'foto/'.time().'_'.$file->getClientOriginalName();
            //Guardamos el fichero en public
            Storage::disk('public')->put($nom, \File::get($file));
            //le damos a alumno en nombre que le hemos puesto al fichero
            $alumno->foto = "img/$nom";
        }
        //Guardamos el alumno
        $alumno->save();

        return redirect()->route('alumnos.index')->with('mensaje', 'Alumno Guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function show(Alumnos $alumnos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumnos $alumno)
    {
        return view('academia.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumnos $alumnos)
    {
        //validaciones genericas
        $request->validate([
            'nombre' => ['required'],
            'apellidos' => ['required'],
            'email' => ['required', 'unique:alumnos,email'],
            'telefono' => ['nullable'],
        ]);

        if ($request->has('foto')) {
            $request->validate([
                'foto' => ['image'],
            ]);
            //Todo bien hemos subido un archivo y es de imagen
            $file = $request->file('foto');
            //Creo un nombre
            $nombre = 'alumnos/'.time().'_'.$file->getClientOriginalName();
            //Guardo el archivo de imagen
            Storage::disk('public')->put($nombre, \File::get($file));
            //si he subido un afoto nueva borro la vieja, A NO SER que sea default.jpg
            if (basename($nombre->foto) != 'default.png') {
                unlink($nombre->foto);
            }
            //ahora actualizo el alumno
            $alumnos->update($request->all());
            $alumnos->update(['foto' => "img/$nombre"]);
        } else {
            $alumnos->update($request->all());
        }

        return redirect()->route('alumnos.index')->with('mensaje', 'Alumno Modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alumnos  $alumnos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumnos $alumno)
    {
        //
        $foto = $alumno->foto;
        if (basename($foto) != 'default.png') {
            unlink($alumno->foto);
        }
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('mensaje', 'Alumno borrado');
    }
}
