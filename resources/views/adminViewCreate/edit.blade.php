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
    {{-- <script type="module" src="{{ asset('js/joinedDataFetcher.mjs') }}" defer></script> --}}
    <script type="module" src="{{ asset('js/addTables.mjs') }}" defer></script>
    {{-- <script type="module" src="{{ asset('js/editReport.mjs') }}" defer></script> --}}
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
    <div class="container center-button">
        <div class="container-bg row">
            <h1 class="mb-4">Create Report</h1>
            <form action="{{ url('view-report/' . $id . '/edit') }}" method="post">
                @csrf
                {{-- @method('PUT') --}}
                <div>
                    <input type="text" name="name" class="form-control" id="reportName"
                        value="{{ $name }}"></input>
                </div>
                <div>
                    <select name="users[]" id="users" class="form-select mt-4" multiple>
                        <option disabled value="">Select Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user }}" {{ in_array($user, $selectedUsers) ? 'selected' : '' }}>
                                {{ $user }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div id="tablesDiv" class="mb-4">
                    @foreach ($view->tables as $index => $tables)
                        @foreach ($tables as $table => $columns)
                            <div id="dynamicDiv{{ $index }}" class="tables">
                                <div class="g-3">
                                    <label for="table{{ $index }}" class="form-label"></label>
                                    <select name="table[]" id="table{{ $index }}" class="form-select dynamic"
                                        data-dependent="tableColumns{{ $index }}"
                                        dependent="tableColumns{{ $index }}">
                                        <option disabled selected value="">Select Table</option>
                                        @foreach ($tableNames as $tableName)
                                            <option value="{{ $tableName }}"
                                                {{ $tableName == $table ? 'selected' : '' }}>{{ $tableName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- @php
                                    dd($view->tables);
                                @endphp --}}
                                    <label for="tableColumns{{ $index }}" class="form-label"></label>
                                    <select name="tables[{{ $index }}][{{ $table }}][]"
                                        id="tableColumns{{ $index }}"
                                        class="form-select mt-0 dynamicdatas tableColumnChanged"
                                        data-dependent="tableDatas{{ $index }}" multiple>
                                        @foreach ($selectedTables[$table] as $column)
                                            <option value="{{ $column }}"
                                                {{ in_array($column, $columns) ? 'selected' : '' }}>
                                                {{ $column }}
                                            </option>
                                            {{-- <option value="{{ $column }}">{{ $column }}</option> --}}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                        @if ($index !== 0)
                            <script type="module">
                                import {
                                    incrementnumberOfTables
                                } from "{{ asset('js/addTables.mjs') }}";
                                document.addEventListener("DOMContentLoaded", function() {
                                    incrementnumberOfTables();
                                });
                            </script>
                            <div id="joinOnDiv{{ $index }}"><select id="tablesJoin{{ $index }}"
                                    name="joins[{{ $index - 1 }}][join_type]"
                                    class="form-select mt-4 dynamicdatas joins"
                                    dependent1="leftTable{{ $index }}"
                                    dependent2="rightTable{{ $index }}" style="margin-bottom: 20px;">
                                    <option value="" disabled="">Select Join Type</option>
                                    <option value="inner"
                                        {{ $view->joins[$index - 1]->join_type === 'inner' ? 'selected' : '' }}>Inner
                                        Join</option>
                                    <option value="left"
                                        {{ $view->joins[$index - 1]->join_type === 'left' ? 'selected' : '' }}>Left
                                        Join</option>
                                    <option value="right"
                                        {{ $view->joins[$index - 1]->join_type === 'right' ? 'selected' : '' }}>Right
                                        Join</option>
                                    <option value="cross"
                                        {{ $view->joins[$index - 1]->join_type === 'cross' ? 'selected' : '' }}>Cross
                                        Join</option>
                                </select>
                                <div class="d-flex flex-row">
                                    <div class="flex-grow-1">
                                        <select id="leftTable{{ $index }}"
                                            name="joins[{{ $index - 1 }}][left_table]"
                                            class="form-select dynamicdatas jointablenames leftTablesJoin"
                                            dependent="joinOnDiv{{ $index }}"
                                            data-dependent="leftTableColumn{{ $index }}"
                                            style="{{ $view->joins[$index - 1]->join_type === 'cross' ? 'display: none;' : 'display: block; margin-bottom: 20px;' }}">
                                            <option value="" disabled="">Select Join Table</option>
                                            @if ($view->joins[$index - 1]->join_type !== 'cross')
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($view->tables as $tables)
                                                    @foreach ($tables as $table => $columns)
                                                        <option value="{{ $table }}"
                                                            {{ $view->joins[$index - 1]->left_table === $table ? 'selected' : '' }}>
                                                            {{ $table }}</option>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        if ($i == $index + 1) {
                                                            break;
                                                        }
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </select>
                                        {{-- @for ($i = 0; $i <= $index; $i++)
                                            {{ $view['tables'][$i][$table][0] }}
                                        @endfor --}}
                                        <select name="joins[{{ $index - 1 }}][left_column]"
                                            id="leftTableColumn{{ $index }}"
                                            class="form-select joinTables leftTablesColumns"
                                            data-dependent="leftTable{{ $index }}"
                                            style="{{ $view->joins[$index - 1]->join_type === 'cross' ? 'display: none;' : 'display: block; margin-bottom: 20px;' }}">
                                            <option value="" disabled="">Select Join Column</option>
                                            @if ($view->joins[$index - 1]->join_type !== 'cross')
                                                @foreach ($selectedTables[$view->joins[$index - 1]->left_table] as $column)
                                                    <option value="{{ $column }}"
                                                        {{ $view->joins[$index - 1]->left_column === $column ? 'selected' : '' }}>
                                                        {{ $column }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="flex-grow-1">
                                        <select id="rightTable{{ $index }}"
                                            name="joins[{{ $index - 1 }}][right_table]"
                                            class="form-select dynamicdatas jointablenames rightTablesJoin"
                                            dependent="joinOnDiv{{ $index }}"
                                            data-dependent="rightTableColumn{{ $index }}"
                                            style="{{ $view->joins[$index - 1]->join_type === 'cross' ? 'display: none;' : 'display: block; margin-bottom: 20px;' }}">
                                            <option value="" disabled="">Select Join Table</option>
                                            @if ($view->joins[$index - 1]->join_type !== 'cross')
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($view->tables as $tables)
                                                    @foreach ($tables as $table => $columns)
                                                        <option value="{{ $table }}"
                                                            {{ $view->joins[$index - 1]->right_table === $table ? 'selected' : '' }}>
                                                            {{ $table }}</option>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        if ($i == $index + 1) {
                                                            break;
                                                        }
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </select>
                                        <select name="joins[{{ $index - 1 }}][right_column]"
                                            id="rightTableColumn{{ $index }}"
                                            class="form-select joinTables rightTablesColumns"
                                            style="{{ $view->joins[$index - 1]->join_type === 'cross' ? 'display: none;' : 'display: block; margin-bottom: 20px;' }}">
                                            <option value="" disabled="">Select Join Column</option>
                                            @if ($view->joins[$index - 1]->join_type !== 'cross')
                                                @foreach ($selectedTables[$view->joins[$index - 1]->right_table] as $column)
                                                    <option value="{{ $column }}"
                                                        {{ $view->joins[$index - 1]->right_column === $column ? 'selected' : '' }}>
                                                        {{ $column }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="center-button">
                    <button type="submit" class="btn btn-info text-white px-2">Update</button>
                </div>
                {{ csrf_field() }}
            </form>
            <div id="addTableDiv" class="mt-3">
                <button id="addTable" class="btn btn-secondary px-4 py-0"> + </button>
            </div>
        </div>
    </div>
</body>

</html>
