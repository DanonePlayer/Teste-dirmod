<?php

namespace App\Http\Controllers;

use App\Application\UseCases\RegisterExpenseUseCase;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request, RegisterExpenseUseCase $useCase)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|exists:users,id',
                'description' => 'required|string|max:255',
                'original_amount' => 'required|numeric|min:0.01',
                'currency' => 'required|string|size:3',
            ]);

            $expense = $useCase->execute($data);

            return response()->json([
                'message' => 'Despesa registrada com conversão!',
                'expense' => $expense
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
