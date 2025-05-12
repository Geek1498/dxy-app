<!DOCTYPE html>
<html>
<head>
    <title>Bond Summaries Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">📊 Bond Yield Summaries (Admin)</h1>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-2">Week</th>
                    <th class="p-2">2Y</th>
                    <th class="p-2">10Y</th>
                    <th class="p-2">Summary</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summaries as $summary)
                    <tr class="border-t">
                        <td class="p-2">{{ $summary->week_start->format('M d') }} - {{ $summary->week_end->format('M d') }}</td>
                        <td class="p-2">{{ $summary->raw_yield_data['2Y']['start'] }}% → {{ $summary->raw_yield_data['2Y']['end'] }}%</td>
                        <td class="p-2">{{ $summary->raw_yield_data['10Y']['start'] }}% → {{ $summary->raw_yield_data['10Y']['end'] }}%</td>
                        <td class="p-2 text-sm text-gray-700">{{ Str::limit($summary->summary, 100) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
