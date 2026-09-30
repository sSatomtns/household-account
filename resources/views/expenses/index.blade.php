<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支出一覧</title>
</head>
<body>
    <h1>支出一覧</h1>

    <table>
        <thead>
            <tr>
                <th scope="col">日付</th>
                <th scope="col">金額</th>
                <th scope="col">内容</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expenses as $expense)
                <tr>
                    <td>{{ $expense->spent_on }}</td>
                    <td>{{ number_format($expense->amount) }}円</td>
                    <td>{{ $expense->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">支出はまだ登録されていません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>