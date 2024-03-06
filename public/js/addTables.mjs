import { columnNameRetriever } from "./columnNameFetcher.mjs";
// import {
//     getTableNames,
//     handleTableColumnChange,
//     joinChange,
// } from "./joinedDataFetcher.mjs";

document.addEventListener("DOMContentLoaded", function () {
    let tableNames = [];

    let allDynamic = document.querySelectorAll(".dynamic");
    let alltableColumnChanged = document.querySelectorAll(
        ".tableColumnChanged"
    );
    let joins = document.querySelectorAll(".joins");
    let numberOfTables = 0;

    let addButton = document.getElementById("addTable");
    let dynamicDiv = document.getElementById("dynamicDiv0");
    let tablesDiv = document.getElementById("tablesDiv");

    addButton.addEventListener("click", function () {
        numberOfTables++;
        let newDiv = dynamicDiv.cloneNode(true);
        // let newDivId = "dynamicDiv" + numberOfTables;
        // newDiv.id = newDivId;
        updateElementIds(newDiv, numberOfTables, "id");
        // updateElementIds(newDiv, numberOfTables, "name");
        updateElementIds(newDiv, numberOfTables, "data-dependent");
        updateElementIds(newDiv, numberOfTables, "dependent");
        tablesDiv.appendChild(newDiv);
        allDynamic = document.querySelectorAll(".dynamic");
        let table = document.getElementById(`table${numberOfTables}`);
        let tableColumns = document.getElementById(
            `tableColumns${numberOfTables}`
        );
        tableColumns.innerHTML = "<option>Select Columns</option>";
        createJoinDiv();
        // joins = document.querySelectorAll(".joins");
        let join = document.getElementById(`tablesJoin${numberOfTables}`);
        attachEventListeners(table, join);
    });

    function updateElementIds(element, numberOfTables, attributeName) {
        let elements = element.querySelectorAll(`[${attributeName}]`);
        elements.forEach(function (el) {
            let oldAttribute = el.getAttribute(attributeName);
            let newAttribute = oldAttribute.replace(/\d+/, numberOfTables);
            el.setAttribute(attributeName, newAttribute);
        });
    }

    function attachEventListeners(table, join) {
        $(table).change(columnNameRetriever);
        $(table).change(tableNameRetriever);
        // $(table).change(getTableNames);
        // $(tableColumns).change(handleTableColumnChange);
        $(join).change(handleJoinChange);
    }

    function tableNameRetriever() {
        let columnfield = $(this).attr("dependent");
        let columnfieldId = document.getElementById($(this).attr("dependent"));
        let numericPart = columnfield.match(/\d+$/);
        columnfieldId.name = `tables[${numericPart}][${this.value}][]`;
        // console.log(numericPart);
        tableNames = [];
        allDynamic.forEach(function (selectElement) {
            tableNames.push(selectElement.value);
        });
        console.log(this);
        matchingTableRetriever();
    }

    function createJoinDiv() {
        let joinOnDiv = document.createElement("div");
        joinOnDiv.id = `joinOnDiv${numberOfTables}`;

        let tablesJoinSelect = document.createElement("select");
        tablesJoinSelect.id = "tablesJoin0";
        tablesJoinSelect.name = `joins[${numberOfTables - 1}][join_type]`;
        tablesJoinSelect.className = "dynamicdatas joins";
        tablesJoinSelect.setAttribute("dependent1", "leftTable0");
        tablesJoinSelect.setAttribute("dependent2", "rightTable0");
        createDefaultOption(tablesJoinSelect, "Select Join Type");

        let joinOptions = [
            { value: "inner", text: "Inner Join" },
            { value: "left", text: "Left Join" },
            { value: "right", text: "Right Join" },
            { value: "cross", text: "Cross Join" },
        ];

        joinOptions.forEach((option) => {
            let optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.textContent = option.text;
            tablesJoinSelect.appendChild(optionElement);
        });

        let leftTable = document.createElement("select");
        leftTable.id = "leftTable0";
        leftTable.name = `joins[${numberOfTables - 1}][left_table]`;
        leftTable.className = "dynamicdatas jointablenames";
        leftTable.setAttribute("dependent", "joinOnDiv0");
        leftTable.setAttribute("data-dependent", "leftTableColumn0");
        createDefaultOption(leftTable, "Select Join Table");
        leftTable.style.display = "none";
        // matchingTableRetriever();

        let rightTable = document.createElement("select");
        rightTable.id = "rightTable0";
        rightTable.name = `joins[${numberOfTables - 1}][right_table]`;
        rightTable.className = "dynamicdatas jointablenames";
        rightTable.setAttribute("dependent", "joinOnDiv0");
        rightTable.setAttribute("data-dependent", "rightTableColumn0");
        createDefaultOption(rightTable, "Select Join Table");
        rightTable.style.display = "none";

        //
        //

        let newSelect = document.createElement("select");
        newSelect.name = `joins[${numberOfTables - 1}][left_column]`;
        newSelect.id = "leftTableColumn0";
        newSelect.className = "joinTables";
        newSelect.setAttribute("data-dependent", "leftTable0");
        createDefaultOption(newSelect, "Select Column");
        newSelect.style.display = "none";

        joinOnDiv.appendChild(tablesJoinSelect);
        joinOnDiv.appendChild(document.createElement("br"));
        joinOnDiv.appendChild(document.createElement("br"));
        joinOnDiv.appendChild(leftTable);
        // joinOnDiv.appendChild(document.createElement("br"));
        // joinOnDiv.appendChild(document.createElement("br"));
        joinOnDiv.appendChild(newSelect);

        newSelect = document.createElement("select");
        newSelect.name = `joins[${numberOfTables - 1}][right_column]`;
        newSelect.id = "rightTableColumn0";
        newSelect.className = "joinTables";
        createDefaultOption(newSelect, "Select Column");
        newSelect.style.display = "none";

        // joinOnDiv.appendChild(document.createElement("br"));
        // joinOnDiv.appendChild(document.createElement("br"));
        joinOnDiv.appendChild(rightTable);
        // joinOnDiv.appendChild(document.createElement("br"));
        // joinOnDiv.appendChild(document.createElement("br"));
        joinOnDiv.appendChild(newSelect);
        // joinOnDiv.appendChild(document.createElement("br"));
        // joinOnDiv.appendChild(document.createElement("br"));

        // document.body.appendChild(joinOnDiv);
        updateElementIds(joinOnDiv, numberOfTables, "id");
        // updateElementIds(joinOnDiv, numberOfTables, "name");
        updateElementIds(joinOnDiv, numberOfTables, "dependent");
        updateElementIds(joinOnDiv, numberOfTables, "dependent1");
        updateElementIds(joinOnDiv, numberOfTables, "dependent2");
        updateElementIds(joinOnDiv, numberOfTables, "data-dependent");

        tablesDiv.appendChild(joinOnDiv);
        // matchingTableRetriever();
        $(leftTable).change(columnNameRetriever);
        $(rightTable).change(columnNameRetriever);
        // $(tablesJoinSelect).change(joinChange);
        // handleJoinChange();
    }

    function matchingTableRetriever() {
        console.log(this);
        let jointablenames = document.querySelectorAll(".jointablenames");
        jointablenames.forEach(function (tableName) {
            // console.log(tableName);
            tableName.innerHTML = `<option value="" disabled selected>Select Join Table</option>`;
            tableNames.forEach(function (table) {
                let newOption = document.createElement("option");
                newOption.value = table;
                newOption.text = table;
                tableName.appendChild(newOption);
            });
        });
    }

    function createDefaultOption(parentElementId, texts) {
        let defalutOption = document.createElement("option");
        defalutOption.value = "";
        defalutOption.text = texts;
        defalutOption.disabled = true;
        defalutOption.selected = true;
        parentElementId.appendChild(defalutOption);
    }

    function handleJoinChange() {
        let numericPart = this.id.match(/\d+$/);
        let leftTable = document.getElementById(`leftTable${numericPart}`);
        let rightTable = document.getElementById(`rightTable${numericPart}`);
        let leftTableColumn = document.getElementById(
            `leftTableColumn${numericPart}`
        );
        let rightTableColumn = document.getElementById(
            `rightTableColumn${numericPart}`
        );
        if (this.value === "cross") {
            leftTable.style.display = "none";
            rightTable.style.display = "none";
            leftTableColumn.style.display = "none";
            rightTableColumn.style.display = "none";
        } else {
            leftTable.style.display = "block";
            rightTable.style.display = "block";
            leftTableColumn.style.display = "block";
            rightTableColumn.style.display = "block";
            leftTable.style.marginBottom = "20px";
            rightTable.style.marginBottom = "20px";
            leftTableColumn.style.marginBottom = "20px";
            rightTableColumn.style.marginBottom = "20px";
        }
        // console.log(this.dependent1);
        // this.style.display = "none";
    }

    $(allDynamic).change(columnNameRetriever);
    // // $(allDynamic).change(getTableNames);
    // // $(alltableColumnChanged).change(handleTableColumnChange);
    // // $(joins).change(joinChange);
    $(allDynamic).change(tableNameRetriever);
});
