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
    @vite('resources/css/app.css')
    @routes
</head>

<body>
    <h1>View Reports</h1>
    <table border="1">
        <thead>
            <tr>
                @foreach ($reports[0] as $attribute => $value)
                    <th>{{ ucfirst($attribute) }}</th>
                @endforeach
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    @foreach ($report as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                    <td><a href="{{ url('/view-report/' . $report->id) }}"
                            title="View Report Data"><button>View</button></a>
                        <button>Edit</button>
                        <form method="POST" action="{{ url('view-report/' . $report->id) }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" onclick="return confirm("Confirm delete?")">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
