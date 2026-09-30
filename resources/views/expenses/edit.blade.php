<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支出の編集</title>
</head>
<body>
    <h1>支出の編集</h1>

    <form
        method="POST"
        action="{{ route('expenses.update', $expense) }}"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="spent_on">日付</label>
            <input
                type="date"
                id="spent_on"
                name="spent_on"
                value="{{ old('spent_on', $expense->spent_on) }}"
                required
            >
            @error('spent_on')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="amount">金額（円）</label>
            <input
                type="number"
                id="amount"
                name="amount"
                value="{{ old('amount', $expense->amount) }}"
                min="1"
                max="999999999"
                step="1"
                required
            >
            @error('amount')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description">内容</label>
            <input
                type="text"
                id="description"
                name="description"
                value="{{ old('description', $expense->description) }}"
                maxlength="255"
                required
            >
            @error('description')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">更新する</button>
        <a href="{{ route('expenses.index') }}">キャンセル</a>
    </form>
</body>
</html>