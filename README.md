//correr el back
**** No pude configurar para subir al git por cuestion de tiempo****
1.Se debe configurar la base de datos en el .env
2. correr las migraciones
3. php artisan serve

// El aplicativo ya cuenta con la api Swagger
Puedes ponerlo en el navegador de preferencia: http://localhost:8000/api/documentation


Pruebas por parte del backend con postman:

//Evento: 
1. Listar Eventos (GET)
CopyMétodo: GET
URL: {{base_url}}/events
Parámetros opcionales (Query Params):

search: texto para buscar eventos
date: fecha (YYYY-MM-DD)
location: ubicación

2. Crear Evento (POST)
CopyMétodo: POST
URL: {{base_url}}/events
Body (raw JSON):
jsonCopy{
    "name": "Conferencia de Desarrollo",
    "description": "Una conferencia sobre desarrollo de software",
    "date": "2024-03-15",
    "location": "Centro de Convenciones"
}
3. Ver Detalle de Evento (GET)
CopyMétodo: GET
URL: {{base_url}}/events/1
4. Actualizar Evento (PUT)
CopyMétodo: PUT
URL: {{base_url}}/events/1
Body (raw JSON):
jsonCopy{
    "name": "Conferencia de Desarrollo 2024",
    "description": "Una conferencia actualizada sobre desarrollo de software",
    "date": "2024-03-16",
    "location": "Centro de Convenciones Internacional"
}
5. Eliminar Evento (DELETE)
CopyMétodo: DELETE
URL: {{base_url}}/events/1

//Reserva
Solicitudes Específicas
1. Obtener reservas de un evento (GET)
URL: http://127.0.0.1:8000/api/events/{event_id}/reservations
Reemplaza {event_id} con el ID real del evento.
Método: GET
Headers:
Authorization: Bearer {tu_token}
Respuesta Esperada: Lista de reservas en formato JSON.
2. Crear una nueva reserva (POST)
URL: http://127.0.0.1:8000/api/events/{event_id}/reservations
Reemplaza {event_id} con el ID real del evento.
Método: POST
Headers:
Authorization: Bearer {tu_token}
Content-Type: application/json
Body (raw, JSON):
json
Copy
Edit
{
  "user_name": "Dani",
  "user_email": "dani@example.com",
  "seats": 2
}
Respuesta Esperada: Código 201 con la reserva creada.
3. Mostrar una reserva específica (GET)
URL: http://127.0.0.1:8000/api/events/{event_id}/reservations/{reservation_id}
Método: GET
Headers:
Authorization: Bearer {tu_token}
4. Actualizar una reserva (PUT o PATCH)
URL: http://127.0.0.1:8000/api/events/{event_id}/reservations/{reservation_id}
Método: PUT o PATCH
Headers:
Authorization: Bearer {tu_token}
Content-Type: application/json
Body (raw, JSON):
json
Copy
Edit
{
  "user_name": "Dani Actualizada",
  "user_email": "dani.new@example.com",
  "seats": 3
}
Respuesta Esperada: Reserva actualizada con éxito.
5. Eliminar una reserva (DELETE)
URL: http://127.0.0.1:8000/api/events/{event_id}/reservations/{reservation_id}
Método: DELETE
Headers:
Authorization: Bearer {tu_token}
Respuesta Esperada: Código 204 sin contenido.
