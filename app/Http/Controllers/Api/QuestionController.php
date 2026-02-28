<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\UserType;

class QuestionController extends Controller
{
    public function byUserType($userTypeId)
    {
        // 1️⃣ Verificar que exista el tipo
        $userType = UserType::find($userTypeId);

        if (!$userType) {
            return response()->json([
                'message' => 'Tipo de usuario no existe'
            ], 404);
        }

        // 2️⃣ Verificar que esté habilitado
        if (!$userType->is_enabled) {
            return response()->json([
                'message' => 'Registro deshabilitado para este tipo de usuario'
            ], 400);
        }

        // 3️⃣ Obtener preguntas ordenadas
        $questions = Question::where('user_type_id', $userTypeId)
            ->orderBy('order_number')
            ->get(['id', 'question_text', 'order_number']);

        return response()->json($questions);
    }
}