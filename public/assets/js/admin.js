let editorMoj = null;
let promenjenRedosled = [];
function sortTable(columnIndex) {
    const table = document.getElementsByTagName("table")[0];
    const rows = Array.from(table.rows).slice(1);
    console.log(table.sortedColumnIndex);
    const ascending =
        columnIndex === table.sortedColumnIndex ? !table.sortedAscending : true;
    if (isTextCell(rows[0].cells[columnIndex])) {
        const arrow = document.getElementById("arrow" + columnIndex);
        arrow.innerHTML = table.sortedAscending ? "&#9650;" : "&#9660;";
    }
    rows.sort((a, b) => {
        const aCell = a.cells[columnIndex];
        const bCell = b.cells[columnIndex];
        if (isTextCell(aCell) && isTextCell(bCell)) {
            const aData = aCell.textContent;
            const bData = bCell.textContent;
            return table.sortedAscending
                ? aData.localeCompare(bData)
                : bData.localeCompare(aData);
        }
        return 0;
    });

    while (table.rows.length > 1) {
        table.deleteRow(1);
    }

    rows.forEach((row) => table.appendChild(row));

    table.sortedColumnIndex = columnIndex;
    table.sortedAscending = ascending;
}
function isTextCell(cell) {
    // Proverava da li je ćelija sa tekstom (nije slika i nije tipa buttona)
    return (
        cell.children.length === 0 ||
        (cell.children[0].tagName !== "IMG" &&
            cell.children[0].tagName !== "BUTTON")
    );
}

