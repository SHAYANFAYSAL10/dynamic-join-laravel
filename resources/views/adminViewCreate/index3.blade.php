<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Join</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="module" src="{{ asset('js/columnNameFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataViewer.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/joinedDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/addTables.mjs') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @routes
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Create Report</h1>
        <form action="{{ url('/') }}/join" method="post">
            @csrf
            <div id="tablesDiv" class="mb-4">
                <div id="dynamicDiv0" class="tables">
                    <div class="form-group">
                        <select name="table[]" id="table0" class="form-control dynamic"
                            data-dependent="tableColumns0" dependent="tableColumns0">
                            <option disabled selected value="">Select Table</option>
                            @foreach ($tableNames as $tableName)
                                <option value="{{ $tableName }}">{{ $tableName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="tables" id="tableColumns0" class="form-control dynamicdatas tableColumnChanged"
                            data-dependent="tableDatas0" multiple>
                            <option value="">Select Columns</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            {{ csrf_field() }}
        </form>
        <div id="addTableDiv" class="mt-3">
            <button id="addTable" class="btn btn-success">+</button>
        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
