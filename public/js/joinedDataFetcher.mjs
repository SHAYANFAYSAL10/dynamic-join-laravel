// // import { processTableData } from "./tableDataViewer.mjs";

// export { getTableNames, handleTableColumnChange, joinChange };

// let tableNames = [];
// let columnNamesWithTables = {};

// let dynamicTableNames = document.querySelectorAll(".dynamic");
// let joins = document.querySelectorAll(".joins");
// function getTableNames() {
//     dynamicTableNames = document.querySelectorAll(".dynamic");
//     tableNames = [];
//     dynamicTableNames.forEach((dynamicTableName) => {
//         tableNames.push(dynamicTableName.value);
//     });
//     // console.log(tableNames);
//     handleTableColumnChange();
// }

// const handleTableColumnChange = () => {
//     columnNamesWithTables.tables = [];
//     dynamicTableNames.forEach((dynamicTableName, index) => {
//         let tableInfoObject = {};
//         let tableNameArray = [];
//         let dataDependentValue =
//             dynamicTableName.getAttribute("data-dependent");
//         let currentColumnsId = document.getElementById(dataDependentValue);
//         for (let i = 0; i < currentColumnsId.options.length; i++) {
//             if (currentColumnsId.options[i].selected) {
//                 tableNameArray.push(currentColumnsId.options[i].value);
//             }
//         }
//         tableInfoObject[tableNames[index]] = tableNameArray;
//         columnNamesWithTables.tables.push(tableInfoObject);
//     });
//     // let columnNamesWithTablesJSON = JSON.stringify(columnNamesWithTables);
//     // console.log(columnNamesWithTablesJSON);
// };

// const joinChange = () => {
//     columnNamesWithTables.joins = {};
//     joins = document.querySelectorAll(".joins");
//     let joinArray = [];
//     joins.forEach((join, index) => {
//         // let joinType = $(this).attr("id");
//         // let currentJoinId = document.getElementById(joinType);
//         // columnNamesWithTables.joins[index] = currentJoinId.value;
//         let joinType = "join_type";
//         let joinObject = {};
//         joinObject[joinType] = join.value;
//         joinArray.push(joinObject);
//         // if (currentJoinId.value !== "cross") {
//         //     let leftTablesJoinOn = currentJoinId.getAttribute("dependent1");
//         //     let rightTablesJoinOn = currentJoinId.getAttribute("dependent2");
//         //     let leftTablesJoinOnId = document.getElementById(leftTablesJoinOn);
//         //     let rightTablesJoinOnId =
//         //         document.getElementById(rightTablesJoinOn);
//         //     let leftTableName = leftTablesJoinOnId.getAttribute("dependent");
//         //     let rightTableName = rightTablesJoinOnId.getAttribute("dependent");
//         //     let leftTableId = document.getElementById(leftTableName);
//         //     let rightTableId = document.getElementById(rightTableName);
//         //     joinObject[leftTableId.value] = leftTablesJoinOnId.value;
//         //     joinObject[rightTableId.value] = rightTablesJoinOnId.value;
//         //     console.log(leftTablesJoinOnId.value);
//         // }
//         console.log(joinObject);
//         columnNamesWithTables.joins = joinArray;
//         let columnNamesWithTablesJSON = JSON.stringify(columnNamesWithTables);
//         console.log(columnNamesWithTablesJSON);
//     });
// };

// // document.addEventListener("DOMContentLoaded", function () {
// //     let leftTable = document.getElementById("leftTable");
// //     let rightTable = document.getElementById("rightTable");
// //     let leftTableColumns = document.getElementById("leftTableColumns");
// //     let rightTableColumns = document.getElementById("rightTableColumns");
// //     let tablesJoin = document.getElementById("tablesJoin");
// //     let leftJoinColumns = document.getElementById("leftMatchingColumn");
// //     let rightJoinColumns = document.getElementById("rightMatchingColumn");
// //     let joinedTableDatas = document.getElementById("joinedTableDatas");
// //     let dynamicTableNames = document.querySelectorAll(".dynamic");
// //     let tableColumnChanged = document.querySelectorAll(".tableColumnChanged");
// //     let joins = document.querySelectorAll(".joins");

// //     let selectedLeftTable;
// //     let selectedRightTable;
// //     let joinType;
// //     let matchOnLeft;
// //     let matchOnRight;

// //     let leftTableValues = [];
// //     let rightTableValues = [];
// //     let leftTableAllOptions = [];
// //     let rightTableAllOptions = [];

// //     let tableNames = [];
// //     let columnNamesWithTables = {};

// //     function updateJoinDiv() {
// //         leftJoinColumns.innerHTML = "";
// //         rightJoinColumns.innerHTML = "";
// //         joinType = tablesJoin.value;
// //         if (
// //             joinType === "inner" ||
// //             joinType === "left" ||
// //             joinType === "right"
// //         ) {
// //             leftJoinColumns.style.display = "inline";
// //             rightJoinColumns.style.display = "inline";

// //             leftTableAllOptions = [];
// //             rightTableAllOptions = [];

// //             for (let i = 0; i < leftTableColumns.options.length; i++) {
// //                 leftTableAllOptions.push(leftTableColumns.options[i].value);
// //             }

// //             for (let i = 0; i < rightTableColumns.options.length; i++) {
// //                 rightTableAllOptions.push(rightTableColumns.options[i].value);
// //             }

// //             leftTableAllOptions.forEach((element) => {
// //                 let listItem = document.createElement("option");
// //                 listItem.text = element;
// //                 listItem.value = element;
// //                 leftJoinColumns.appendChild(listItem);
// //             });
// //             rightTableAllOptions.forEach((element) => {
// //                 let listItem = document.createElement("option");
// //                 listItem.text = element;
// //                 listItem.value = element;
// //                 rightJoinColumns.appendChild(listItem);
// //             });

// //             matchOnLeft = leftJoinColumns.value;
// //             matchOnRight = rightJoinColumns.value;
// //         } else {
// //             leftJoinColumns.style.display = "none";
// //             rightJoinColumns.style.display = "none";
// //         }
// //     }

// //     function updateMatchingColumn() {
// //         matchOnLeft = leftJoinColumns.value;
// //         matchOnRight = rightJoinColumns.value;
// //     }

// //     $(document).ready(function () {
// //         const handleTableColumnChange = () => {
// //             columnNamesWithTables.tables = {};
// //             dynamicTableNames.forEach((dynamicTableName, index) => {
// //                 let tableNameArray = [];
// //                 let dataDependentValue =
// //                     dynamicTableName.getAttribute("data-dependent");
// //                 let currentColumnsId =
// //                     document.getElementById(dataDependentValue);
// //                 for (let i = 0; i < currentColumnsId.options.length; i++) {
// //                     if (currentColumnsId.options[i].selected) {
// //                         tableNameArray.push(currentColumnsId.options[i].value);
// //                     }
// //                 }
// //                 columnNamesWithTables.tables[tableNames[index]] =
// //                     tableNameArray;
// //             });
// //         };

// //         $(".dynamic").change(function () {
// //             tableNames = [];
// //             dynamicTableNames.forEach((dynamicTableName) => {
// //                 tableNames.push(dynamicTableName.value);
// //             });
// //             handleTableColumnChange();
// //         });

// //         $(tableColumnChanged).change(handleTableColumnChange);

// //         $(".joins").change(function () {
// //             columnNamesWithTables.joins = {};
// //             console.log(joins.length);
// //             joins.forEach((join, index) => {
// //                 let joinType = $(this).attr("id");
// //                 let currentJoinId = document.getElementById(joinType);
// //                 // columnNamesWithTables.joins[index] = currentJoinId.value;
// //                 let joinObject = {};
// //                 joinObject.joinType = currentJoinId.value;
// //                 if (currentJoinId.value !== "cross") {
// //                     let leftTablesJoinOn =
// //                         currentJoinId.getAttribute("dependent1");
// //                     let rightTablesJoinOn =
// //                         currentJoinId.getAttribute("dependent2");
// //                     let leftTablesJoinOnId =
// //                         document.getElementById(leftTablesJoinOn);
// //                     let rightTablesJoinOnId =
// //                         document.getElementById(rightTablesJoinOn);
// //                     let leftTableName =
// //                         leftTablesJoinOnId.getAttribute("dependent");
// //                     let rightTableName =
// //                         rightTablesJoinOnId.getAttribute("dependent");
// //                     let leftTableId = document.getElementById(leftTableName);
// //                     let rightTableId = document.getElementById(rightTableName);
// //                     joinObject[leftTableId.value] = leftTablesJoinOnId.value;
// //                     joinObject[rightTableId.value] = rightTablesJoinOnId.value;
// //                     console.log(leftTablesJoinOnId.value);
// //                 }
// //                 console.log(joinObject);
// //             });
// //         });

// //         $(".dynamicdatas").change(function () {
// //             if ($(this).val() != "") {
// //                 console.log(columnNamesWithTables);
// //                 let columnNamesWithTablesJSON = JSON.stringify(
// //                     columnNamesWithTables
// //                 );
// //                 console.log(columnNamesWithTablesJSON);
// //                 leftTableValues = [];
// //                 for (let i = 0; i < leftTableColumns.options.length; i++) {
// //                     if (leftTableColumns.options[i].selected) {
// //                         leftTableValues.push(leftTableColumns.options[i].value);
// //                     }
// //                 }

// //                 rightTableValues = [];
// //                 for (let i = 0; i < rightTableColumns.options.length; i++) {
// //                     if (rightTableColumns.options[i].selected) {
// //                         rightTableValues.push(
// //                             rightTableColumns.options[i].value
// //                         );
// //                     }
// //                 }

// //                 selectedLeftTable = leftTable.value;
// //                 selectedRightTable = rightTable.value;
// //                 joinType = tablesJoin.value;

// //                 if (
// //                     $(this).attr("id") === "leftMatchingColumn" ||
// //                     $(this).attr("id") === "rightMatchingColumn"
// //                 ) {
// //                     updateMatchingColumn();
// //                 } else {
// //                     updateJoinDiv();
// //                 }
// //             }
// //         });

// //         $("#showData").click(function () {
// //             let _token = $('input[name="_token"').val();
// //             $.ajax({
// //                 url: route("dynamicJoin.fetch_join_datas"),
// //                 method: "POST",
// //                 data: {
// //                     leftTable: selectedLeftTable,
// //                     rightTable: selectedRightTable,
// //                     leftTableColumns: leftTableValues,
// //                     rightTableColumns: rightTableValues,
// //                     joinType: joinType,
// //                     leftMatchingColumn: matchOnLeft,
// //                     rightMatchingColumn: matchOnRight,
// //                     _token: _token,
// //                 },
// //                 success: function (response) {
// //                     processTableData(joinedTableDatas, response.data);
// //                 },
// //             });
// //         });
// //     });
// // });
