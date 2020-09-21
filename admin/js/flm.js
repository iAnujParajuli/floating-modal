var totalInputFields = 0;

function createLabel(parent, id, text) {
    var label = document.createElement("label");
    label.setAttribute("for", id);
    label.innerHTML=text;
    document.querySelector(parent).appendChild(label);
}
function createInput(parent, name, id="", type="text", value=null) {
    var input = document.createElement("input");
    input.setAttribute("type", type);
    input.setAttribute("name", name);
    input.setAttribute("id", id);
    input.setAttribute("class", "flm-input");
    if (!!value) {
        input.setAttribute("value", value);
    }
    document.querySelector(parent).appendChild(input);
}

function createInputGroups(parent, count) {
    var div = document.createElement("div");
    div.setAttribute("class", "frm-group input-" + count);
    document.querySelector(parent).appendChild(div);

    var childDiv = document.createElement("div");
    childDiv.setAttribute("class", 'input-field input-1');
    div.appendChild(childDiv);

    childDiv = document.createElement("div");
    childDiv.setAttribute("class", 'input-field input-2');
    div.appendChild(childDiv);

    var name = "links[" + count + "]";
    var inputClass = ".input-" + count + " .input-1";
    var inputId = 'input' + count;
    var url = null;
    var title = null;
    if (modalData && modalData.links[count]) {
            url = modalData.links[count].url;
            title = modalData.links[count].title;
    }

    createLabel(inputClass, inputId + 'title', 'title');
    createInput(inputClass, name + "[title]", inputId + 'title', 'text', title);

    inputClass = ".input-" + count + " .input-2";
    createLabel(inputClass, inputId + 'url', 'url');
    createInput(inputClass, name + "[url]", inputId + 'url', "url", url);
}

(function () {
    for (totalInputFields = 0; totalInputFields < 5; totalInputFields++) {
        createInputGroups(".flm-form .flm-links", totalInputFields);
    }
    createInputGroups(".flm-form .flm-links", totalInputFields);
})();

var flmDropdown = new drop({
    selector:  '#flm_multiselect',
    preselected: multiIdx
});