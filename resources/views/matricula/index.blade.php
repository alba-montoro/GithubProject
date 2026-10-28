@extends('template.base')

@section('before-content')
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <a href="{{ route('matricula.create') }}" class="btn btn-secondary">Create</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <table class="table table-hover">
                @foreach($matriculas as $matricula)
                    <tr>
                        <td>{{ $matricula->id }}</td>
                        <td>
                            {{ $matricula->alumno->nombre }} <!-- la función belongsTo saca los valores del alumno -->
                            {{ $matricula->alumno->apellidos }}
                        </td>
                        <td>
                            {{ $matricula->modulo->nombre }}
                            {{ $matricula->modulo->abreviatura }}
                        </td>
            
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