function openModal(target, data = null) {
    let metoda = "GET";

    let url = target.dataset.url;

    let csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]',
    ).content;

    let objekatZaSlanje = {
        method: metoda,
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
    };

    if (target.dataset.target.includes("obrisi")) {
        objekatZaSlanje.method = "POST";
        objekatZaSlanje.headers["X-HTTP-Method-Override"] = "DELETE";
        url += `?prikaziFormu=true`;
    } else if (target.dataset.target.includes("izmeni")) {
        objekatZaSlanje.method = "GET";
        url += "/edit";
    }

    fetch(url, objekatZaSlanje)
        .then((response) => response.text())
        .then((html) => {
            document.getElementById("modalContent").innerHTML = html;
            document.getElementById("izmeniModal").style.display = "block";

            localStorage.setItem("modalOpen", "true");
            localStorage.setItem("modalContent", html);

            if (document.getElementById("graficki-prikaz-slika")) {
                ispisUploadovaneSlikeIMenjanjeRedosleda();
            }

            if (document.querySelector("#editor")) {
                ClassicEditor.create(document.getElementById("editor"))
                    .then((editor) => {
                        // čuvanje reference na editor instancu
                        editorMoj = editor;
                        console.log(editor);
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }

            if (html.includes("glavnaSlika") || html.includes("slika")) {
                const listingPhotoField =
                    document.getElementById("glavnaSlika") ||
                    document.querySelector(
                        "input[type='file'][name='glavnaSlika']",
                    );

                if (listingPhotoField) {
                    listingPhotoField.addEventListener(
                        "change",
                        handleChangeEvent,
                    );
                }
            }
            if (html.includes("swiper")) {
                setTimeout(function () {
                    new Swiper("#modalContent .swiper", {
                        direction: "horizontal",
                        loop: true,

                        pagination: {
                            el: ".swiper-pagination",
                        },

                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },

                        scrollbar: {
                            el: ".swiper-scrollbar",
                        },
                    });
                }, 0);
            }

            const submitBtn = document.querySelector(".forma-admin-klik");
            if (!submitBtn) return;
            const noviSubmit = submitBtn.cloneNode(true);
            submitBtn.parentNode.replaceChild(noviSubmit, submitBtn);
            noviSubmit.addEventListener("click", function (e) {
                e.preventDefault();
                const formElement = document.getElementById("formaGeneric");
                const actionUrl = formElement.getAttribute("action");

                const validationErrors = validateFormBeforeSubmit();
                if (validationErrors.length > 0) {
                    displayValidationErrors(validationErrors);
                    return;
                }

                const existingErrorElements = document.querySelectorAll(
                    ".text-danger.greska-ispod-polja",
                );
                existingErrorElements.forEach(function (errorElement) {
                    errorElement.parentNode.removeChild(errorElement);
                });

                const formDataObjekat = new FormData(
                    document.getElementById("formaGeneric"),
                );

                let editorSadrzaj = "";
                // Dohvatite sadržaj iz editora
                if (editorMoj != null) {
                    editorSadrzaj = editorMoj.getData();
                    formDataObjekat.append("opis", editorSadrzaj);
                }

                if (promenjenRedosled.length) {
                    if (formDataObjekat.has("podSlike[]")) {
                        formDataObjekat.delete("podSlike[]");
                    }
                    promenjenRedosled.forEach((indeks) => {
                        const slika =
                            document.querySelector("#podSlike").files[indeks];
                        formDataObjekat.append("podSlike[]", slika);
                    });
                }

                dodajSpiner();
                fetch(actionUrl, {
                    method: "POST",
                    body: formDataObjekat,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        ukiniSpiner();
                        if (data.neuspeh) {
                            document.querySelector(
                                ".ako-ima-greske p",
                            ).innerHTML = data.neuspeh;
                        }
                        if (data.errors) {
                            for (const fieldName in data.errors) {
                                if (data.errors.hasOwnProperty(fieldName)) {
                                    const errorMessage =
                                        data.errors[fieldName][0];

                                    let inputField =
                                        document.getElementById(fieldName) ||
                                        document.getElementById(
                                            fieldName + "Dropdown",
                                        ) ||
                                        document.querySelector(
                                            `[name="${fieldName}"]`,
                                        ) ||
                                        document.querySelector(
                                            `[name="${fieldName}[]"]`,
                                        ) ||
                                        document.querySelector(
                                            `[data-field="${fieldName}"]`,
                                        );

                                    if (!inputField) continue;
                                    const formGroup =
                                        inputField.closest(".form-group") ||
                                        inputField.parentNode;
                                    if (!formGroup) continue;

                                    const postojecaGreska =
                                        formGroup.querySelector(
                                            ".greska-ispod-polja",
                                        );
                                    if (postojecaGreska)
                                        postojecaGreska.remove();

                                    const errorElement =
                                        document.createElement("span");
                                    errorElement.className =
                                        "text-danger greska-ispod-polja";
                                    errorElement.innerText = errorMessage;
                                    formGroup.appendChild(errorElement);
                                }
                            }
                        } else {
                            closeModal();

                            Toastify({
                                text: data.uspeh,
                                duration: 3000,
                                destination:
                                    "https://github.com/apvarun/toastify-js",
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "right",
                                stopOnFocus: true,
                                style: {
                                    background:
                                        "linear-gradient(to right, #00b09b, #00b09b)",
                                },
                                onClick: function () {},
                            }).showToast();

                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        }
                    })
                    .catch((error) => {
                        ukiniSpiner();
                        document.querySelector(".ako-ima-greske p").innerHTML =
                            error;
                    });
            });
            initVideoUpload();
        })
        .catch((xhr) => {
            ukiniSpiner();
            console.log(xhr);
            document.querySelector(".ako-ima-greske p").innerHTML = xhr;
        });
}

function handleChangeEvent() {
    let listingPhotoField = null;
    if (editorMoj != null) {
        listingPhotoField = document.querySelectorAll("input[type='file']")[1];
    } else {
        listingPhotoField = document.querySelector("input[type='file']");
    }
    let fileReader = new FileReader();
    let previewHolder = document.querySelector("#slika_preview");

    if (previewHolder != null) {
        fileReader.onload = function (e) {
            previewHolder.src = this.result;
        };
    }
    fileReader.readAsDataURL(listingPhotoField.files[0]);
}

