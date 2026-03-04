<?php

namespace App\Application\UseCases;

use Illuminate\Database\Eloquent\Collection;

class ListUserExpensesUseCase
{
    public function execute(int $userId): Collection
    {
        return \App\Models\Expense::where('user_id', $userId)->get();
    }
}
