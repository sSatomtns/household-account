<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支出一覧</title>
</head>
<body>
    <h1>支出一覧</h1>

    @if (session('success'))
        <p role="status">{{ session('success') }}</p>
    @endif

    <h2>支出を登録</h2>

    <form method="POST" action="{{ route('expenses.store') }}">
        @csrf

        <div>
            <label for="spent_on">日付</label>
            <input
                type="date"
                id="spent_on"
                name="spent_on"
                value="{{ old('spent_on') }}"
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
                value="{{ old('amount') }}"
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
                value="{{ old('description') }}"
                maxlength="255"
                placeholder="例：昼食"
                required
            >
            @error('description')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">登録する</button>
    </form>

    <h2>登録済みの支出</h2>

    <table>
        <thead>
            <tr>
                <th scope="col">日付</th>
                <th scope="col">金額</th>
                <th scope="col">内容</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expenses as $expense)
                <tr>
                    <td>{{ $expense->spent_on }}</td>
                    <td>{{ number_format($expense->amount) }}円</td>
                    <td>{{ $expense->description }}</td>
                    <td>
                        <a href="{{ route('expenses.edit', $expense) }}">
                            編集
                        </a>

                        <form
                            method="POST"
                            action="{{ route('expenses.destroy', $expense) }}"
                            onsubmit="return confirm('この支出を削除しますか？');"
                            style="display: inline;"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">支出はまだ登録されていません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>