function closeModal() {
    document.getElementById("izmeniModal").style.display = "none";
    localStorage.removeItem("modalOpen");
    localStorage.removeItem("modalContent");
}

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("close-alert")) {
        event.target.parentNode.remove();
    }
});
document.addEventListener("DOMContentLoaded", function () {
    var alertDiv = document.querySelector(".mojStil");
    if (alertDiv) {
        setTimeout(function () {
            alertDiv.style.display = "none";
        }, 4000);
    }
});
function initVideoUpload() {
    const dropZone = document.getElementById("videoDropZone");
    const previewBox = document.getElementById("videoPreviewBox");
    const videoEl = document.getElementById("videoPreview");
    const fileName = document.getElementById("videoFileName");
    const fileSize = document.getElementById("videoFileSize");
    const removeBtn = document.getElementById("videoRemoveBtn");

    if (!dropZone || !previewBox) return;

    const fileInput = dropZone.querySelector('input[type="file"]');
    if (!fileInput) return;

    function showPreview(file) {
        const url = URL.createObjectURL(file);
        videoEl.src = url;
        fileName.textContent = file.name;

        const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
        const maxSize = 20;
        fileSize.textContent = sizeInMB + " MB";

        if (file.size > maxSize * 1024 * 1024) {
            fileSize.style.color = "red";
            fileSize.style.fontWeight = "bold";
            fileSize.innerHTML +=
                ' <span style="color: red;">⚠️ Preveliko! Maksimum je 20MB</span>';

            showVideoError(
                `Video fajl je prevelik! ${sizeInMB}MB. Maksimalna dozvoljena veličina je 20MB.`,
            );
        } else {
            fileSize.style.color = "green";
            const badge = document.getElementById("videoStatusBadge");
            const tekst = document.getElementById("videoStatusTekst");
            if (badge && tekst) {
                badge.className = "video-status-badge";
                tekst.textContent = "Odabran – čeka slanje";
            }
        }

        dropZone.style.display = "none";
        previewBox.style.display = "block";
    }

    function showVideoError(message) {
        const badge = document.getElementById("videoStatusBadge");
        const tekst = document.getElementById("videoStatusTekst");
        if (badge && tekst) {
            badge.className = "video-status-badge error";
            badge.style.backgroundColor = "#dc3545";
            tekst.textContent = message;
            tekst.style.color = "white";
        }
    }

    fileInput.addEventListener("change", function () {
        if (this.files && this.files[0]) showPreview(this.files[0]);
    });

    dropZone.addEventListener("dragover", function (e) {
        e.preventDefault();
        this.classList.add("dragover");
    });

    dropZone.addEventListener("dragleave", function () {
        this.classList.remove("dragover");
    });

    dropZone.addEventListener("drop", function (e) {
        e.preventDefault();
        this.classList.remove("dragover");
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith("video/")) {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            showPreview(file);
        }
    });

    if (removeBtn) {
        removeBtn.addEventListener("click", function () {
            videoEl.src = "";
            fileInput.value = "";
            previewBox.style.display = "none";
            dropZone.style.display = "flex";

            const badge = document.getElementById("videoStatusBadge");
            const tekst = document.getElementById("videoStatusTekst");
            if (badge && tekst) {
                badge.className = "video-status-badge";
                tekst.textContent = "Spreman za upload";
            }
        });
    }
}
function addEventListenerOnce(event, element, onEvent, listenerMark = "") {
    let listenerMarker = event + listenerMark;
    console.log(listenerMarker);
    if (element.classList.contains(listenerMarker)) {
        return;
    }
    element.classList.add(listenerMarker);
    element.addEventListener(event, onEvent);
}

