@extends('layouts.app')

@section('title', 'Editar Estudiante – GestiEstudiantes')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('estudiantes.index') }}">Estudiantes</a>
                </li>
                <li class="breadcrumb-item active">Editar estudiante</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square"></i>
                Editando: <strong>{{ $estudiante->nombre_completo }}</strong>
            </div>
            <div class="card-body p-4">

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

                {{-- PUT se simula con un campo oculto (los navegadores solo soportan GET y POST) --}}
                <form method="POST" action="{{ route('estudiantes.update', $estudiante) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre', $estudiante->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="apellido"
                                   class="form-control @error('apellido') is-invalid @enderror"
                                   value="{{ old('apellido', $estudiante->apellido) }}" required>
                            @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">DNI <span class="text-danger">*</span></label>
                            <input type="text" name="dni"
                                   class="form-control @error('dni') is-invalid @enderror"
                                   value="{{ old('dni', $estudiante->dni) }}" required>
                            @error('dni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nac"
                                   class="form-control"
                                   value="{{ old('fecha_nac', $estudiante->fecha_nac?->format('Y-m-d')) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="text" name="telefono"
                                   class="form-control"
                                   value="{{ old('telefono', $estudiante->telefono) }}">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $estudiante->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Estado</label>
                            <select name="estado" class="form-select">
                                @foreach (['activo', 'inactivo', 'suspendido'] as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('estado', $estudiante->estado) === $opt ? 'selected' : '' }}>
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
                                        {{ old('curso_id', $estudiante->curso_id) == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-between align-items-center">
                        <small class="text-muted">
                            Creado: {{ $estudiante->created_at->format('d/m/Y H:i') }}
                            &nbsp;|&nbsp;
                            Actualizado: {{ $estudiante->updated_at->format('d/m/Y H:i') }}
                        </small>
                        <div class="d-flex gap-2">
                            <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-floppy-fill me-1"></i> Guardar cambios
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection
