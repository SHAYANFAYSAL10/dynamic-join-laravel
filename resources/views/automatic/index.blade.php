<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>

<body>
    <h1>Dynamic View Automatic</h1>
    <form>
        @csrf
        <div>
            <select name="tablename" id="tablename" class="dynamic" data-dependent="columnname">
                <option disabled selected value="">Select Table</option>
                @foreach ($tableNames as $tableName)
                    <option value="{{ $tableName }}">{{ $tableName }}</option>
                @endforeach
            </select>
        </div>
        <br />
        <div>
            <select name="columnname" id="columnname" class="dynamicdatas" data-dependent="datas" multiple>
                <option value="">Select Columns</option>
            </select>
        </div>
        {{ csrf_field() }}
    </form>
    <div>
        <form action="">
            @csrf
            <table border="1" name="datas" class="datas" id="selectedValues">
                <tr id="selectedList">
                </tr>
            </table>
            {{ csrf_field() }}
        </form>
    </div>

</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('.dynamic').change(function() {
            if ($(this).val() != '') {
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"').val();
                $.ajax({
                    url: "{{ route('automatic.fetch') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                        dependent: dependent
                    },
                    // success: function(result) {
                    //     ;
                    //     $('#' + dependent).html(result);
                    // }
                    success: function(response) {
                        var columnName=document.getElementById('columnname');
                        columnName.innerHTML = '';
                        response.data.forEach(function(entry, index) {
                            var numberOfFeatures = Object.keys(entry).length;
                            var columnOption = document.createElement('option');
                            columnOption.textContent = entry;
                            columnName.appendChild(columnOption);
                        });
                    }
                })
            }
        });
    });



    document.addEventListener('DOMContentLoaded', function() {
        function updateTablename() {
            selectedTable = tablename.value;
            // table.innerHTML = '';
            selectedListElement.innerHTML = '';
        }

        var tablename = document.getElementById('tablename');
        var selectedTable;

        tablename.addEventListener('change', updateTablename);

        var selectedValues = [];

        var columnName = document.getElementById('columnname');

        var selectElement = document.getElementById('columnname');
        var selectedListElement = document.getElementById('selectedList');

        var table = document.getElementById('selectedValues');

        function updateSelectedValues() {
            selectedValues = [];

            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].selected) {
                    selectedValues.push(selectElement.options[i].value);
                }
            }
            selectedListElement.innerHTML = '';
            var tableHeaders = document.createElement('tr');
            selectedValues.forEach(function(value) {
                var listItem = document.createElement('th');
                listItem.textContent = value;
                tableHeaders.appendChild(listItem);
            });
            selectedListElement.appendChild(tableHeaders);

        }
        columnName.addEventListener('change', updateSelectedValues);
        $(document).ready(function() {
            $('.dynamicdatas').change(function() {
                // console.log("hello");
                // $('.dynamicdatas').off('change').on('change', function() {
                // console.log(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = $('input[name="_token"').val();
                    $.ajax({
                        url: "{{ route('automatic.fetch_datas') }}",
                        method: "POST",
                        data: {
                            tableName: selectedTable,
                            select: selectedValues,
                            value: value,
                            _token: _token,
                            dependent: dependent
                        },
                        success: function(response) {
                            response.data.forEach(function(entry, index) {
                                var numberOfFeatures = Object.keys(entry).length;
                                var tableRows = document.createElement('tr');
                                for (var feature in entry) {
                                    if (entry.hasOwnProperty(feature)) {
                                        var listItem = document.createElement('td');
                                        listItem.textContent = entry[feature];
                                        tableRows.appendChild(listItem);
                                    }
                                }
                                selectedListElement.appendChild(tableRows);
                            });
                        }
                    });
                }
            });
        });
    });
</script>
