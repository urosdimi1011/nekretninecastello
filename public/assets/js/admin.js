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
        // objekatZaSlanje.method = "DELETE";
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
                let listingPhotoField =
                    document.querySelector("input[type='file']");
                listingPhotoField.addEventListener("change", handleChangeEvent);
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
            document
                .querySelector(".forma-admin-klik")
                .addEventListener("click", function (e) {
                    e.preventDefault();
                    const formElement = document.getElementById("formaGeneric");
                    const actionUrl = formElement.getAttribute("action");

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
                                document.querySelector("#podSlike").files[
                                    indeks
                                ];
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
                                ).innerHTML = error.neuspeh;
                            }
                            if (data.errors) {
                                for (const fieldName in data.errors) {
                                    if (data.errors.hasOwnProperty(fieldName)) {
                                        const errorMessage =
                                            data.errors[fieldName][0];

                                        let inputField =
                                            document.getElementById(
                                                fieldName,
                                            ) ||
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
                            document.querySelector(
                                ".ako-ima-greske p",
                            ).innerHTML = error;
                        });
                });
        })
        .catch((xhr) => {
            ukiniSpiner();
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
function showPreview(file) {
    const url = URL.createObjectURL(file);
    videoEl.src = url;
    fileName.textContent = file.name;
    fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + " MB";
    dropZone.style.display = "none";
    previewBox.style.display = "block";

    // Postavi status na "čeka upload"
    const badge = document.getElementById("videoStatusBadge");
    const tekst = document.getElementById("videoStatusTekst");
    if (badge && tekst) {
        badge.className = "video-status-badge";
        tekst.textContent = "Odabran – čeka slanje";
    }
}

const badge = document.getElementById("videoStatusBadge");
const tekst = document.getElementById("videoStatusTekst");
if (badge && tekst) {
    badge.classList.add("status-poslan");
    tekst.textContent = "Video uspešno poslan";
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
    // Kada korisnik klikne na checkbox
    $(".dropdown-checkboxes .form-check-input").on("click", function () {
        // Proverite da li je kliknut checkbox u dropdown-u
        if ($(this).parents(".dropdown-menu").length > 0) {
            // Osvežite tekst na dugmetu na osnovu izabranih opcija
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

// document.querySelector(".modal").addEventListener("click", function (e) {
//     // if (e.target === document.querySelector(".modal-content")) {
//     //     e.preventDefault();
//     // this.style.display = "none";
//     // }
// });
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
    let obj = document.querySelector("#modalContent");

    obj.querySelector(".form-container form").style.opacity = "0";

    document.querySelector(".lds-spinner").style.display = "block";
}
function ukiniSpiner() {
    let obj = document.querySelector("#modalContent");

    obj.querySelector(".form-container form").style.opacity = "1";

    document.querySelector(".lds-spinner").style.display = "none";
}

function ispisUploadovaneSlikeIMenjanjeRedosleda() {
    const grafickiPrikazSlika = document.getElementById(
        "graficki-prikaz-slika",
    );
    const inputSlika = document.getElementById("podSlike");

    new Sortable(grafickiPrikazSlika, {
        animation: 150,
        onEnd: function (event) {
            promenjenRedosled = Array.from(
                grafickiPrikazSlika.querySelectorAll("img"),
            ).map((element) => parseInt(element.dataset.indeks));
        },
    });

    inputSlika.addEventListener("change", function () {
        grafickiPrikazSlika.innerHTML = ""; // Obrišite prethodni prikaz

        promenjenRedosled = Array.from(
            { length: inputSlika.files.length },
            (_, indeks) => indeks,
        );

        for (let i = 0; i < inputSlika.files.length; i++) {
            const slika = inputSlika.files[i];
            const slikaStavka = document.createElement("div");
            slikaStavka.className = "slika-stavka";

            const img = document.createElement("img");
            img.src = URL.createObjectURL(slika);
            img.setAttribute("data-indeks", i);
            img.alt = slika.name;

            const nazivSlike = document.createElement("div");
            nazivSlike.className = "naziv-slike";
            nazivSlike.innerText = slika.name;

            slikaStavka.appendChild(img);
            slikaStavka.appendChild(nazivSlike);

            grafickiPrikazSlika.appendChild(slikaStavka);
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

    // Zatvori sve ostale
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
});

document.addEventListener("change", function (e) {
    const input = e.target.closest(".custom-dropdown-input");
    if (!input) return;

    const field = input.closest(".custom-dropdown-field");
    const trigger = field.querySelector(".custom-dropdown-trigger");
    const label = field.querySelector(".custom-dropdown-trigger__text");
    const opcija = input.closest(".custom-dropdown-opcija");

    if (input.type === "radio") {
        // Ukloni is-checked sa svih
        field
            .querySelectorAll(".custom-dropdown-opcija")
            .forEach((o) => o.classList.remove("is-checked"));
        opcija.classList.add("is-checked");

        // Ažuriraj label dugmeta
        label.textContent = opcija.dataset.label;
        label.classList.add("has-value");

        // Zatvori panel
        field
            .querySelector(".custom-dropdown-panel")
            .classList.remove("is-open");
        trigger.classList.remove("is-open");
    } else if (input.type === "checkbox") {
        opcija.classList.toggle("is-checked", input.checked);

        // Ažuriraj label
        const checked = field.querySelectorAll(
            ".custom-dropdown-opcija.is-checked",
        );
        if (checked.length === 0) {
            label.textContent =
                field.querySelector(".custom-dropdown-trigger")
                    .__defaultLabel || label.textContent;
            label.classList.remove("has-value");
        } else {
            label.textContent = Array.from(checked)
                .map((o) => o.dataset.label)
                .join(", ");
            label.classList.add("has-value");
        }
    }
});

document.querySelectorAll(".custom-dropdown-trigger").forEach((t) => {
    t.__defaultLabel = t
        .querySelector(".custom-dropdown-trigger__text")
        ?.textContent?.trim();
});
