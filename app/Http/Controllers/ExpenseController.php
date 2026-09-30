<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'spent_on' => ['required', 'date_format:Y-m-d'],
            'amount' => ['required', 'integer', 'min:1', 'max:999999999'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $expense = new Expense();
        $expense->spent_on = $validated['spent_on'];
        $expense->amount = $validated['amount'];
        $expense->description = $validated['description'];
        $expense->save();

        return redirect()
            ->route('expenses.index')
            ->with('success', '支出を登録しました。');
    }
}