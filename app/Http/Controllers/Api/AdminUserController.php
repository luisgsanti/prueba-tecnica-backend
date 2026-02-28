<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    // 🔹 Listar usuarios registrados
    public function index()
    {
        $users = User::with([
            'userType',
            'answers.question'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($users);
    }

    // 🔹 Activar / Desactivar usuario
    public function toggleStatus($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'status' => $user->status
        ]);
    }
}