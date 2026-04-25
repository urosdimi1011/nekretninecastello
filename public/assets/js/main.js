// import {sum} from "./app.js";

let sortingData = null;
let trenutniTipNekretnine = null;

document
    .querySelectorAll(".main-nav .dropdown-toggle")
    .forEach(function (toggle) {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle("show-mobile");
            this.classList.toggle("active");
        });
    });
document.addEventListener("DOMContentLoaded", function () {
    if (window.location.pathname === "/") {
        var splide1 = new Splide(".splide", {
            type: "loop",
            autoplay: true,
            height: "50rem",
            pauseOnHover: false,
            breakpoints: {
                1500: {
                    height: "60rem",
                },
                1200: {
                    height: "40rem",
                },
                1000: {
                    height: "30rem",
                },
                860: {
                    height: "25rem",
                },
                600: {
                    height: "30rem",
                },
            },
        });

        var splide2 = new Splide(".splide2", {
            type: "loop",
            perPage: 3,
            breakpoints: {
                1200: {
                    perPage: 2,
                },
                600: {
                    perPage: 1,
                },
            },
            perMove: 1,
            gap: 40,
            arrows: false,
            autoplay: true,
        });
        splide1.mount();
        splide2.mount();
    } else if (window.location.pathname.includes("nekretnine")) {
        var elementiZaSlider =
            document.getElementsByClassName("nekretnina-slider");

        var elementiZaSlider2 =
            document.getElementsByClassName("thumbnail-carousel");

        for (var i = 0; i < elementiZaSlider.length; i++) {
            var main = new Splide(elementiZaSlider[i], {
                gap: 10,
                pagination: false,
                rewind: true,
                autoplay: true,
                snap: true,
                focus: "center",
                breakpoints: {
                    600: {
                        fixedWidth: 60,
                        fixedHeight: 44,
                    },
                },
            });

            var thumbnails = new Splide(elementiZaSlider2[i], {
                fixedWidth: 100,
                fixedHeight: 60,
                gap: 10,
                rewind: true,
                pagination: false,
                isNavigation: true,
                arrows: false,
                focus: "center",
                breakpoints: {
                    600: {
                        fixedWidth: 60,
                        fixedHeight: 44,
                    },
                },
            });

            main.sync(thumbnails);
            main.mount();
            thumbnails.mount();
        }
    }
});
//Ovo otkomentarisati ukoliko budu vratili slajder za slike
// sliderZaNekretnine();
function sliderZaNekretnine() {
    var elms = document.getElementsByClassName("istaknuti");
    console.log(elms);
    if (elms.length) {
        for (let i = 0; i < elms.length; i++) {
            new Splide(elms[i], {
                perPage: 1,
                type: "loop",
                drag: "free",
                perMove: 1,
                pagination: true,
                lazyLoad: "nearby",
            }).mount();
        }
    }
}

const dropdownItems = document.querySelectorAll(
    ".navbar-nav .menu-item-has-children",
);

dropdownItems.forEach((item) => {
    item.addEventListener("mouseenter", () => {
        item.classList.add("hovered");
    });

    item.addEventListener("mouseleave", () => {
        item.classList.remove("hovered");
    });
});

document.addEventListener("scroll", function () {
    let header = document.querySelector(".header");

    if (window.pageYOffset >= header.offsetTop + 50) {
        header.classList.add("fiksiraj-navigaciju");
    } else {
        header.classList.remove("fiksiraj-navigaciju");
    }
});
document
    .querySelector(".response-button")
    .addEventListener("click", function (e) {
        document
            .querySelector(".main-nav")
            .classList.toggle("vrati-navigaciju");
        document.querySelector(".black-wall").classList.toggle("active");
        document.querySelector("body").classList.toggle("skloni-scroll");
    });
document.querySelector(".close-button").addEventListener("click", function (e) {
    document.querySelector(".main-nav").classList.toggle("vrati-navigaciju");
    document.querySelector(".black-wall").classList.toggle("active");
    document.querySelector("body").classList.toggle("skloni-scroll");
});
document.querySelector(".black-wall").addEventListener("click", function () {
    document.querySelector(".main-nav").classList.toggle("vrati-navigaciju");
    document.querySelector(".black-wall").classList.toggle("active");
    document.querySelector("body").classList.toggle("skloni-scroll");
});

const formaDugme = document.querySelector(".dugme-forme-kontakt");
//Kontakt forma

if (window.location.pathname.includes("kontakt")) {
    formaDugme.addEventListener("click", regulisiFormu);
}

function regulisiFormu(e) {
    e.preventDefault();

    let nemaGreske = [];

    var greske = {
        akoNemaNista: "",
        greska: "",
    };
    greske.akoNemaNista = "Morate uneti ime i prezime";
    greske.greska = "Ime i prezime moraju da počinju velikim slovom";

    var imeIPrezime = document.querySelector("#imeIPrezime");
    var imeIPrezimeReg = /^([A-ZČĆĐŠŽa-zčćđšž]+)(\s[A-ZČĆĐŠŽa-zčćđšž]+){1,}$/;

    nemaGreske.push(validateInput(imeIPrezime, imeIPrezimeReg, greske));

    var phoneNumberInput = document.querySelector("#brojTelefona");
    var phoneNumberReg = /^\+(?:[0-9] ?){6,14}[0-9]$/;

    greske.akoNemaNista = "Morate uneti broj telefona";
    greske.greska = "Broj telefona mora početi +381 ...";

    nemaGreske.push(validateInput(phoneNumberInput, phoneNumberReg, greske));

    var emailInput = document.querySelector("#email");
    var emailReg = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    greske.akoNemaNista = "Morate uneti email";
    greske.greska = "Nije unet dobar format email adrese";

    nemaGreske.push(validateInput(emailInput, emailReg, greske));

    var porukaInput = document.querySelector("#poruka");
    porukaInput.parentElement.nextElementSibling.innerHTML = "";
    porukaInput.classList.remove("error-form-input");
    if (porukaInput.value.length < 20) {
        porukaInput.classList.add("error-form-input");
        porukaInput.parentElement.nextElementSibling.innerHTML =
            "Morate uneti vise od 20 karaktera";
        nemaGreske.push(false);
    }

    if (!nemaGreske.some((x) => x === false)) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        fetch("/send-mail", {
            method: "POST",
            body: JSON.stringify({
                imeIPrezime: imeIPrezime.value,
                brojTelefona: phoneNumberInput.value,
                email: emailInput.value,
                poruka: porukaInput.value,
            }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
        })
            .then((response) => {
                if (response.ok) {
                    Toastify({
                        text: "Uspesno ste poslali poruku.",
                        duration: 3000,
                        destination: "https://github.com/apvarun/toastify-js",
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background:
                                "linear-gradient(to right, #00b09b, #00b09b)",
                        },
                        onClick: function () {}, // Callback after click
                    }).showToast();

                    document.querySelector("form").reset();
                } else {
                    document.querySelector(".greska-sa-servera").innerHTML =
                        response.text();
                }
            })
            .catch((error) => {
                console.error(error);
            });
    }
}

function validateInput(input, regEx, errorMessage = "") {
    input.classList.remove("error-form-input");
    input.nextElementSibling.innerHTML = "";

    if (input.value === "") {
        input.classList.add("error-form-input");
        input.nextElementSibling.innerHTML = errorMessage.akoNemaNista;

        return false;
    } else if (!regEx.test(input.value)) {
        input.classList.add("error-form-input");
        if (errorMessage) {
            input.nextElementSibling.innerHTML = errorMessage.greska;
        }
        return false;
    }

    return true;
}

document.querySelectorAll(".custom-select").forEach(function (selectElement) {
    var classes = selectElement.className;
    var id = selectElement.id;
    var name = selectElement.name;
    var placeholder = selectElement.getAttribute("placeholder");

    var template = '<div class="' + classes + '">';
    template +=
        '<span class="custom-select-trigger">' + placeholder + "</span>";
    template += '<div class="custom-options">';

    selectElement.querySelectorAll("option").forEach(function (optionElement) {
        var optionClass = optionElement.className;
        var optionValue = optionElement.value;
        var optionText = optionElement.textContent;
        var selected = "";
        if (optionElement.selected) {
            selected = "selection";
        }

        template +=
            '<span class="custom-option ' +
            optionClass +
            " " +
            selected +
            '" data-value="' +
            optionValue +
            '">' +
            optionText +
            "</span>";
    });

    template += "</div></div>";

    var wrapper = document.createElement("div");
    wrapper.className = "custom-select-wrapper";
    selectElement.parentNode.insertBefore(wrapper, selectElement);
    selectElement.style.display = "none";
    wrapper.appendChild(selectElement);
    wrapper.insertAdjacentHTML("beforeend", template);

    document.querySelectorAll(".custom-option").forEach(function (option) {
        if (
            option
                .closest(".custom-select")
                .classList.contains("tipNekretnine-select") &&
            option.classList.contains("selection")
        ) {
            trenutniTipNekretnine = option.dataset.value;
            option
                .closest(".custom-select")
                .querySelector(".custom-select-trigger").textContent =
                option.textContent;
        }
    });
});
if (window.location.pathname === "/nekretnine") {
    document
        .querySelector(".custom-option:first-of-type")
        .addEventListener("mouseover", function () {
            this.closest(".custom-options").classList.add("option-hover");
        });
} else if (window.location.pathname === "/kontakt") {
    const tekstArea = document.getElementById("poruka");
    tekstArea.addEventListener("input", azurirajBrojKaraktera);
}