$(document).ready(function () {
    $(".dropdown-checkboxes .form-check-input").on("click", function () {
        if ($(this).parents(".dropdown-menu").length > 0) {
            var checkedOptions = $(this)
                .parents(".dropdown-menu")
                .find(".form-check-input:checked");
            var buttonText = "Izaberite opcije";
            if (checkedOptions.length > 0) {
                buttonText = "Izabrano: ";
                checkedOptions.each(function (index) {
                    buttonText += $(this).siblings("label").text();
                    if (index < checkedOptions.length - 1) {
                        buttonText += ", ";
                    }
                });
            }
            $(this)
                .parents(".dropdown-checkboxes")
                .find(".dropdown-toggle")
                .text(buttonText);
        }
    });
});
function promeni(e) {
    e.preventDefault();

    const radioButtons = document.querySelectorAll(
        'input[type="radio"][name="tipnekretnine"]',
    );
    let textVrednosti = null;

    if (
        document.querySelectorAll(
            'input[type="text"][name="id_tip_nekretnine_atribut[]"]',
        ).length > 0
    ) {
        textVrednosti = document.querySelectorAll(
            'input[type="text"][name="id_tip_nekretnine_atribut[]"]',
        );
    } else {
        textVrednosti = document.querySelectorAll(
            'input[type="text"][name="id_tip_nekretnine_atribut"]',
        );
    }

    const idNekretnine = document.querySelector(
        'input[type="hidden"][name="id"]',
    ).value;
    let pokupi = [];

    textVrednosti.forEach((x) => {
        if (x.value.trim() !== "" && x.value.trim() !== "ne") {
            pokupi.push({
                id_tip_nekretnine_atributi: x.dataset.id,
                vrednost: x.value.trim(),
            });
        }
    });

    let objekatZaSlanjePoPravilima = {
        nekretnina_id: idNekretnine,
        atributi: pokupi,
    };
    //
    let url = "/admin/nekretnineatributivrednost";

    let csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]',
    ).content;
    let method = "POST";
    let objekatZaSlanje = {
        method: method,
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify(objekatZaSlanjePoPravilima),
    };

    fetch(url, objekatZaSlanje)
        .then((response) => response.text())
        .then((html) => {
            document.querySelector(".modal").style.display = "none";

            var newDiv = document.createElement("div");

            newDiv.classList.add("alert", "alert-success", "mojStil");

            newDiv.textContent =
                "Uspesno ste izmenili karakteristike za nekretnine";

            newDiv.innerHTML += '<span class="close-alert">x</span>';

            document.querySelector("main").prepend(newDiv);

            setTimeout(function () {
                document.querySelector(".alert").style.display = "none";
            }, 4000);
        })
        .catch((error) => console.error("Error:", error));
}

document.querySelectorAll(".response-button,.close-button").forEach((x) => {
    x.addEventListener("click", function (e) {
        document.querySelector(".group-item-admin").classList.toggle("show");
    });
});
function dodajSpiner() {
    let modal = document.querySelector(".modal-content");
    modal.classList.add("loading");
}

function ukiniSpiner() {
    let modal = document.querySelector(".modal-content");
    modal.classList.remove("loading");
}
function ispisUploadovaneSlikeIMenjanjeRedosleda() {
    const grafickiPrikazSlika = document.getElementById(
        "graficki-prikaz-slika",
    );
    const inputSlika = document.getElementById("podSlike");

    if (!grafickiPrikazSlika || !inputSlika) return;

    function azurirajBrojeve() {
        grafickiPrikazSlika
            .querySelectorAll(".slika-stavka")
            .forEach((el, i) => {
                el.setAttribute("data-order", i + 1);
            });
    }

    new Sortable(grafickiPrikazSlika, {
        animation: 150,
        onEnd: function () {
            promenjenRedosled = Array.from(
                grafickiPrikazSlika.querySelectorAll("img"),
            ).map((el) => parseInt(el.dataset.indeks));
            azurirajBrojeve();
        },
    });

    inputSlika.addEventListener("change", function () {
        grafickiPrikazSlika.innerHTML = "";

        promenjenRedosled = Array.from(
            { length: inputSlika.files.length },
            (_, i) => i,
        );

        for (let i = 0; i < inputSlika.files.length; i++) {
            const slika = inputSlika.files[i];
            const stavka = document.createElement("div");
            stavka.className = "slika-stavka";
            stavka.setAttribute("data-order", i + 1);

            const img = document.createElement("img");
            img.src = URL.createObjectURL(slika);
            img.setAttribute("data-indeks", i);
            img.alt = slika.name;

            const naziv = document.createElement("div");
            naziv.className = "naziv-slike";
            naziv.innerText = slika.name;

            stavka.appendChild(img);
            stavka.appendChild(naziv);
            grafickiPrikazSlika.appendChild(stavka);
        }
    });
}
document.addEventListener("click", function (e) {
    // Zatvori sve panele ako klik nije unutar dropdowna
    if (!e.target.closest(".custom-dropdown-field")) {
        document
            .querySelectorAll(".custom-dropdown-panel.is-open")
            .forEach((p) => {
                p.classList.remove("is-open");
                p.closest(".custom-dropdown-field")
                    ?.querySelector(".custom-dropdown-trigger")
                    ?.classList.remove("is-open");
            });
    }
});

