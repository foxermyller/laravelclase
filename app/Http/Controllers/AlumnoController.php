<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;

class AlumnoController extends Controller
{
    // Listar todos los alumnos
    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }

    // Mostrar el formulario para crear un alumno
    public function create()
    {
        return view('alumnos.create');
    }

    // Guardar un nuevo alumno en la base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:alumnos,email',
            'edad' => 'required|integer|min:0',
        ]);

        Alumno::create($validated);

        return redirect('/alumnos')->with('success', 'Alumno creado exitosamente.');
    }

    // Mostrar los detalles de un alumno
    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    // Mostrar el formulario para editar un alumno
    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    // Actualizar un alumno en la base de datos
    public function update(Request $request, Alumno $alumno)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:alumnos,email,' . $alumno->id,
            'edad' => 'required|integer|min:0',
        ]);

        $alumno->update($validated);

        return redirect('/alumnos')->with('success', 'Alumno actualizado exitosamente.');
    }

    // Eliminar un alumno de la base de datos
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        return redirect('/alumnos')->with('success', 'Alumno eliminado exitosamente.');
    }
}
