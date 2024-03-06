// export const processTableData = (htmlTag, data) => {
//     var isColumnNameShown = false;
//     data.forEach(function (entry, index) {
//         if (isColumnNameShown === false) {
//             htmlTag.innerHTML = "";
//             var tableHeads = document.createElement("tr");
//             Object.keys(entry).forEach((element) => {
//                 var tableHeadName = document.createElement("th");
//                 tableHeadName.textContent = element;
//                 tableHeads.appendChild(tableHeadName);
//             });
//             isColumnNameShown = true;
//             htmlTag.appendChild(tableHeads);
//         }
//         var tableRows = document.createElement("tr");
//         for (var feature in entry) {
//             if (entry.hasOwnProperty(feature)) {
//                 var listItem = document.createElement("td");
//                 listItem.textContent = entry[feature];
//                 tableRows.appendChild(listItem);
//             }
//         }
//         htmlTag.appendChild(tableRows);
//     });
// };
