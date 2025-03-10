<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class EventController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Obtener lista de eventos",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Buscar por nombre",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Filtrar por fecha (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="location",
     *         in="query",
     *         description="Filtrar por ubicación",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de eventos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="description", type="string"),
     *                     @OA\Property(property="date", type="string", format="date"),
     *                     @OA\Property(property="location", type="string"),
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function index(Request $request): LengthAwarePaginator
    {
        $query = Event::query();

        // Apply filters
        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return $query->paginate(10);
    }

    /**
     * @OA\Post(
     *     path="/api/events",
     *     summary="Crear un nuevo evento",
     *     tags={"Events"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","date","location"},
     *             @OA\Property(property="name", type="string", maxLength=255),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="location", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Evento creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="location", type="string")
     *         )
     *     )
     * )
     */

    public function store(Request $request): Event
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'date' => 'required|date',
            'location' => 'required'
        ]);

        $event = new Event($validated);
        $event->save();

        return $event;
    }

    public function show(Event $event): Event
    {
        return $event->load('reservations');
    }

    /**
    *
    * @return update Event
    */

    public function update(Request $request, Event $event): Event
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'date' => 'required|date',
            'location' => 'required'
        ]);

        $event->update($validated);
        return $event;
    }

    /**
    * return response
    */

    public function destroy(Event $event): Response
    {
        $event->delete();
        return response()->noContent();
    }
}
