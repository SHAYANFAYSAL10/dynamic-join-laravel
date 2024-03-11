function getJSON(content) {
    // let value = JSON.stringify(content);
    console.log(content);
    // console.log(value);
    let value = JSON.parse(content);
    console.log(value);
    document.getElementById("jsonDisplay").textContent = JSON.stringify(
        value,
        null,
        2
    );
    Prism.highlightElement(document.getElementById("jsonDisplay"));
}
