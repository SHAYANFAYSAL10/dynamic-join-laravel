<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Report</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <script type="module" src="{{ asset('js/columnNameFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataViewer.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/joinedDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/addTables.mjs') }}" defer></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('modules/prism.min.css') }}">
    <script src="{{ asset('modules/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('modules/jquery.slim.min.js') }}"></script> --}}
    <script src="{{ asset('modules/bootstrap.min.js') }}"></script>
    <script src="{{ asset('modules/bootstrap2.min.js') }}"></script>
    {{-- <script src="{{ asset('modules/alpine.min.js') }}" defer></script>
    <script src="{{ asset('modules/popper.min.js') }}"></script>
    <script src="{{ asset('modules/prism-json.min.js') }}"></script>
    <script src="{{ asset('modules/prism.js') }}"></script>
    <script src="{{ asset('modules/prism.min.js') }}"></script>
    <script src="{{ asset('modules/cdn.min.js') }}"></script> --}}
    <link rel="stylesheet" href="{{ asset('modules/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('modules/bootstrap2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/bootstrap3.min.css') }}"> --}}
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
            text-align: right;
        }

        #addTable {
            font-size: 1.5em;
        }

        .center-button {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container center-button">
        <div class="container-bg row">
            <h1 class="mb-4">Create Report</h1>
            <form action="{{ url('/') }}/create-report" method="post">
                @csrf
                <div class="border border-secondary border-3 rounded px-3 mb-4">
                    <div>
                        <input type="text" name="name" class="form-control mt-4" id="reportName"
                            placeholder="Report Name" required>
                    </div>
                    <div>
                        <select name="users[]" id="users" class="form-select mt-4 mb-4" multiple>
                            <option disabled value="">Select Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user }}">{{ $user }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="tablesDiv" class="mb-4">
                    <div id="dynamicDiv0" class="tables border border-secondary border-3 mb-4 rounded px-3">
                        <div class="g-3">
                            <label for="table0" class="form-label"></label>
                            <select name="table[]" id="table0" class="form-select mt-0 dynamic"
                                data-dependent="tableColumns0" dependent="tableColumns0" required>
                                <option disabled selected value="">Select Table</option>
                                @foreach ($tableNames as $tableName)
                                    <option value="{{ $tableName }}">{{ $tableName }}</option>
                                @endforeach
                            </select>
                            <label for="tableColumns0" class="form-label"></label>
                            <select name="tables" id="tableColumns0"
                                class="form-select mt-0 mb-4 dynamicdatas tableColumnChanged"
                                data-dependent="tableDatas0" required multiple>
                                <option value="">Select Columns</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="addTableDiv" class="mt-3" type="button">
                    <button id="addTable" class="btn btn-secondary px-2 py-0"> + </button>
                </div>
                <div class="center-button">
                    <button type="submit" class="btn btn-info text-white px-2">Submit</button>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</body>

</html>
