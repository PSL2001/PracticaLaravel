@extends('plantillas.plantilla1')
@section('titulo')
academia
@endsection
@section('cabecera')
Academia S.L.
@endsection
@section('contenido')
@if($text=Session::get("mensaje"))
    <p class="bg-secondary text-white p-2 my-3">{{$text}}</p>
@endif
<a href="{{route('alumnos.create')}}" class="btn btn-success mb-3"><i class="fa fa-plus"></i>Crear Alumno</a>
    <table class="table table-striped table-primary">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Correo</th>
                <th scope="col">Foto</th>
                <th scope="col">Telefono</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $item)
            <tr style="vertical-align: middle">
                <td>{{$item->id}}</td>
                <td>{{$item->nombre}}</td>
                <td>{{$item->apellidos}}</td>
                <td>{{$item->email}}</td>
                <td><img src="{{asset($item->foto)}}" width="90rem" height="90rem" class="rounded-circle"></td>
                <td>{{$item->telefono}}</td>
                <td>
                    <form name="a" action={{route('alumnos.destroy', $item)}} method="POST" class="form-inline">
                        @csrf
                        @method("DELETE")
                        <a href="{{route('alumnos.edit', $item)}}" class="btn btn-primary btn-lg"><i class="fa fa-edit"></i>Editar</a>
                        <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('¿Borrar marca?')"><i class="fad fa-trash-alt"></i>Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$alumnos->links()}}
@endsection
