<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
        ]);

        // 月が指定されていなければ、日本時間の今月を使う
        $month = $validated['month'] ?? now('Asia/Tokyo')->format('Y-m');

        // 「2026-09」を年と月に分ける
        [$year, $monthNumber] = explode('-', $month);

        $expenses = Expense::whereYear('spent_on', $year)
            ->whereMonth('spent_on', $monthNumber)
            ->orderByDesc('spent_on')
            ->orderByDesc('id')
            ->get();

        // 取得した支出の金額を合計する
        $total = $expenses->sum('amount');

        return view('expenses.index', [
            'expenses' => $expenses,
            'month' => $month,
            'total' => $total,
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
    
    public function edit(Expense $expense)
    {
        return view('expenses.edit', [
            'expense' => $expense,
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'spent_on' => ['required', 'date_format:Y-m-d'],
            'amount' => ['required', 'integer', 'min:1', 'max:999999999'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $expense->spent_on = $validated['spent_on'];
        $expense->amount = $validated['amount'];
        $expense->description = $validated['description'];
        $expense->save();

        return redirect()
            ->route('expenses.index')
            ->with('success', '支出を更新しました。');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', '支出を削除しました。');
    }
}