document.addEventListener("click", function (e) {
    const trigger = e.target.closest(".custom-dropdown-trigger");
    if (!trigger) return;

    const field = trigger.closest(".custom-dropdown-field");
    const panel = field.querySelector(".custom-dropdown-panel");
    const isOpen = panel.classList.contains("is-open");

    document.querySelectorAll(".custom-dropdown-panel.is-open").forEach((p) => {
        if (p !== panel) {
            p.classList.remove("is-open");
            p.closest(".custom-dropdown-field")
                ?.querySelector(".custom-dropdown-trigger")
                ?.classList.remove("is-open");
        }
    });

    panel.classList.toggle("is-open", !isOpen);
    trigger.classList.toggle("is-open", !isOpen);

    if (!isOpen) {
        const rect = trigger.getBoundingClientRect();
        const panelHeight = 260;
        const prostorIspod = window.innerHeight - rect.bottom;

        panel.style.width = rect.width + "px";
        panel.style.left = rect.left + "px";

        if (prostorIspod >= panelHeight || prostorIspod >= 150) {
            panel.style.top = rect.bottom + 4 + "px";
            panel.style.bottom = "auto";
        } else {
            panel.style.bottom = window.innerHeight - rect.top + 4 + "px";
            panel.style.top = "auto";
        }
    }
});

// Zatvori ako klik van dropdowna
document.addEventListener("click", function (e) {
    if (!e.target.closest(".custom-dropdown-field")) {
        document
            .querySelectorAll(".custom-dropdown-panel.is-open")
            .forEach((p) => {
                p.classList.remove("is-open");
                p.closest(".custom-dropdown-field")
                    ?.querySelector(".custom-dropdown-trigger")
                    ?.classList.remove("is-open");
            });
    }
});

// Klik na opciju — ručno hendlaj umesto da se oslanjamo na change event
document.addEventListener("click", function (e) {
    const opcija = e.target.closest(".custom-dropdown-opcija");
    if (!opcija) return;

    e.preventDefault();

    const field = opcija.closest(".custom-dropdown-field");
    const trigger = field.querySelector(".custom-dropdown-trigger");
    const label = trigger.querySelector(".custom-dropdown-trigger__text");
    const input = opcija.querySelector("input");

    if (!input) return;

    const inputType = input.type; // 'radio', 'checkbox', ili 'text'
    const vecCekiran = opcija.classList.contains("is-checked");

    if (inputType === "radio" || inputType === "text") {
        // Odčekiraj sve
        field.querySelectorAll(".custom-dropdown-opcija").forEach((o) => {
            o.classList.remove("is-checked");
            const inp = o.querySelector("input");
            if (!inp) return;
            if (inp.type === "checkbox" || inp.type === "radio") {
                inp.checked = false;
            }
        });

        if (!vecCekiran) {
            // Čekiraj kliknuto
            opcija.classList.add("is-checked");
            if (input.type === "radio") input.checked = true;

            label.textContent = opcija.dataset.label;
            label.classList.add("has-value");

            // Zatvori panel samo za radio, ne za text
            if (inputType === "radio") {
                field
                    .querySelector(".custom-dropdown-panel")
                    .classList.remove("is-open");
                trigger.classList.remove("is-open");
            }
        } else {
            // Bio čekiran — odčekiraj (toggle)
            label.textContent = trigger.__defaultLabel || "";
            label.classList.remove("has-value");
        }
    } else if (inputType === "checkbox") {
        const novoStanje = !input.checked;
        input.checked = novoStanje;
        opcija.classList.toggle("is-checked", novoStanje);

        const checked = field.querySelectorAll(
            ".custom-dropdown-opcija.is-checked",
        );
        if (checked.length === 0) {
            label.textContent = trigger.__defaultLabel || "";
            label.classList.remove("has-value");
        } else {
            label.textContent = Array.from(checked)
                .map((o) => o.dataset.label)
                .join(", ");
            label.classList.add("has-value");
        }
    }
});

