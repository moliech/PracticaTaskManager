@extends('layouts.app')

@section('titulo', 'Listado de Tareas')
@section('titulo_pagina', 'Listado de Tareas')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-4 mb-3 mb-md-0">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nueva Tarea
        </a>
    </div>
    <div class="col-md-8">
        <form method="GET" action="{{ route('tasks.index') }}" class="row g-2 justify-content-md-end">
            <div class="col-sm-5">
                <input type="text" 
                       name="buscar" 
                       class="form-control" 
                       placeholder="Buscar tarea..." 
                       value="{{ request('buscar') }}">
            </div>
            
            <div class="col-sm-4">
                <select name="estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_progreso" {{ request('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                    <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                </select>
            </div>
            
            <div class="col-sm-3 d-flex gap-1">
                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                @if(request()->filled('buscar') || request()->filled('estado'))
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger" title="Limpiar filtros">
                        <i class="fas fa-undo"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 40%">Título</th>
                        <th style="width: 15%">Estado</th>
                        <th style="width: 15%">Categoría</th>
                        <th style="width: 15%">Fecha Límite</th>
                        <th style="width: 10%" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tareas as $tarea)
                        <tr>
                            <td>{{ $tarea->id }}</td>
                            <td><strong>{{ $tarea->titulo }}</strong></td>
                            <td>
                                @php
                                    $color = match($tarea->estado) {
                                        'completada' => 'success',
                                        'en_progreso' => 'info',
                                        default => 'warning'
                                    };
                                @endphp
                                <span class="badge bg-{{ $color }} text-capitalize">{{ $tarea->estado }}</span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-tag me-1 small"></i>{{ $tarea->category->nombre ?? 'Sin categoría' }}
                                </span>
                            </td>
                            <td>
                                @if($tarea->fecha_limite)
                                    <i class="far fa-calendar-alt me-1 text-secondary"></i> {{ \Carbon\Carbon::parse($tarea->fecha_limite)->format('d/m/Y') }}
                                @else
                                    <span class="text-muted italic">No definida</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('tasks.edit', $tarea->id) }}" class="btn btn-sm btn-warning" title="Editar Tarea">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('tasks.destroy', $tarea->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                No se encontraron tareas que coincidan con los criterios.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection