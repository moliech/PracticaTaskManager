<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['user', 'category']);

        // Filtro por búsqueda (asume que tienes el scope 'scopeBuscar' en el modelo)
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        // Filtro por estado (asume que tienes los scopes 'scopeCompletadas' y 'scopePendientes')
        if ($request->filled('estado')) {
            if ($request->estado == 'completada') {
                $query->completadas();
            } else {
                $query->pendientes();
            }
        }

        $tareas = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('tasks.index', compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Category::all();
        return view('tasks.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'category_id'  => 'required|exists:categories,id',
        ]);

        $data = $request->all();
        $data['user_id'] = auth("api")->id(); // Ajustado a 'user_id' para coincidir con tu fillable del modelo Task

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Por si necesitas ver una tarea individual en el futuro
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $categorias = Category::all();
        // Cambiado de 'task' a 'tarea' para que coincida con tu vista edit.blade.php
        $tarea = $task; 

        return view('tasks.edit', compact('tarea', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'titulo'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'category_id'  => 'required|exists:categories,id',
            'estado'       => 'required|in:pendiente,en_progreso,completada',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarea personalizada eliminada.');
    }
}