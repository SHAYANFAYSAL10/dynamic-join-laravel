// import { processTableData } from "./tableDataViewer.mjs";

// document.addEventListener("DOMContentLoaded", function () {
//     var selectedTable;

//     var leftTable = document.getElementById("leftTable");
//     var rightTable = document.getElementById("rightTable");

//     $(document).ready(function () {
//         $(".tableColumnChanged").change(function () {
//             if ($(this).val() != "") {
//                 var value = $(this).val();
//                 var dependent = $(this).data("dependent");
//                 var _token = $('input[name="_token"').val();
//                 if ($(this).attr("id") === "leftTableColumns") {
//                     selectedTable = leftTable.value;
//                 } else {
//                     selectedTable = rightTable.value;
//                 }
//                 $.ajax({
//                     url: route("dynamicJoin.fetch_datas"),
//                     method: "POST",
//                     data: {
//                         tableName: selectedTable,
//                         value: value,
//                         _token: _token,
//                         dependent: dependent,
//                     },
//                     success: function (response) {
//                         var tableData = document.getElementById(
//                             response.dependent
//                         );
//                         processTableData(tableData, response.data);
//                     },
//                 });
//             }
//         });
//     });
// });
