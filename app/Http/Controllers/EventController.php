<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showCalendar()
    {
        // Obtén el usuario actualmente autenticado
        $user = auth()->user();

        // Accede a la relación "events" para obtener los eventos asociados con el usuario
        $events = $user->events;

        // Pasa los eventos a la vista
        return view('DEVCHALLENGE3/calendar', compact('events'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Event::$rules);

        $event = new Event;
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->color = $request->input('color');
        $event->start = $request->input('start');
        $event->end = $request->input('end');

        // Asigna el usuario actual al evento
        $event->user_id = auth()->id();

        // Guarda el evento en la base de datos
        $event->save();

        // Redirige a la página de calendario o a donde sea necesario
        return redirect()->route('calendar')->with('success', 'Evento creado correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'description' => 'nullable',
            'color' => 'nullable',
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'required|date_format:Y-m-d\TH:i|after:start',
        ];

        $request->validate($rules);

        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('calendar')->with('error', 'Evento no encontrado');
        }

        if ($request->input('color') == null) {

            $event->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
            ]);
        } else {
            $event->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'color' => $request->input('color'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
            ]);
        }

        return redirect()->route('calendar')->with('success', 'Evento actualizado con éxito');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('calendar')->with('error', 'Evento no encontrado');
        }

        $event->delete();

        return redirect()->route('calendar')->with('success', 'Evento eliminado con éxito');
    }
}
