<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserType;
use App\Models\User;
use App\Models\Answer;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // 1️⃣ Validaciones base
        $validated = $request->validate([
            'user_type_id' => 'required|exists:user_types,id',
            'name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'business_name' => 'nullable|string|max:150',
            'nit' => 'nullable|string|max:50|unique:users,nit',
            'document_type' => 'required|string|max:50',
            'document_number' => 'required|string|max:50|unique:users,document_number',
            'email' => 'required|email|max:150|unique:users,email',
            'phone' => 'required|string|max:30',
            'city' => 'required|string|max:100',
            'accepted_terms' => 'required|boolean',
            'answers' => 'required|array|min:5',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_text' => 'required|string'
        ]);

        // 2️⃣ Verificar que aceptó términos
        if (!$validated['accepted_terms']) {
            return response()->json([
                'message' => 'Debe aceptar los términos y condiciones'
            ], 400);
        }

        // 3️⃣ Verificar que el tipo de usuario esté habilitado
        $userType = UserType::find($validated['user_type_id']);

        if (!$userType->is_enabled) {
            return response()->json([
                'message' => 'Este tipo de registro está deshabilitado'
            ], 400);
        }

        // 4️⃣ Validación especial para persona jurídica
        if ($userType->name === 'juridico') {
            if (empty($validated['business_name']) || empty($validated['nit'])) {
                return response()->json([
                    'message' => 'Razón social y NIT son obligatorios para persona jurídica'
                ], 400);
            }
        }

        // 5️⃣ Transacción para guardar todo
        DB::beginTransaction();

        try {

            $user = User::create([
                'user_type_id' => $validated['user_type_id'],
                'name' => $validated['name'],
                'last_name' => $validated['last_name'],
                'business_name' => $validated['business_name'] ?? null,
                'nit' => $validated['nit'] ?? null,
                'document_type' => $validated['document_type'],
                'document_number' => $validated['document_number'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'city' => $validated['city'],
                'accepted_terms' => $validated['accepted_terms'],
                'status' => 'active'
            ]);

            foreach ($validated['answers'] as $answer) {
                Answer::create([
                    'user_id' => $user->id,
                    'question_id' => $answer['question_id'],
                    'answer_text' => $answer['answer_text']
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Usuario registrado correctamente'
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Error al registrar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}