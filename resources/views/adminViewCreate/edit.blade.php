<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Join</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script type="module" src="{{ asset('js/columnNameFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataViewer.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/joinedDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/addTables.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/editReport.mjs') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    @routes
    <style>
        body {
            background-color: #ffffff;
        }

        .container-bg {
            background-color: #f5f2f0;
            padding: 20px;
            border-radius: 10px;
        }

        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }



        .form-group {
            margin-bottom: 20px;
        }

        #addTableDiv {
            text-align: center;
        }

        #addTable {
            font-size: 1.5em;
        }

        .center-button {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Style for Select2 */
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>

<body>
    @php
        $resultsData = json_encode($results);
    @endphp
    <div class="container center-button">
        <div class="container-bg row">
            <h1 class="mb-4">Create Report</h1>
            <form action="{{ url('view-report/' . $id . '/edit') }}" method="post">
                @csrf
                <div>
                    <input type="text" name="name" class="form-control" id="reportName" placeholder="Report Name">
                </div>
                <div>
                    <select name="users[]" id="users" class="form-select mt-4" multiple>
                        <option disabled value="">Select Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user }}">{{ $user }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="tablesDiv" class="mb-4">
                    <div id="dynamicDiv0" class="tables">
                        <div class="g-3">
                            <label for="table0" class="form-label"></label>
                            <select name="table[]" id="table0" class="form-select dynamic"
                                data-dependent="tableColumns0" dependent="tableColumns0">
                                <option disabled selected value="">Select Table</option>
                                @foreach ($tableNames as $tableName)
                                    <option value="{{ $tableName }}">{{ $tableName }}</option>
                                    {{-- <option value="{{ $tableName }}"
                                        {{ $tableName === implode(', ', array_keys($results['tables'][0])) ? 'selected' : '' }}>
                                        {{ $tableName }} --}}
                                    </option>
                                @endforeach
                            </select>
                            <label for="tableColumns0" class="form-label"></label>
                            <select name="tables" id="tableColumns0"
                                class="form-select mt-0 dynamicdatas tableColumnChanged" data-dependent="tableDatas0"
                                multiple>
                                {{-- <option value="">Select Columns</option> --}}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="center-button">
                    <button type="submit" class="btn btn-info text-white px-2">Submit</button>
                </div>
                {{ csrf_field() }}
            </form>
            <div id="addTableDiv" class="mt-3">
                <button id="addTable" class="btn btn-secondary px-4 py-0"> + </button>
            </div>
        </div>
    </div>

    {{-- <script>
        $(document).ready(function() {
            $('.dynamicdatas').select2(); // Apply Select2 to the elements with the 'dynamicdatas' class
        });
    </script> --}}
    <script type="module">
        window.reportsData = {!! $resultsData !!};
    </script>
</body>

</html>
