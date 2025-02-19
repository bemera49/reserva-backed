<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/events/{event_id}/reservations",
     *     summary="Obtener reservas de un evento",
     *     tags={"Reservations"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="event_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de reservas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="event_id", type="integer"),
     *                     @OA\Property(property="user_name", type="string"),
     *                     @OA\Property(property="user_email", type="string"),
     *                     @OA\Property(property="seats", type="integer")
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function index(Event $event)
    {
        return $event->reservations()->paginate(10);
    }

    /**
     * @OA\Post(
     *     path="/api/events/{event_id}/reservations",
     *     summary="Crear una nueva reserva",
     *     tags={"Reservations"},
     *     @OA\Parameter(
     *         name="event_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_name","user_email","seats"},
     *             @OA\Property(property="user_name", type="string"),
     *             @OA\Property(property="user_email", type="string", format="email"),
     *             @OA\Property(property="seats", type="integer", minimum=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reserva creada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="event_id", type="integer"),
     *             @OA\Property(property="user_name", type="string"),
     *             @OA\Property(property="user_email", type="string"),
     *             @OA\Property(property="seats", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evento no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada inválidos"
     *     )
     * )
     */

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'user_name' => 'required',
            'user_email' => 'required|email',
            'seats' => 'required|integer|min:1'
        ]);

        return $event->reservations()->create($validated);
    }

    public function show(Event $event, Reservation $reservation)
    {
        return $reservation;
    }

    public function update(Request $request, Event $event, Reservation $reservation)
    {
        $validated = $request->validate([
            'user_name' => 'required',
            'user_email' => 'required|email',
            'seats' => 'required|integer|min:1'
        ]);

        $reservation->update($validated);
        return $reservation;
    }

    public function destroy(Event $event, Reservation $reservation)
    {
        $reservation->delete();
        return response()->noContent();
    }
}
