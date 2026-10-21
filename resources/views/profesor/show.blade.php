@extends('template.base')

@section('css')
<link href="{{ asset('assets/style/show.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container my-5">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="card text-center">
                <img src="{{ asset('assets/img/profesora.jpg') }}" class="card-img-top" alt="Profesor@">
                <div class="card-body">
                    <h5 class="card-title">{{ $profesor->nombre . ' ' . $profesor->apellidos }}</h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="card-title">{{ $profesor->especialidad }}</h4>
                    <h4 class="card-title">{{ $profesor->fecha_alta->format('d/m/Y') }}</h4>
                    <h4 class="card-title">{{ $profesor->salario }} €</h4>
                    <a href="{{ route('profesor.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection