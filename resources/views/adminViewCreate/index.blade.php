<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <script src="{{ asset('js/columnNameFetcher.js') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataViewer.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/tableDataFetcher.mjs') }}" defer></script>
    <script type="module" src="{{ asset('js/joinedDataFetcher.mjs') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @routes
</head>

<body>
    <h1>Dynamic Join</h1>
    <form>
        @csrf
        <div>
            <select name="leftTable" id="leftTable" class="dynamic" data-dependent="leftTableColumns">
                <option disabled selected value="">Select Table</option>
                @foreach ($tableNames as $tableName)
                    <option value="{{ $tableName }}">{{ $tableName }}</option>
                @endforeach
            </select>
        </div>
        <br />
        <div>
            <select name="leftTableColumns" id="leftTableColumns" class="dynamicdatas tableColumnChanged" data-dependent="leftTableDatas" multiple>
                <option value="">Select Columns</option>
            </select>
        </div>
        {{ csrf_field() }}
    </form>
    <br/>
    <div>
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
        <select id="tablesJoin" class="dynamicdatas">
            <option disabled selected value="">Select Join Type</option>
            <option value="inner">Inner Join</option>
            <option value="left">Left Join</option>
            <option value="right">Right Join</option>
            <option value="cross">Cross Join</option>
        </select>
    </div>
    <br/>
    <div id="joinOnDiv">
        <select id="leftMatchingColumn" class="dynamicdatas" style="display: none"></select>
        <select id="rightMatchingColumn" class="dynamicdatas" style="display: none"></select>
    </div>
    <br/>
    <div>
        <button id='showData'>Show Data</button>
    </div>
    <br/>
    <div>
        <form action="">
            @csrf
            <table border="1" name="joinedTableDatas" id="joinedTableDatas">
            </table>
            {{ csrf_field() }}
        </form>
    </div>
    <br/>

</body>

</html>