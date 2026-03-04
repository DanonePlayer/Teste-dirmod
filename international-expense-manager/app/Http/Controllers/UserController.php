<?php

namespace App\Http\Controllers;

use App\Application\UseCases\RegisterUserUseCase;
use App\Application\DTOs\RegisterUserDTO;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request, RegisterUserUseCase $action)
    {
        try {
            $dto = new RegisterUserDTO(
                $request->name,
                $request->email,
                $request->cpf,
                $request->zip_code,
                $request->password
            );

            $user = $action->execute($dto);

            return response()->json(['message' => 'Usuário criado!', 'user' => $user], 211);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
