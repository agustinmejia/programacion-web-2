@extends('layouts.app')

@section('title', 'Nuevo Estudiante – GestiEstudiantes')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('estudiantes.index') }}">Estudiantes</a>
                </li>
                <li class="breadcrumb-item active">Nuevo estudiante</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i> Agregar nuevo estudiante
            </div>
            <div class="card-body p-4">

                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-exclamation-triangle-fill me-1"></i>Corregí los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('estudiantes.store') }}">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre') }}" placeholder="Lucas" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="apellido"
                                   class="form-control @error('apellido') is-invalid @enderror"
                                   value="{{ old('apellido') }}" placeholder="García" required>
                            @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">DNI <span class="text-danger">*</span></label>
                            <input type="text" name="dni"
                                   class="form-control @error('dni') is-invalid @enderror"
                                   value="{{ old('dni') }}" placeholder="38111222" required>
                            @error('dni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nac"
                                   class="form-control @error('fecha_nac') is-invalid @enderror"
                                   value="{{ old('fecha_nac') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="text" name="telefono"
                                   class="form-control"
                                   value="{{ old('telefono') }}" placeholder="11-1234-5678">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="alumno@mail.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Estado</label>
                            <select name="estado" class="form-select">
                                @foreach (['activo', 'inactivo', 'suspendido'] as $opt)
                                    <option value="{{ $opt }}" {{ old('estado', 'activo') === $opt ? 'selected' : '' }}>
                                        {{ ucfirst($opt) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Curso</label>
                            <select name="curso_id" class="form-select">
                                <option value="">— Sin asignar —</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}"
                                        {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>{{-- /row --}}

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy-fill me-1"></i> Guardar estudiante
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection
