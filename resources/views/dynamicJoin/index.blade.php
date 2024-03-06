<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <script type="module" src="{{ asset('js/columnNameFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataViewer.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/joinedDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/addTables.mjs') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @routes
</head>

<body>
    <h1>Dynamic Join</h1>
    <form action="{{ url('/') }}/join" method="post">
        @csrf
        <div id="tablesDiv">
            <div id="dynamicDiv0" class="tables">
                <div>
                    <select name="table[]" id="table0" class="dynamic" data-dependent="tableColumns0"
                        dependent="tableColumns0">
                        <option disabled selected value="">Select Table</option>
                        @foreach ($tableNames as $tableName)
                            <option value="{{ $tableName }}">{{ $tableName }}</option>
                        @endforeach
                    </select>
                </div>
                <br />
                <div>
                    <select name="tables" id="tableColumns0" class="dynamicdatas tableColumnChanged"
                        data-dependent="tableDatas0" multiple>
                        <option value="">Select Columns</option>
                    </select>
                </div>
                <br />
            </div>
        </div>
        <button type="submit">Submit</button>
        {{ csrf_field() }}
    </form>
    <br />
    <div id="addTableDiv">
        <button id="addTable">+</button>
    </div>
    {{-- <!-- <div>
        <form action="">
            @csrf
            <table border="1" name="leftTableDatas" class="selectedValues" id="leftTableDatas">
            </table>
            {{ csrf_field() }}
        </form>
    </div>
    <br/>

    <form>
        @csrf
        <div>
            <select name="rightTable" id="rightTable" class="dynamic" data-dependent="rightTableColumns">
                <option disabled selected value="">Select Table</option>
                @foreach ($tableNames as $tableName)
<option value="{{ $tableName }}">{{ $tableName }}</option>
@endforeach
            </select>
        </div>
        <br />
        <div>
            <select name="rightTableColumns" id="rightTableColumns" class="dynamicdatas tableColumnChanged" data-dependent="rightTableDatas" multiple>
                <option value="">Select Columns</option>
            </select>
        </div>
        {{ csrf_field() }}
    </form>
    <br/>
    <div>
        <form action="">
            @csrf
            <table border="1" name="rightTableDatas" class="selectedValues" id="rightTableDatas">
            </table>
            {{ csrf_field() }}
        </form>
    </div>
    <br/>
    <div>
        <select id="tablesJoin" class="dynamicdatas joins" dependent1="leftMatchingColumn" dependent2="rightMatchingColumn">
            <option disabled selected value="">Select Join Type</option>
            <option value="inner">Inner Join</option>
            <option value="left">Left Join</option>
            <option value="right">Right Join</option>
            <option value="cross">Cross Join</option>
        </select>
    </div>
    <br/>
    <div id="joinOnDiv">
        <select id="leftMatchingColumn" class="dynamicdatas" dependent="leftTable" style="display: none"></select>
        <select id="rightMatchingColumn" class="dynamicdatas" dependent="rightTable" style="display: none"></select>
    </div>
    <br/> --> --}}
    {{-- <div>
        <button id='showData'>Show Data</button>
    </div>
    <br />
    <div>
        <form action="">
            @csrf
            <table border="1" name="joinedTableDatas" id="joinedTableDatas">
            </table>
            {{ csrf_field() }}
        </form>
    </div> --}}
    <br />

</body>

</html>
