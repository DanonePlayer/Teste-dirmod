<?php

namespace App\Http\Controllers;

use App\Application\UseCases\RegisterExpenseUseCase;
use Illuminate\Http\Request;
use App\Application\UseCases\ListUserExpensesUseCase;

class ExpenseController extends Controller
{

    public function index(Request $request, ListUserExpensesUseCase $useCase)
    {
        try {
            $currentUserId = $request->header('X-User-Id');

            if (!$currentUserId) {
                return response()->json(['error' => 'Usuário não identificado. Envie o X-User-Id no header.'], 401);
            }
            $expenses = $useCase->execute((int)$currentUserId);

            return response()->json($expenses);

        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

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
