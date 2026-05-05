let sortingData = null;
let trenutniTipNekretnine = null;
const pathname = window.location.pathname;
const baseUrl = window.AppConfig.baseUrl;
const locale = window.AppConfig.locale;
function jeStranica(naziv) {
    const path = pathname.replace(/^\/(en|ro|sr)/, "");
    if (naziv === "home") return path === "/" || path === "";
    return path.includes(naziv);
}
const TIP_FILTERA = Object.freeze({
    RASPON: "raspon",
    KATEGORIJA: "kategorija",
    BOOLEAN: "boolean",
    VISE_IZBORA: "vise_izbora",
});

const POZICIJA_FILTERA = Object.freeze({
    MIN: "min",
    MAX: "max",
    VREDNOST: "vrednost",
});

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
    if (jeStranica("home")) {
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
    } else if (jeStranica("nekretnine")) {
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

if (jeStranica("kontakt")) {
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
        fetch(window.AppConfig.routes.sendMail, {
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

function resetNotifModalState() {
    notifTipId = null;

    filteri = [];
    odabraneVrednosti = {};

    setSubmitLoading(false);
    clearNotifErrors();

    if (notifFormBody) notifFormBody.style.display = "";
    if (notifSuccess) notifSuccess.style.display = "none";

    // Resetuj polja
    document.getElementById("notifEmail").value = "";
    document.getElementById("notifCenaMin").value = "";
    document.getElementById("notifCenaMax").value = "";
    document.getElementById("notifKvadMin").value = "";
    document.getElementById("notifKvadMax").value = "";
    document.getElementById("cenaPoMetru").value = "0";

    setCenaToggle(false);

    document.querySelectorAll(".notif-tip-pill").forEach((pill) => {
        pill.classList.remove("active");
    });

    const dinamicki = document.getElementById("notifDinamickiFilteri");
    if (dinamicki) dinamicki.innerHTML = "";

    resetFooter();
}

function resetFooter() {
    const footer = document.querySelector(".notif-modal__footer");
    if (!footer) return;

    footer.innerHTML = `
        <button type="button" class="notif-btn-otkazi" id="notifBtnOtkazi">Otkaži</button>
        <button type="button" class="notif-btn-prijavi" id="notifBtnPrijavi">
            Prijavi se na obaveštenja
            <span class="notif-btn-spinner" aria-hidden="true"></span>
        </button>`;

    document
        .getElementById("notifBtnOtkazi")
        ?.addEventListener("click", closeNotifModal);
    document
        .getElementById("notifBtnPrijavi")
        ?.addEventListener("click", handleSubmit);
}

function showSuccessFooter() {
    const footer = document.querySelector(".notif-modal__footer");
    if (!footer) return;

    footer.innerHTML = `
        <button type="button" class="notif-btn-prijavi" id="notifBtnZatvori">
            Zatvori
        </button>`;

    document
        .getElementById("notifBtnZatvori")
        ?.addEventListener("click", closeNotifModal);
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

        // url = `/nekretnine?`;
        url = window.AppConfig.routes.nekretnine + "?";

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

function setSubmitLoading(loading) {
    const btn = document.getElementById("notifBtnPrijavi");
    if (!btn) return;

    btn.disabled = loading;
    btn.classList.toggle("is-loading", loading);
}
function clearNotifErrors() {
    ["emailError", "tipError", "cenaError", "kvadError"].forEach((id) => {
        const el = document.getElementById(id);
        if (el) el.textContent = "";
    });

    document.querySelectorAll('.notif-error[id^="error-"]').forEach((el) => {
        el.textContent = "";
    });
}

const notifOverlay = document.getElementById("notifOverlay");
const openNotifModalBtn = document.getElementById("openNotifModal");
const notifFormBody = document.getElementById("notifFormBody");
const notifSuccess = document.getElementById("notifSuccess");
const notifSubmitBtn = document.getElementById("notifBtnPrijavi");
let notifTipId = null;
let filteri = []; // definicije učitane iz API-ja
let odabraneVrednosti = {}; // { kljuc: vrednost | { min, max } | [id, id] }

// Otvori modal
openNotifModalBtn.addEventListener("click", () => {
    if (!notifOverlay) return;
    notifOverlay.classList.add("active");
    document.body.classList.add("skloni-scroll");

    if (!filteri.length) {
        ucitajFilteri();
    }
});

// Zatvori modal
function closeNotifModal() {
    notifOverlay.classList.remove("active");
    document.body.classList.remove("skloni-scroll");

    setTimeout(() => {
        resetNotifModalState();
    }, 300);
}
document
    .getElementById("closeNotifModal")
    ?.addEventListener("click", closeNotifModal);
document
    .getElementById("notifBtnOtkazi")
    ?.addEventListener("click", closeNotifModal);
notifOverlay?.addEventListener("click", (e) => {
    if (e.target === notifOverlay) closeNotifModal();
});

// Tip nekretnine
document.querySelectorAll(".notif-tip-pill").forEach((pill) => {
    pill.addEventListener("click", function () {
        document
            .querySelectorAll(".notif-tip-pill")
            .forEach((p) => p.classList.remove("active"));

        this.classList.add("active");
        notifTipId = this.dataset.id;
        document.getElementById("tipError").textContent = "";

        ucitajFilteriZaTip(notifTipId);
    });
});

// Učitaj filtere iz API-ja
function ucitajFilteriZaTip(tipId) {
    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`${window.AppConfig.routes.filteri}/${tipId}`, {
        headers: {
            "X-CSRF-TOKEN": csrf,
            Accept: "application/json",
        },
    })
        .then((r) => r.json())
        .then((data) => {
            filteri = data;
            renderujDinamickeFilteri(data);
        })
        .catch(() => console.error("Greška pri učitavanju filtera"));
}

function renderujDinamickeFilteri(filteri) {
    const container = document.getElementById("notifDinamickiFilteri");
    if (!container) return;

    container.innerHTML = "";

    filteri.forEach((f) => {
        const sekcija = document.createElement("div");
        sekcija.className = "notif-section dinamicka";
        sekcija.dataset.kljuc = f.kljuc;

        let inputHtml = "";

        switch (f.tip) {
            case TIP_FILTERA.RASPON: {
                const opcije = f.opcije
                    ? f.opcije
                          .map((o) => `<option value="${o}">${o}</option>`)
                          .join("")
                    : "";

                const isSelect = f.opcije && f.opcije.length > 0;

                inputHtml = `
                    <div class="notif-row-2">
                        <div class="notif-form-group">
                            <label>Od ${f.jedinica ?? ""}</label>
                            ${
                                isSelect
                                    ? `<select class="filter-input" data-kljuc="${f.kljuc}" data-pozicija="min">
                                        <option value="">Svejedno</option>
                                        ${opcije}
                                      </select>`
                                    : `<input type="number" class="filter-input"
                                        data-kljuc="${f.kljuc}" data-pozicija="min"
                                        min="0" placeholder="Min">`
                            }
                        </div>
                        <div class="notif-form-group">
                            <label>Do ${f.jedinica ?? ""}</label>
                            ${
                                isSelect
                                    ? `<select class="filter-input" data-kljuc="${f.kljuc}" data-pozicija="max">
                                        <option value="">Svejedno</option>
                                        ${opcije}
                                      </select>`
                                    : `<input type="number" class="filter-input"
                                        data-kljuc="${f.kljuc}" data-pozicija="max"
                                        min="0" placeholder="Max">`
                            }
                        </div>
                    </div>
                    <span class="notif-error" id="error-${f.kljuc}"></span>`;
                break;
            }

            case TIP_FILTERA.KATEGORIJA: {
                const katOpcije = (f.opcije || [])
                    .map(
                        (o) =>
                            `<option value="${o.toLowerCase()}">${o}</option>`,
                    )
                    .join("");

                inputHtml = `
                    <select class="filter-input" data-kljuc="${f.kljuc}" data-pozicija="vrednost">
                        <option value="">Svejedno</option>
                        ${katOpcije}
                    </select>`;
                break;
            }

            case TIP_FILTERA.BOOLEAN:
                inputHtml = `
                    <select class="filter-input" data-kljuc="${f.kljuc}" data-pozicija="vrednost">
                        <option value="">Svejedno</option>
                        <option value="da">Da</option>
                        <option value="ne">Ne</option>
                    </select>`;
                break;

            case TIP_FILTERA.VISE_IZBORA: {
                const pills = (f.opcije || [])
                    .map(
                        (o) => `
                        <div class="notif-mesto-pill" data-id="${o.id}" data-kljuc="${f.kljuc}">
                            ${o.naziv}
                        </div>
                    `,
                    )
                    .join("");

                inputHtml = `
                    <p class="notif-hint">Možete izabrati više lokacija</p>
                    <div class="notif-mesta-grid">${pills}</div>`;
                break;
            }
        }

        sekcija.innerHTML = `
            <div class="notif-section__title">
                ${f.naziv}${f.obavezan ? " *" : ""}
            </div>
            ${inputHtml}
        `;

        container.appendChild(sekcija);

        if (f.tip === TIP_FILTERA.VISE_IZBORA) {
            sekcija.querySelectorAll(".notif-mesto-pill").forEach((pill) => {
                pill.addEventListener("click", function () {
                    this.classList.toggle("active");
                });
            });
        }
    });
}

// Cena toggle
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

function parseBroj(vrednost) {
    if (vrednost == null) return null;
    const cisto = String(vrednost).replace(/[^\d]/g, "");
    return cisto ? Number(cisto) : null;
}

// Skupi vrednosti filtera
function skupiFilteri() {
    const result = {};

    // Raspon i select filteri
    document.querySelectorAll(".filter-input").forEach((el) => {
        const kljuc = el.dataset.kljuc;
        const pozicija = el.dataset.pozicija;
        const vrednost = el.value.trim();

        if (!vrednost) return;

        if (
            pozicija === POZICIJA_FILTERA.MIN ||
            pozicija === POZICIJA_FILTERA.MAX
        ) {
            if (!result[kljuc]) result[kljuc] = {};
            result[kljuc][pozicija] = isNaN(Number(vrednost))
                ? vrednost
                : Number(vrednost);
        } else {
            result[kljuc] = vrednost;
        }
    });

    // Više izbora (lokacija)
    document.querySelectorAll(".notif-sekcija.dinamicka").forEach((sekcija) => {
        const aktivni = [
            ...sekcija.querySelectorAll(".notif-mesto-pill.active"),
        ].map((p) => p.dataset.id);
        if (aktivni.length) {
            result[sekcija.dataset.kljuc] = aktivni;
        }
    });

    // Lokacija — poseban selektor
    document.querySelectorAll(".notif-mesto-pill.active").forEach((pill) => {
        const kljuc = pill.dataset.kljuc;
        if (!result[kljuc]) result[kljuc] = [];
        if (!result[kljuc].includes(pill.dataset.id)) {
            result[kljuc].push(pill.dataset.id);
        }
    });

    return result;
}

// Validacija
function validiraj() {
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

    // Helper za validaciju raspona
    function validirajRaspon(minId, maxId, errorId, naziv) {
        const min = parseBroj(document.getElementById(minId)?.value);
        const max = parseBroj(document.getElementById(maxId)?.value);
        const err = document.getElementById(errorId);

        if (min !== null && min < 0) {
            err.textContent = "Min vrednost nije ispravna";
            return { valid: false, min: null, max: null };
        }

        if (max !== null && max < 0) {
            err.textContent = "Max vrednost nije ispravna";
            return { valid: false, min: null, max: null };
        }

        if (min !== null && max !== null && min > max) {
            err.textContent = "Min ne može biti veći od max";
            return { valid: false, min: null, max: null };
        }

        err.textContent = "";
        return { valid: true, min, max };
    }

    const cena = validirajRaspon(
        "notifCenaMin",
        "notifCenaMax",
        "cenaError",
        "cenu",
    );
    if (!cena.valid) valid = false;

    const kvad = validirajRaspon(
        "notifKvadMin",
        "notifKvadMax",
        "kvadError",
        "kvadraturu",
    );
    if (!kvad.valid) valid = false;

    // Raspon filteri (sobe itd.) — validacija min <= max
    document.querySelectorAll(".notif-section.dinamicka").forEach((sekcija) => {
        const kljuc = sekcija.dataset.kljuc;
        const minInput = sekcija.querySelector(
            `[data-kljuc="${kljuc}"][data-pozicija="min"]`,
        );
        const maxInput = sekcija.querySelector(
            `[data-kljuc="${kljuc}"][data-pozicija="max"]`,
        );
        const errEl = sekcija.querySelector(`#error-${kljuc}`);

        if (!minInput || !maxInput || !errEl) return;

        const min = minInput.value;
        const max = maxInput.value;

        if (min && max && Number(min) > Number(max)) {
            errEl.textContent = "Min ne može biti veći od max";
            maxInput.style.borderColor = "#dc3545";
            valid = false;
        } else {
            if (errEl) errEl.textContent = "";
            maxInput.style.borderColor = "";
        }
    });

    return { valid, cena, kvad };
}

async function handleSubmit() {
    const { valid, cena, kvad } = validiraj();
    if (!valid) return;

    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const skupljeniFilteri = skupiFilteri();

    setSubmitLoading(true);

    try {
        const r = await fetch(window.AppConfig.routes.pretplatnici, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
                Accept: "application/json",
            },
            body: JSON.stringify({
                email: document.getElementById("notifEmail").value.trim(),
                id_tipa: notifTipId,
                cena_min: cena.min,
                cena_max: cena.max,
                cena_po_metru:
                    document.getElementById("cenaPoMetru").value === "1",
                kvadratura_min: kvad.min,
                kvadratura_max: kvad.max,
                filteri: Object.keys(skupljeniFilteri).length
                    ? skupljeniFilteri
                    : null,
            }),
        });

        const data = await r.json();

        if (!r.ok) {
            if (r.status === 422 && data.errors) {
                document.getElementById("emailError").textContent =
                    data.errors.email?.[0] ?? "";
                document.getElementById("tipError").textContent =
                    data.errors.id_tipa?.[0] ?? "";
                document.getElementById("cenaError").textContent =
                    data.errors.cena_max?.[0] ?? "";
                document.getElementById("kvadError").textContent =
                    data.errors.kvadratura_max?.[0] ?? "";
            } else if (data.greska) {
                document.getElementById("emailError").textContent = data.greska;
            }
            return;
        }

        if (data.uspeh) {
            notifFormBody.style.display = "none";
            notifSuccess.style.display = "block";
            showSuccessFooter(); // ← promeni footer
        }
    } catch (err) {
        console.error(err);
        document.getElementById("emailError").textContent =
            "Došlo je do greške. Pokušajte ponovo.";
    } finally {
        setSubmitLoading(false);
    }
}

document
    .getElementById("notifBtnPrijavi")
    ?.addEventListener("click", handleSubmit);
// ===== KRAJ NOTIFIKACIJE =====

const cenaMinInput = document.getElementById("notifCenaMin");
const cenaMaxInput = document.getElementById("notifCenaMax");

function formatirajCenu(input) {
    // Ukloni sve osim brojeva
    let cistaVrednost = input.value.replace(/[^\d]/g, "");

    if (cistaVrednost === "") {
        input.value = "";
        return;
    }

    // Dodaj tačke na svake 3 cifre s leva
    let formatirano = cistaVrednost.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    input.value = formatirano;
}

cenaMinInput.addEventListener("input", function () {
    formatirajCenu(this);
});

cenaMaxInput.addEventListener("input", function () {
    formatirajCenu(this);
});
// ===== KRAJ NOTIFIKACIJE =====
