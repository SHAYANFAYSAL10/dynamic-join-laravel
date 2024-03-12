import { columnNameRetriever } from "./columnNameFetcher.mjs";
import {
    cloneTable,
    tableNameRetriever,
    handleJoinChange,
} from "./addTables.mjs";

document.addEventListener("DOMContentLoaded", function () {
    let usersId = document.getElementById("users");
    let allUsers = usersId.options;
    let reports = window.reportsData[0].view;
    reports = JSON.parse(reports);
    let selectedUsers = JSON.parse(window.reportsData[0].users);
    for (let i = 1; i < reports.tables.length; i++) {
        cloneTable();
    }

    let reportNameId = document.getElementById("reportName");
    reportNameId.value = window.reportsData[0].name;

    for (var i = 0; i < allUsers.length; i++) {
        if (selectedUsers.includes(usersId.options[i].value)) {
            usersId.options[i].selected = true;
        }
    }
    let allTables = document.querySelectorAll(".dynamic");
    let joins = document.querySelectorAll(".joins");
    let leftTablesJoin = document.querySelectorAll(".leftTablesJoin");
    let rightTablesJoin = document.querySelectorAll(".rightTablesJoin");
    let leftTablesColumns = document.querySelectorAll(".leftTablesColumns");
    let rightTablesColumns = document.querySelectorAll(".rightTablesColumns");

    allTables.forEach(function (table, index) {
        table.value = Object.keys(reports.tables[index])[0];
        let customEvent = new Event("customEvent");
        $(table).on("customEvent", columnNameRetriever);
        $(table).trigger("customEvent");
        customEvent = new Event("customEvent");
        $(table).on("customEvent", tableNameRetriever);
        $(table).trigger("customEvent");
        if (index !== 0) {
            let currentJoin = document.getElementById(`tablesJoin${index}`);
            currentJoin.value = reports.joins[index - 1].join_type;

            customEvent = new Event("customEvent");
            $(currentJoin).on("customEvent", handleJoinChange);
            $(currentJoin).trigger("customEvent");
            if (currentJoin.value !== "cross") {
                let leftTable = document.getElementById(`leftTable${index}`);
                let rightTable = document.getElementById(`rightTable${index}`);

                leftTable.value = reports.joins[index - 1].left_table;
                rightTable.value = reports.joins[index - 1].right_table;
            }
        }
        if (index === reports.tables.length - 1) {
            columnON();
        }
    });

    function columnON() {
        for (let i = 0; i < reports.joins.length; i++) {
            let leftTable = document.getElementById(`leftTable${i + 1}`);
            let rightTable = document.getElementById(`rightTable${i + 1}`);

            let customEvent = new Event("customEvent");
            $(leftTable).on("customEvent", columnNameRetriever);
            $(leftTable).trigger("customEvent");

            customEvent = new Event("customEvent");
            $(rightTable).on("customEvent", columnNameRetriever);
            $(rightTable).trigger("customEvent");
            let leftColumn = document.getElementById(`leftTableColumn${i + 1}`);
            let rightColumn = document.getElementById(
                `rightTableColumn${i + 1}`
            );

            $(leftColumn).each(function () {
                console.log($(this).text());
            });

            leftColumn.value = reports.joins[i].left_table;
            rightColumn.value = reports.joins[i].right_table;
        }
    }
});
// var resultsData = @json($results);
