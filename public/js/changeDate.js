function getDateDifference() {
    let startDate = new Date(document.getElementById("startDate").value);
    let endDate = new Date(document.getElementById("endDate").value);

    let diffYears = endDate.getFullYear() - startDate.getFullYear();
    if (endDate.getMonth() < startDate.getMonth()) diffYears--;
    else if (
        endDate.getMonth() === startDate.getMonth() &&
        endDate.getDate() < startDate.getDate()
    )
        diffYears--;

    let diffMonths = endDate.getMonth() - startDate.getMonth();
    if (diffMonths < 0) {
        diffMonths += 12;
    } else if (diffMonths == 0 && endDate.getDate() < startDate.getDate()) {
        diffMonths += 12;
    }

    let diffDays = endDate.getDate() - startDate.getDate();
    if (diffDays < 0) {
        let tempDate = new Date(endDate.getFullYear(), endDate.getMonth(), 0);
        diffDays += tempDate.getDate();
        diffMonths--;
    }

    return {
        years: diffYears,
        months: diffMonths,
        days: diffDays,
    };
}

function validateDateRange() {
    let startDate = new Date(document.getElementById("startDate").value);
    let endDate = new Date(document.getElementById("endDate").value);

    if (!isNaN(startDate) && !isNaN(endDate)) {
        if (endDate <= startDate) {
            alert("End date must be greater than start date.");
            return false;
        }
    }
    let difference = getDateDifference();
    if (difference.years > 0) {
        alert("The date range can not be more than 6 months.");
        return false;
    } else if (difference.months > 6) {
        alert("The date range can not be more than 6 months.");
        return false;
    } else if (difference.months == 6 && difference.days > 0) {
        alert("The date range can not be more than 6 months.");
        return false;
    }
    return true;
}

function showAllData() {
    let startDate = new Date(document.getElementById("startDate").value);
    let endDate = new Date(document.getElementById("endDate").value);

    if (!isNaN(startDate) && !isNaN(endDate)) {
        let currentUrl = window.location.href;
        let url = "";
        let slashCount = 0;
        for (let i = 0; i < currentUrl.length; i++) {
            if (currentUrl[i] === "/") {
                slashCount++;
            }
            if (slashCount > 4) {
                break;
            }
            url += currentUrl[i];
        }
        currentUrl = url;
        if (validateDateRange()) {
            currentUrl +=
                "/" +
                document.getElementById("startDate").value +
                "/" +
                document.getElementById("endDate").value;
            window.location.href = currentUrl;
        }
    } else {
        alert("Select start and end date.");
    }
}

// document
//     .getElementById("dateForm")
//     .addEventListener("submit", function (event) {
//         if (!validateDateRange()) {
//             event.preventDefault();
//         } else {
//             currentUrl +=
//                 "/" +
//                 document.getElementById("startDate").value +
//                 "/" +
//                 document.getElementById("endDate").value;
//             window.location.href = currentUrl;
//         }
//     });
