<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    // GET /estudiantes — Listar con búsqueda y filtros
    public function index(Request $request): View
    {
        $query = Estudiante::with('curso');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nombre',   'like', "%{$q}%")
                    ->orWhere('apellido', 'like', "%{$q}%")
                    ->orWhere('dni',      'like', "%{$q}%")
                    ->orWhere('email',    'like', "%{$q}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('curso') && $request->curso > 0) {
            $query->where('curso_id', $request->curso);
        }

        $estudiantes = $query->orderBy('apellido')->orderBy('nombre')->get();
        $cursos      = Curso::orderBy('nombre')->get();

        return view('estudiantes.index', compact('estudiantes', 'cursos'));
    }

    // GET /estudiantes/create — Formulario de alta
    public function create(): View
    {
        $cursos = Curso::orderBy('nombre')->get();

        return view('estudiantes.create', compact('cursos'));
    }

    // POST /estudiantes — Guardar nuevo estudiante
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre'    => ['required', 'string', 'max:100'],
            'apellido'  => ['required', 'string', 'max:100'],
            'dni'       => ['required', 'string', 'max:20', 'unique:estudiantes,dni'],
            'email'     => ['required', 'email', 'max:150'],
            'telefono'  => ['nullable', 'string', 'max:30'],
            'fecha_nac' => ['nullable', 'date'],
            'curso_id'  => ['nullable', 'exists:cursos,id'],
            'estado'    => ['required', 'in:activo,inactivo,suspendido'],
        ]);

        Estudiante::create($request->all());

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante creado correctamente.');
    }

    // GET /estudiantes/{id}/edit — Formulario de edición
    public function edit(Estudiante $estudiante): View
    {
        $cursos = Curso::orderBy('nombre')->get();

        return view('estudiantes.edit', compact('estudiante', 'cursos'));
    }

    // PUT /estudiantes/{id} — Guardar cambios
    public function update(Request $request, Estudiante $estudiante): RedirectResponse
    {
        $request->validate([
            'nombre'    => ['required', 'string', 'max:100'],
            'apellido'  => ['required', 'string', 'max:100'],
            'dni'       => ['required', 'string', 'max:20', "unique:estudiantes,dni,{$estudiante->id}"],
            'email'     => ['required', 'email', 'max:150'],
            'telefono'  => ['nullable', 'string', 'max:30'],
            'fecha_nac' => ['nullable', 'date'],
            'curso_id'  => ['nullable', 'exists:cursos,id'],
            'estado'    => ['required', 'in:activo,inactivo,suspendido'],
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    // DELETE /estudiantes/{id} — Eliminar
    public function destroy(Estudiante $estudiante): RedirectResponse
    {
        $estudiante->delete();

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante eliminado correctamente.');
    }
}
