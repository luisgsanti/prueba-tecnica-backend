<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function index()
    {
        $types = UserType::all();

        return response()->json($types);
    }

    public function toggle($id)
    {
        $type = \App\Models\UserType::find($id);

        if (!$type) {
            return response()->json([
                'message' => 'Tipo de usuario no encontrado'
            ], 404);
        }

        $type->is_enabled = !$type->is_enabled;
        $type->save();

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'is_enabled' => $type->is_enabled
        ]);
    }
}