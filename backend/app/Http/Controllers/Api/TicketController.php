<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Ticket::with('cliente');

        if ($request->has('prioridad') && $request->prioridad) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->has('fecha_desde') && $request->fecha_desde) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta') && $request->fecha_hasta) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->has('titulo') && $request->titulo) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:120',
            'descripcion' => 'required|string',
            'prioridad' => ['required', Rule::in(['baja', 'media', 'alta'])],
            'cliente_id' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::create($validated);

        return response()->json($ticket->load('cliente'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
