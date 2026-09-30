<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderByDesc('spent_on')
            ->orderByDesc('id')
            ->get();

        return view('expenses.index', [
            'expenses' => $expenses,
        ]);
    }
}