// document.addEventListener("change", function (e) {
//     const input = e.target.closest(".custom-dropdown-input");
//     if (!input) return;

//     const field = input.closest(".custom-dropdown-field");
//     const trigger = field.querySelector(".custom-dropdown-trigger");
//     const label = field.querySelector(".custom-dropdown-trigger__text");
//     const opcija = input.closest(".custom-dropdown-opcija");

//     if (input.type === "radio") {
//         // Ukloni is-checked sa svih
//         field
//             .querySelectorAll(".custom-dropdown-opcija")
//             .forEach((o) => o.classList.remove("is-checked"));
//         opcija.classList.add("is-checked");

//         // Ažuriraj label dugmeta
//         label.textContent = opcija.dataset.label;
//         label.classList.add("has-value");

//         // Zatvori panel
//         field
//             .querySelector(".custom-dropdown-panel")
//             .classList.remove("is-open");
//         trigger.classList.remove("is-open");
//     } else if (input.type === "checkbox") {
//         opcija.classList.toggle("is-checked", input.checked);

//         // Ažuriraj label
//         const checked = field.querySelectorAll(
//             ".custom-dropdown-opcija.is-checked",
//         );
//         if (checked.length === 0) {
//             label.textContent =
//                 field.querySelector(".custom-dropdown-trigger")
//                     .__defaultLabel || label.textContent;
//             label.classList.remove("has-value");
//         } else {
//             label.textContent = Array.from(checked)
//                 .map((o) => o.dataset.label)
//                 .join(", ");
//             label.classList.add("has-value");
//         }
//     }
// });

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".custom-dropdown-trigger").forEach((t) => {
        t.__defaultLabel = t
            .querySelector(".custom-dropdown-trigger__text")
            ?.textContent?.trim();
    });
});
document.querySelectorAll(".custom-dropdown-trigger").forEach((t) => {
    t.__defaultLabel = t
        .querySelector(".custom-dropdown-trigger__text")
        ?.textContent?.trim();
});
function validateFormBeforeSubmit() {
    let errors = [];

    // 1. Validacija video fajla (20MB)
    const videoInput = document.querySelector('input[name="video_fajl"]');
    if (videoInput && videoInput.files.length > 0) {
        const videoFile = videoInput.files[0];
        const maxSize = 20 * 1024 * 1024; // 20MB
        const allowedTypes = [
            "video/mp4",
            "video/mov",
            "video/ogg",
            "video/quicktime",
        ];

        if (videoFile.size > maxSize) {
            errors.push({
                field: "video_fajl",
                message: `Video fajl je prevelik! Veličina: ${(videoFile.size / (1024 * 1024)).toFixed(2)}MB. Maksimalna dozvoljena veličina je 20MB.`,
            });
        }

        if (!allowedTypes.includes(videoFile.type)) {
            errors.push({
                field: "video_fajl",
                message: "Video mora biti u formatu: MP4, MOV, OGG ili QT.",
            });
        }
    }

    // 4. Validacija GLAVNE SLIKE (obavezna samo za POST, ne za PUT)
    // Proverite da li je metoda POST (kreiranje) ili PUT (izmena)
    const formElement = document.getElementById("formaGeneric");
    const methodInput = document.querySelector('input[name="_method"]');
    const isPostMethod = !methodInput || methodInput.value === "POST";

    const glavnaSlikaInput = document.querySelector(
        'input[name="glavnaSlika"]',
    );
    if (isPostMethod) {
        // Za kreiranje - glavna slika je obavezna
        if (!glavnaSlikaInput || glavnaSlikaInput.files.length === 0) {
            errors.push({
                field: "glavnaSlika",
                message:
                    "Glavna slika je obavezno polje. Molimo vas da odaberete glavnu sliku.",
            });
        } else {
            // Validacija veličine i tipa ako postoji fajl
            const slikaFile = glavnaSlikaInput.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB
            const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

            if (slikaFile.size > maxSize) {
                errors.push({
                    field: "glavnaSlika",
                    message: `Glavna slika je prevelika! Veličina: ${(slikaFile.size / (1024 * 1024)).toFixed(2)}MB. Maksimalna dozvoljena veličina je 10MB.`,
                });
            }

            if (!allowedTypes.includes(slikaFile.type)) {
                errors.push({
                    field: "glavnaSlika",
                    message:
                        "Glavna slika mora biti u formatu: JPEG, PNG ili JPG.",
                });
            }
        }
    } else {
        // Za izmenu - glavna slika nije obavezna, ali ako je odabrana, validiraj
        if (glavnaSlikaInput && glavnaSlikaInput.files.length > 0) {
            const slikaFile = glavnaSlikaInput.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB
            const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

            if (slikaFile.size > maxSize) {
                errors.push({
                    field: "glavnaSlika",
                    message: `Glavna slika je prevelika! Veličina: ${(slikaFile.size / (1024 * 1024)).toFixed(2)}MB. Maksimalna dozvoljena veličina je 10MB.`,
                });
            }

            if (!allowedTypes.includes(slikaFile.type)) {
                errors.push({
                    field: "glavnaSlika",
                    message:
                        "Glavna slika mora biti u formatu: JPEG, PNG ili JPG.",
                });
            }
        }
    }

    // 5. Validacija POD SLIKA (obavezne samo za POST, ne za PUT)
    const podSlikeInput = document.querySelector('input[name="podSlike[]"]');
    if (isPostMethod) {
        // Za kreiranje - pod slike su obavezne
        if (!podSlikeInput || podSlikeInput.files.length === 0) {
            errors.push({
                field: "podSlike",
                message:
                    "Podslike su obavezno polje. Molimo vas da odaberete barem jednu podsliku.",
            });
        } else {
            // Validacija svake pod slike
            const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
            const maxSize = 10 * 1024 * 1024; // 10MB

            for (let i = 0; i < podSlikeInput.files.length; i++) {
                const slikaFile = podSlikeInput.files[i];

                if (slikaFile.size > maxSize) {
                    errors.push({
                        field: "podSlike",
                        message: `Slika "${slikaFile.name}" je prevelika! Veličina: ${(slikaFile.size / (1024 * 1024)).toFixed(2)}MB. Maksimalna dozvoljena veličina je 10MB po slici.`,
                    });
                    break;
                }

                if (!allowedTypes.includes(slikaFile.type)) {
                    errors.push({
                        field: "podSlike",
                        message: `Slika "${slikaFile.name}" mora biti u formatu: JPEG, PNG ili JPG.`,
                    });
                    break;
                }
            }
        }
    } else {
        // Za izmenu - pod slike nisu obavezne, ali ako su odabrane, validiraj
        if (podSlikeInput && podSlikeInput.files.length > 0) {
            const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
            const maxSize = 10 * 1024 * 1024; // 10MB

            for (let i = 0; i < podSlikeInput.files.length; i++) {
                const slikaFile = podSlikeInput.files[i];

                if (slikaFile.size > maxSize) {
                    errors.push({
                        field: "podSlike",
                        message: `Slika "${slikaFile.name}" je prevelika! Veličina: ${(slikaFile.size / (1024 * 1024)).toFixed(2)}MB. Maksimalna dozvoljena veličina je 10MB po slici.`,
                    });
                    break;
                }

                if (!allowedTypes.includes(slikaFile.type)) {
                    errors.push({
                        field: "podSlike",
                        message: `Slika "${slikaFile.name}" mora biti u formatu: JPEG, PNG ili JPG.`,
                    });
                    break;
                }
            }
        }
    }

    // 6. Validacija ostalih obaveznih polja
    const nazivInput = document.querySelector('input[name="naziv"]');
    if (nazivInput && !nazivInput.value.trim()) {
        errors.push({
            field: "naziv",
            message: "Naziv je obavezno polje.",
        });
    }

    const cenaInput = document.querySelector('input[name="cena"]');
    if (cenaInput && !cenaInput.value.trim()) {
        errors.push({
            field: "cena",
            message: "Cena je obavezno polje.",
        });
    } else if (
        cenaInput &&
        cenaInput.value.trim() &&
        isNaN(parseFloat(cenaInput.value))
    ) {
        errors.push({
            field: "cena",
            message: "Cena mora biti broj.",
        });
    }

    const sifraInput = document.querySelector('input[name="sifra_nekretnine"]');
    if (sifraInput && !sifraInput.value.trim()) {
        errors.push({
            field: "sifra_nekretnine",
            message: "Šifra nekretnine je obavezno polje.",
        });
    }

    const opisEditor = editorMoj;
    if (opisEditor && !opisEditor.getData().trim()) {
        errors.push({
            field: "opis",
            message: "Opis je obavezno polje.",
        });
    }

    return errors;
}
function displayValidationErrors(errors) {
    // Prvo uklonite postojeće greške
    const existingErrorElements = document.querySelectorAll(
        ".text-danger.greska-ispod-polja",
    );
    existingErrorElements.forEach(function (errorElement) {
        errorElement.parentNode.removeChild(errorElement);
    });

    // Uklonite i globalne greške ako postoje
    const globalErrorContainer = document.querySelector(".ako-ima-greske");
    if (globalErrorContainer) {
        globalErrorContainer.innerHTML = "<p></p>";
    }

    // Prikažite nove greške
    errors.forEach((error) => {
        let inputField =
            document.getElementById(error.field) ||
            document.querySelector(`[name="${error.field}"]`) ||
            document.querySelector(`[name="${error.field}[]"]`);

        if (!inputField && error.field === "opis" && editorMoj) {
            // Za editor, pronađite njegov container
            inputField = document.querySelector(".ck-editor__editable");
        }

        if (inputField) {
            const formGroup =
                inputField.closest(".form-group") || inputField.parentNode;
            if (formGroup) {
                const errorElement = document.createElement("span");
                errorElement.className = "text-danger greska-ispod-polja";
                errorElement.style.display = "block";
                errorElement.style.marginTop = "5px";
                errorElement.style.fontSize = "12px";
                errorElement.innerText = error.message;
                formGroup.appendChild(errorElement);
            }
        } else {
            // Ako ne možemo pronaći polje, prikažite globalnu grešku
            const globalErrorContainer =
                document.querySelector(".ako-ima-greske");
            if (globalErrorContainer) {
                const errorElement = document.createElement("div");
                errorElement.className = "alert alert-danger";
                errorElement.style.marginTop = "10px";
                errorElement.innerText = error.message;
                globalErrorContainer.appendChild(errorElement);
            }
        }
    });

    // Skrolujte do prve greške
    const firstError = document.querySelector(".greska-ispod-polja");
    if (firstError) {
        firstError.scrollIntoView({ behavior: "smooth", block: "center" });
    }
}
