import { columnNameRetriever } from "./columnNameFetcher.mjs";
import { cloneTable } from "./addTables.mjs";

document.addEventListener("DOMContentLoaded", function () {
    let reports = window.reportsData;
    for (let i = 1; i < reports.tables.length; i++) {
        cloneTable();
    }
    let allTables = document.querySelectorAll(".dynamic");
    let joins = document.querySelectorAll(".joins");
    let leftTablesJoin = document.querySelectorAll(".leftTablesJoin");
    let rightTablesJoin = document.querySelectorAll(".rightTablesJoin");
    let leftTablesColumns = document.querySelectorAll(".leftTablesColumns");
    let rightTablesColumns = document.querySelectorAll(".rightTablesColumns");
    allTables.forEach(function (table, index) {
        table.value = Object.keys(reports.tables[index])[0];
        const customEvent = new Event("customEvent");
        $(table).on("customEvent", columnNameRetriever);
        $(table).trigger("customEvent");
    });

    joins.forEach(function (join, index) {
        // console.log(reports.joins[index].join_type);
        join.value = reports.joins[index].join_type;
        console.log(join.id);
        let numericPart = join.id.match(/\d+$/);
        console.log(numericPart);
        // join.value = Object.keys(reports.joins[index])[0];
        // const customEvent = new Event("customEvent");
        // $(join).on("customEvent", columnNameRetriever);
        // $(join).trigger("customEvent");
    });
    // console.log(allTables.length);
});
// var resultsData = @json($results);
