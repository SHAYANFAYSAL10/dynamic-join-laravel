<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @vite('resources/css/app.css')
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
