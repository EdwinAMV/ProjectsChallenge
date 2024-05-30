<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    // app/Http/Controllers/ScoreController.php

    public function store(Request $request)
    {
        $request->validate(['score' => 'required|integer']);

        $score = Score::create([
            'user_id' => auth()->id(),
            'score' => $request->input('score'),
        ]);

        return response()->json($score, 201);
    }
    public function getLastFiveScores()
    {
        // Obtén el ID del usuario autenticado
        $userId = auth()->id();

        // Verifica si el usuario está autenticado
        if ($userId) {
            // Realiza la consulta directamente en el modelo Score
            $scores = Score::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(['score', 'created_at']);

            // Devuelve las puntuaciones en formato JSON
            return response()->json($scores);
        }

        // Si el usuario no está autenticado, devuelve una respuesta de error
        return response()->json(['error' => 'No autenticado'], 401);
    }
}
