export function columnNameRetriever() {
    if ($(this).val() != "") {
        var currentId = $(this).attr("id");
        // console.log(currentId);
        var value = $(this).val();
        // console.log(value);
        var dependent = $(this).data("dependent");
        var _token = $('input[name="_token"').val();
        $.ajax({
            url: route("dynamicJoin.fetch"),
            method: "POST",
            data: {
                value: value,
                _token: _token,
                dependent: dependent,
            },
            success: function (response) {
                var columnName = document.getElementById(response.dependent);
                columnName.innerHTML = "";
                response.data.forEach(function (entry, index) {
                    var numberOfFeatures = Object.keys(entry).length;
                    var columnOption = document.createElement("option");
                    columnOption.textContent = entry;
                    columnName.appendChild(columnOption);
                });
            },
        });
    }
}
