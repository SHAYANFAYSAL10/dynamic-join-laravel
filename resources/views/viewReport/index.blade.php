<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    {{-- <script type="module" src="{{ asset('js/columnNameFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataViewer.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/joinedDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/addTables.mjs') }}" defer></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @routes
</head>

<body>
    <h1>View Data</h1>
    <table border="1">
        <thead>
            <tr>
                @foreach ($data[0] as $attribute => $value)
                    <th>{{ ucfirst($attribute) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