document.querySelectorAll(".custom-select-trigger").forEach(function (trigger) {
    trigger.addEventListener("click", function (event) {
        this.closest(".custom-select").classList.toggle("opened");
        event.stopPropagation();
    });
});

document.querySelectorAll(".custom-option").forEach(function (option) {
    option.addEventListener("click", function () {
        dodajSpiner();

        var select = this.closest(".custom-select-wrapper").querySelector(
            "select",
        );
        let url = "";
        select.value = this.getAttribute("data-value");

        if (
            this.parentNode.parentNode.classList.contains(
                "tipNekretnine-select",
            )
        ) {
            trenutniTipNekretnine = select.value;
            console.log(trenutniTipNekretnine);

            if (this.getAttribute("data-value") === "") {
                const tipNaslov = document.querySelector(".tip-naslov");
                if (tipNaslov) {
                    tipNaslov.textContent = "";
                    tipNaslov.classList.add("tip-naslov--prazan");
                }
            } else {
                const tipNaslov = document.querySelector(".tip-naslov");
                if (tipNaslov) {
                    tipNaslov.textContent = this.textContent;
                    tipNaslov.classList.remove("tip-naslov--prazan");
                }
            }
        } else {
            sortingData = select.value;
        }

        url = `/nekretnine?`;

        if (trenutniTipNekretnine !== "") {
            url += `&tip=${trenutniTipNekretnine}`;
        }
        if (sortingData != null) {
            url += `&sort=${sortingData}`;
        }

        url += `&page=1`;

        this.closest(".custom-options")
            .querySelectorAll(".custom-option")
            .forEach(function (opt) {
                opt.classList.remove("selection");
            });
        this.classList.add("selection");
        this.closest(".custom-select").classList.remove("opened");
        this.closest(".custom-select").querySelector(
            ".custom-select-trigger",
        ).textContent = this.textContent;

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        fetch(url, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": csrfToken,
            },
        })
            .then((response) => {
                if (response.ok) {
                    response.json().then((x) => ispisiNekretnine(x));
                } else {
                }
            })
            .catch((error) => {
                console.error(error);
            });
    });
});

function ispisPaginacije(celaPaginacija, blokZaPaginaciju) {
    var paginacija = celaPaginacija;
    var paginacijaHtml =
        '<nav class="custom-pagination"><ul class="pagination-list">';
    if (paginacija.current_page > 1) {
        paginacijaHtml += `<li><a href="#" data-page="${paginacija.current_page - 1}">&laquo;</a></li>`;
    } else {
        paginacijaHtml += `<li class="disabled"><span>&laquo;</span></li>`;
    }

    var prikaziDots1 = false;
    var prikaziDots2 = false;

    for (var i = 1; i <= paginacija.last_page; i++) {
        var isPredPoslednjaStranica = i === paginacija.last_page - 1;
        var isPoslednjaStranica = i === paginacija.last_page;

        if (
            i === 1 ||
            i === paginacija.current_page ||
            i === paginacija.current_page - 1 ||
            i === paginacija.current_page + 1 ||
            isPredPoslednjaStranica ||
            isPoslednjaStranica
        ) {
            var aktivnaKlasa =
                i === paginacija.current_page ? 'class="active"' : "";
            var linkIliSpan =
                i === paginacija.current_page
                    ? `<span>${i}</span>`
                    : `<a href="#" data-page="${i}">${i}</a>`;

            paginacijaHtml += `<li ${aktivnaKlasa}>${linkIliSpan}</li>`;
        } else if (i > 1 && i < paginacija.current_page - 1 && !prikaziDots1) {
            paginacijaHtml += '<li class="disabled"><span>...</span></li>';
            prikaziDots1 = true;
        } else if (
            i < paginacija.last_page &&
            i > paginacija.current_page + 1 &&
            !prikaziDots2
        ) {
            paginacijaHtml += '<li class="disabled"><span>...</span></li>';
            prikaziDots2 = true;
        }
    }

    // Next Page
    if (paginacija.current_page < paginacija.last_page) {
        paginacijaHtml += `<li><a href="#" data-page="${paginacija.current_page + 1}">&raquo;</a></li>`;
    } else {
        paginacijaHtml += `<li class="disabled"><span>&raquo;</span></li>`;
    }

    paginacijaHtml += "</ul></nav>";
    blokZaPaginaciju.innerHTML = paginacijaHtml;
}

