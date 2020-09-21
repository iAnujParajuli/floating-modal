var modalDataJson = JSON.parse(modalData);
if (modalDataJson.page.indexOf(pageID + "") != -1) {

    var modalWrapper = document.createElement("div");
    modalWrapper.setAttribute("class", "flm-modal-wrapper");

    var modal = document.createElement("div");
    modal.setAttribute("class", "flm-modal");
    modalWrapper.appendChild(modal);

    var closeButton = document.createElement("a");
    closeButton.setAttribute("class", "flm-modal-close");
    closeButton.setAttribute("href", "javascript::void();");
    closeButton.setAttribute("onclick", 'closeModal()');
    closeButton.innerHTML = '<span class="fa fa-close"></span>';
    modal.appendChild(closeButton);

    var modalHeader = document.createElement("h2");
    modalHeader.setAttribute("class", "flm-modal-title");
    modalHeader.innerHTML = modalDataJson.title;
    modal.appendChild(modalHeader);

    var modalSubTitle = document.createElement("h5");
    modalSubTitle.setAttribute("class", "flm-modal-subtitle");
    modalSubTitle.innerHTML = modalDataJson.description;
    modal.appendChild(modalSubTitle);

    modalDataJson.links.forEach(link => {
        var button = document.createElement("a");
        button.setAttribute("class", "flm-modal-link");
        button.setAttribute("href", link.url);
        button.innerHTML = link.title;
        modal.appendChild(button);
    });

    document.body.appendChild(modalWrapper);
}

function closeModal() {
    document.querySelector(".flm-modal-wrapper").style.display = "none";
}