@extends('layouts.app')

@section('title', 'Estudiantes – GestiEstudiantes')

@section('content')

{{-- Encabezado --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0 fw-bold text-primary">
            <i class="bi bi-people-fill me-2"></i>Estudiantes
        </h2>
        <small class="text-muted">{{ $estudiantes->count() }} registro(s) encontrado(s)</small>
    </div>
    <a href="{{ route('estudiantes.create') }}" class="btn btn-primary px-4">
        <i class="bi bi-person-plus-fill me-1"></i> Nuevo estudiante
    </a>
</div>

{{-- Flash message --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Filtros --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('estudiantes.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Buscar</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control"
                           placeholder="Nombre, apellido, DNI o email…"
                           value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Curso</label>
                <select name="curso" class="form-select">
                    <option value="0">Todos los cursos</option>
                    @foreach ($cursos as $curso)
                        <option value="{{ $curso->id }}" {{ request('curso') == $curso->id ? 'selected' : '' }}>
                            {{ $curso->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Estado</label>
                <select name="estado" class="form-select">
                    <option value="">Todos</option>
                    @foreach (['activo', 'inactivo', 'suspendido'] as $opt)
                        <option value="{{ $opt }}" {{ request('estado') === $opt ? 'selected' : '' }}>
                            {{ ucfirst($opt) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary" title="Limpiar">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabla --}}
<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-table"></i> Listado de estudiantes
    </div>
    <div class="card-body p-0">
        @if ($estudiantes->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                No se encontraron estudiantes con esos criterios.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre completo</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estudiantes as $i => $estudiante)
                            <tr>
                                <td class="text-muted small">{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $estudiante->nombre_completo }}</td>
                                <td>{{ $estudiante->dni }}</td>
                                <td>
                                    <a href="mailto:{{ $estudiante->email }}" class="text-decoration-none">
                                        {{ $estudiante->email }}
                                    </a>
                                </td>
                                <td>{{ $estudiante->telefono ?? '—' }}</td>
                                <td>{{ $estudiante->curso?->nombre ?? '—' }}</td>
                                <td>
                                    @php
                                        $colores = ['activo' => 'success', 'inactivo' => 'secondary', 'suspendido' => 'danger'];
                                    @endphp
                                    <span class="badge bg-{{ $colores[$estudiante->estado] ?? 'secondary' }} text-capitalize">
                                        {{ $estudiante->estado }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('estudiantes.edit', $estudiante) }}"
                                       class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Eliminar"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminar"
                                            data-id="{{ $estudiante->id }}"
                                            data-nombre="{{ $estudiante->nombre_completo }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Modal confirmación eliminar --}}
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que querés eliminar a <strong id="modalNombre"></strong>?
                <p class="text-muted small mt-2 mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formEliminar" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i> Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('modalEliminar').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('modalNombre').textContent = btn.dataset.nombre;
    document.getElementById('formEliminar').action = '/estudiantes/' + btn.dataset.id;
});
</script>
@endpush