function ispisiNekretnine(ne) {
    let html = "";
    document.querySelector(".rez").innerHTML = ne.pagination.total;
    let obj = document.querySelector(".nekretnine-sve-js");
    console.log(ne);
    if (ne.components.length) {
        ne.components.forEach((x) => {
            html += '<div class="col-12 col-md-6 col-lg-4">';
            html += x;
            html += "</div>";
        });
        console.log(obj);
        obj.innerHTML = html;

        ispisPaginacije(ne.pagination, document.querySelector(".pag"));
        const paginationNav = document.querySelector(".custom-pagination");
        if (paginationNav) {
            paginationNav.addEventListener("click", function (event) {
                const targetLink = event.target.closest("a[data-page]");

                if (!targetLink) return;

                event.preventDefault();

                if (targetLink.parentElement.classList.contains("disabled")) {
                    return;
                }

                dodajSpiner();

                var pageNumber = targetLink.getAttribute("data-page");
                var url = `/nekretnine?page=${pageNumber}`;

                if (sortingData != null) {
                    url += `&sort=${sortingData}`;
                }
                if (trenutniTipNekretnine != null) {
                    url += `&tip=${trenutniTipNekretnine}`;
                }

                fetch(url, {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then((response) => (response.ok ? response.json() : null))
                    .then((data) => {
                        if (data) ispisiNekretnine(data);
                    })
                    .catch((error) => console.error(error));
            });
        }
    } else {
        html += `<div class="col-12 text-center ako-nema-nekretnina-poruka">
                    <p>Trenutno nema nekretnina za zadati kriterijum filtriranja</p>
               </div>`;
        obj.innerHTML = html;
    }
}

document.addEventListener("click", function () {
    document.querySelectorAll(".custom-select").forEach(function (select) {
        select.classList.remove("opened");
    });
});

function dodajSpiner() {
    let obj = document.querySelector(".nekretnine-sve-js");
    var spinner =
        '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';

    obj.innerHTML = spinner;
}

function azurirajBrojKaraktera() {
    const tekstArea = document.getElementById("poruka");
    const brojPreostalihKaraktera = document.getElementById(
        "brojPreostalihKaraktera",
    );
    const maksimalniBrojKaraktera = 250;

    const trenutniBrojKaraktera = tekstArea.value.length;
    const preostaliKarakteri = maksimalniBrojKaraktera - trenutniBrojKaraktera;

    brojPreostalihKaraktera.textContent = `${preostaliKarakteri}`;
}

// ===== NOTIFIKACIJE =====
const notifOverlay = document.getElementById("notifOverlay");
const notifFormBody = document.getElementById("notifFormBody");
const notifSuccess = document.getElementById("notifSuccess");
let notifTipId = null;

document.getElementById("openNotifModal")?.addEventListener("click", () => {
    notifOverlay.classList.add("active");
    document.body.classList.add("skloni-scroll");
});

function closeNotifModal() {
    notifOverlay.classList.remove("active");
    document.body.classList.remove("skloni-scroll");
}

document
    .getElementById("closeNotifModal")
    ?.addEventListener("click", closeNotifModal);
document
    .getElementById("notifBtnOtkazi")
    ?.addEventListener("click", closeNotifModal);

notifOverlay?.addEventListener("click", function (e) {
    if (e.target === notifOverlay) closeNotifModal();
});

document.querySelectorAll(".notif-tip-pill").forEach((pill) => {
    pill.addEventListener("click", function () {
        document
            .querySelectorAll(".notif-tip-pill")
            .forEach((p) => p.classList.remove("active"));
        this.classList.add("active");
        notifTipId = this.dataset.id;
        document.getElementById("odabraniTipId").value = notifTipId;
        document.getElementById("tipError").textContent = "";
        ucitajAtribute(notifTipId);
    });
});

const opcijePoAtributu = {
    grejanje: ["Centralno", "Etažno", "TA peć", "Klima", "Podno"],
    parking: ["Da", "Ne"],
    garaža: ["Ima", "Nema"],
};

function ucitajAtribute(tipId) {
    const sekcija = document.getElementById("notifAtributiSekcija");
    const grid = document.getElementById("notifAtributiGrid");
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/api/tip-atributi/${tipId}`, {
        headers: { "X-CSRF-TOKEN": csrfToken },
    })
        .then((r) => r.json())
        .then((atributi) => {
            const exclude = new Set(["kvadratura", "površina placa"]);
            const filtrirani = atributi.filter(
                (a) => !exclude.has(a.naziv.toLowerCase()),
            );

            if (!filtrirani.length) {
                sekcija.style.display = "none";
                return;
            }

            sekcija.style.display = "block";
            grid.innerHTML = "";

            filtrirani.forEach((a) => {
                const div = document.createElement("div");
                div.className = "notif-atribut-field";
                const naziv = a.naziv.toLowerCase();
                let inputHtml = "";

                if (naziv === "sobe") {
                    inputHtml = `
                        <div class="sobe-range">
                            <select name="atributi_min[${a.id}]" data-atribut-id="${a.id}" data-tip="sobe_min">
                                <option value="">Svejedno (od)</option>
                                <option value="1">1 soba</option>
                                <option value="2">2 sobe</option>
                                <option value="3">3 sobe</option>
                                <option value="4">4 sobe</option>
                                <option value="5">5+ soba</option>
                            </select>
                            <select name="atributi_max[${a.id}]" data-atribut-id="${a.id}" data-tip="sobe_max">
                                <option value="">Svejedno (do)</option>
                                <option value="1">1 soba</option>
                                <option value="2">2 sobe</option>
                                <option value="3">3 sobe</option>
                                <option value="4">4 sobe</option>
                                <option value="5">5+ soba</option>
                            </select>
                        </div>`;
                } else {
                    const opcije = opcijePoAtributu[naziv] || ["Da", "Ne"];
                    inputHtml = `
                        <select name="atributi[${a.id}]" data-atribut-id="${a.id}">
                            <option value="">Svejedno</option>
                            ${opcije.map((o) => `<option value="${o.toLowerCase()}">${o}</option>`).join("")}
                        </select>`;
                }

                div.innerHTML = `<label>${a.naziv}</label>${inputHtml}`;
                grid.appendChild(div);
            });
        });
}

function setCenaToggle(poMetru) {
    document.getElementById("cenaPoMetru").value = poMetru ? "1" : "0";
    document
        .getElementById("notifBtnUkupno")
        .classList.toggle("active", !poMetru);
    document
        .getElementById("notifBtnMetar")
        .classList.toggle("active", poMetru);

    document.getElementById("notifCenaMin").placeholder = poMetru
        ? "npr. 500"
        : "npr. 30000";
    document.getElementById("notifCenaMax").placeholder = poMetru
        ? "npr. 2000"
        : "npr. 150000";

    const sufiks = poMetru ? " (€/m²)" : " (€)";
    document.getElementById("labelCenaMin").textContent = "Min cena" + sufiks;
    document.getElementById("labelCenaMax").textContent = "Max cena" + sufiks;
}

document
    .getElementById("notifBtnUkupno")
    ?.addEventListener("click", () => setCenaToggle(false));
document
    .getElementById("notifBtnMetar")
    ?.addEventListener("click", () => setCenaToggle(true));

document
    .getElementById("notifBtnPrijavi")
    ?.addEventListener("click", function () {
        let valid = true;

        // Email
        const email = document.getElementById("notifEmail").value.trim();
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById("emailError").textContent =
                "Unesite ispravnu email adresu";
            valid = false;
        } else {
            document.getElementById("emailError").textContent = "";
        }

        // Tip
        if (!notifTipId) {
            document.getElementById("tipError").textContent =
                "Izaberite tip nekretnine";
            valid = false;
        } else {
            document.getElementById("tipError").textContent = "";
        }

        // Cena — bar jedno polje mora biti popunjeno
        const cenaMinVal = document.getElementById("notifCenaMin").value.trim();
        const cenaMaxVal = document.getElementById("notifCenaMax").value.trim();
        const cenaMin = cenaMinVal !== "" ? Number(cenaMinVal) : null;
        const cenaMax = cenaMaxVal !== "" ? Number(cenaMaxVal) : null;

        if (cenaMin === null && cenaMax === null) {
            document.getElementById("cenaError").textContent =
                "Unesite bar min ili max cenu";
            valid = false;
        } else if (cenaMin !== null && isNaN(cenaMin)) {
            document.getElementById("cenaError").textContent =
                "Unesite ispravan broj za min cenu";
            valid = false;
        } else if (cenaMax !== null && isNaN(cenaMax)) {
            document.getElementById("cenaError").textContent =
                "Unesite ispravan broj za max cenu";
            valid = false;
        } else if (cenaMin !== null && cenaMin < 0) {
            document.getElementById("cenaError").textContent =
                "Cena ne može biti negativna";
            valid = false;
        } else if (cenaMax !== null && cenaMax < 0) {
            document.getElementById("cenaError").textContent =
                "Cena ne može biti negativna";
            valid = false;
        } else if (cenaMin !== null && cenaMax !== null && cenaMin > cenaMax) {
            document.getElementById("cenaError").textContent =
                "Min cena ne može biti veća od max";
            valid = false;
        } else {
            document.getElementById("cenaError").textContent = "";
        }

        // Kvadratura — bar jedno polje mora biti popunjeno
        const kvadMinVal = document.getElementById("notifKvadMin").value.trim();
        const kvadMaxVal = document.getElementById("notifKvadMax").value.trim();
        const kvadMin = kvadMinVal !== "" ? Number(kvadMinVal) : null;
        const kvadMax = kvadMaxVal !== "" ? Number(kvadMaxVal) : null;

        if (kvadMin === null && kvadMax === null) {
            document.getElementById("kvadError").textContent =
                "Unesite bar min ili max kvadraturu";
            valid = false;
        } else if (kvadMin !== null && isNaN(kvadMin)) {
            document.getElementById("kvadError").textContent =
                "Unesite ispravan broj";
            valid = false;
        } else if (kvadMax !== null && isNaN(kvadMax)) {
            document.getElementById("kvadError").textContent =
                "Unesite ispravan broj";
            valid = false;
        } else if (kvadMin !== null && kvadMin < 0) {
            document.getElementById("kvadError").textContent =
                "Kvadratura ne može biti negativna";
            valid = false;
        } else if (kvadMax !== null && kvadMax < 0) {
            document.getElementById("kvadError").textContent =
                "Kvadratura ne može biti negativna";
            valid = false;
        } else if (kvadMin !== null && kvadMax !== null && kvadMin > kvadMax) {
            document.getElementById("kvadError").textContent =
                "Min kvadratura ne može biti veća od max";
            valid = false;
        } else {
            document.getElementById("kvadError").textContent = "";
        }

        // Sobe validacija
        const sobeMinSel = document.querySelector('[data-tip="sobe_min"]');
        const sobeMaxSel = document.querySelector('[data-tip="sobe_max"]');
        if (sobeMinSel && sobeMaxSel) {
            const sobeMin = sobeMinSel.value;
            const sobeMax = sobeMaxSel.value;
            if (sobeMin && sobeMax && parseInt(sobeMin) > parseInt(sobeMax)) {
                sobeMaxSel.style.borderColor = "#dc3545";
                valid = false;
            } else {
                sobeMaxSel.style.borderColor = "";
            }
        }

        if (!valid) return;

        // Skupljanje atributa
        const atributi = {};

        // Obični atributi (ne sobe)
        document
            .querySelectorAll("#notifAtributiGrid select:not([data-tip])")
            .forEach((sel) => {
                if (sel.value) atributi[sel.dataset.atributId] = sel.value;
            });

        // Sobe kao raspon
        if (sobeMinSel && (sobeMinSel?.value || sobeMaxSel?.value)) {
            const sobeId = sobeMinSel.dataset.atributId;
            atributi[sobeId] = {
                min: sobeMinSel.value || null,
                max: sobeMaxSel?.value || null,
            };
        }

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch("/pretplatnici", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                email: email,
                id_tipa: notifTipId,
                cena_min: cenaMin,
                cena_max: cenaMax,
                cena_po_metru:
                    document.getElementById("cenaPoMetru").value === "1",
                kvadratura_min: kvadMin,
                kvadratura_max: kvadMax,
                atributi: Object.keys(atributi).length ? atributi : null,
            }),
        })
            .then((r) => r.json())
            .then((data) => {
                if (data.uspeh) {
                    notifFormBody.style.display = "none";
                    notifSuccess.style.display = "block";
                } else if (data.greska) {
                    document.getElementById("emailError").textContent =
                        data.greska;
                }
            })
            .catch((err) => console.error(err));
    });
// ===== KRAJ NOTIFIKACIJE =====
