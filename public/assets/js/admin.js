
// const isModalOpen = localStorage.getItem('modalOpen');
// if (isModalOpen === 'true') {
//     document.getElementById('modalContent').innerHTML = localStorage.getItem('modalContent');
//     document.getElementById('izmeniModal').style.display = 'block';
// }

let editorMoj = null;
//
let promenjenRedosled = [];
function sortTable(columnIndex) {
    const table = document.getElementsByTagName('table')[0];
    const rows = Array.from(table.rows).slice(1);
    console.log(table.sortedColumnIndex);
    const ascending = columnIndex === table.sortedColumnIndex ? !table.sortedAscending : true;
    if(isTextCell(rows[0].cells[columnIndex])){
        const arrow = document.getElementById('arrow' + columnIndex);
        arrow.innerHTML = table.sortedAscending ? '&#9650;' : '&#9660;';
    }
    rows.sort((a, b) => {
        const aCell = a.cells[columnIndex];
        const bCell = b.cells[columnIndex];
        if (isTextCell(aCell) && isTextCell(bCell)) {
            const aData = aCell.textContent;
            const bData = bCell.textContent;
            return table.sortedAscending ? aData.localeCompare(bData) : bData.localeCompare(aData);
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
    return cell.children.length === 0 || cell.children[0].tagName !== 'IMG' && cell.children[0].tagName !== 'BUTTON';
}



function openModal(target,data = null) {

    let metoda = "GET";

    let url = target.dataset.url;

    let csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    let objekatZaSlanje = {
        method: metoda,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        }
    };

    if(target.dataset.target.includes("obrisi")){
        objekatZaSlanje.method = "POST";
        objekatZaSlanje.headers['X-HTTP-Method-Override'] = 'DELETE';
        // objekatZaSlanje.method = "DELETE";
        url += `?prikaziFormu=true`;
    }
    else if(target.dataset.target.includes("izmeni")){
        objekatZaSlanje.method="GET";
        url+='/edit'
    }

    fetch(url, objekatZaSlanje)
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('izmeniModal').style.display = 'block';

            localStorage.setItem('modalOpen', 'true');
            localStorage.setItem('modalContent', html);


            if(document.getElementById('graficki-prikaz-slika')){
                ispisUploadovaneSlikeIMenjanjeRedosleda();
            }

            if(document.querySelector( '#editor' )){
                ClassicEditor
                    .create( document.getElementById( 'editor' ) )
                    .then(editor => {
                        // čuvanje reference na editor instancu
                        editorMoj = editor;
                        console.log(editor);
                    })
                    .catch( error => {
                        console.error( error );
                    } );

            }

                if(html.includes("glavnaSlika") || html.includes("slika")){
                    let listingPhotoField = document.querySelector("input[type='file']");
                    listingPhotoField.addEventListener("change", handleChangeEvent);

                }
                if(html.includes("swiper")) {
                    setTimeout(function () {
                        new Swiper('#modalContent .swiper', {
                            direction: 'horizontal',
                            loop: true,

                            pagination: {
                                el: '.swiper-pagination',
                            },

                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },

                            scrollbar: {
                                el: '.swiper-scrollbar',
                            },
                        });
                    }, 0);
                }
            // let formDataObjekat = new FormData();

            // if(document.getElementById('formaGeneric').querySelector("#podSlike")){
            //     console.log("usli");
            //     const imageInput = document.getElementById("podSlike");
            //
            //     imageInput.addEventListener("change", function () {
            //         console.log("UsLIU ");
            //         const imageContainer = document.getElementById("podSlike"); // Kontejner za prikaz slika
            //
            //         // Pregledajte odabrane slike
            //         for (const file of imageInput.files) {
            //             const imageElement = document.createElement("img"); // Kreirajte element slike
            //
            //             // Postavite sliku na temelju odabrane datoteke
            //             imageElement.src = URL.createObjectURL(file);
            //
            //             // Dodajte sliku u kontejner za prikaz
            //             imageContainer.appendChild(imageElement);
            //         }
            //         formDataObjekat.append("podSlike[]",imageContainer);
            //         console.log(formDataObjekat);
            //     });
            // //
            // //
            // }

            document.querySelector(".forma-admin-klik").addEventListener("click",function (e){
                e.preventDefault();
                // localStorage.setItem("akoImaGreske",)
                const formElement = document.getElementById("formaGeneric");
                const actionUrl = formElement.getAttribute('action');

                const existingErrorElements = document.querySelectorAll('.text-danger.greska-ispod-polja');
                existingErrorElements.forEach(function (errorElement) {
                    errorElement.parentNode.removeChild(errorElement);
                });

                const formDataObjekat = new FormData(document.getElementById('formaGeneric'));

                let editorSadrzaj = "";
                // Dohvatite sadržaj iz editora
                if(editorMoj != null){
                    editorSadrzaj = editorMoj.getData();
                    formDataObjekat.append('opis', editorSadrzaj);
                }

                if(promenjenRedosled.length){
                    if(formDataObjekat.has("podSlike[]")){
                        formDataObjekat.delete("podSlike[]");
                    }
                    promenjenRedosled.forEach(indeks => {
                        const slika = document.querySelector("#podSlike").files[indeks];
                        formDataObjekat.append('podSlike[]', slika);
                    });
                }

                dodajSpiner();
                fetch(actionUrl, {
                    method: 'POST',
                    body: formDataObjekat,
                })
                    .then(response => response.json())
                    .then(data => {
                        ukiniSpiner();
                        if(data.neuspeh){
                            document.querySelector(".ako-ima-greske p").innerHTML = error.neuspeh;
                        }
                            if(data.errors){
                                for (const fieldName in data.errors) {
                                    if (data.errors.hasOwnProperty(fieldName)) {
                                        const errorMessage = data.errors[fieldName][0];

                                        let inputField = document.getElementById(fieldName);
                                        if(inputField == null){
                                            inputField = document.getElementById(fieldName+"Dropdown");
                                            inputField = document.getElementById(fieldName+"Dropdown");
                                        }
                                        const errorElement = document.createElement('span');
                                        errorElement.className = 'text-danger greska-ispod-polja';
                                        errorElement.innerText = errorMessage;

                                        inputField.parentNode.appendChild(errorElement);
                                    }
                                }
                            }
                            else{
                                closeModal();

                                Toastify({
                                    text:data.uspeh,
                                    duration: 3000,
                                    destination: "https://github.com/apvarun/toastify-js",
                                    newWindow: true,
                                    close: true,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #00b09b)",
                                    },
                                    onClick: function(){} // Callback after click
                                }).showToast();

                                setTimeout(function (){
                                    window.location.reload();
                                },3000)
                            }
                    })
                    .catch(error => {
                        ukiniSpiner();
                        document.querySelector(".ako-ima-greske p").innerHTML = error;
                    });
            })

        }).catch(xhr=>{
        ukiniSpiner();
            document.querySelector(".ako-ima-greske p").innerHTML = xhr;
    });

}

function handleChangeEvent() {
    let listingPhotoField = null;
    if(editorMoj != null){
        listingPhotoField = document.querySelectorAll("input[type='file']")[1];
    }
    else{
        listingPhotoField = document.querySelector("input[type='file']");
    }
    let fileReader = new FileReader();
    let previewHolder = document.querySelector("#slika_preview");

    if(previewHolder != null){
        fileReader.onload = function (e) {

            previewHolder.src = this.result;
        }
    }
    console.log(listingPhotoField);
    fileReader.readAsDataURL(listingPhotoField.files[0]);
    // listingPhotoField.removeEventListener("change", handleChangeEvent);
    //
    // listingPhotoField.addEventListener("change", handleChangeEvent);
}

function closeModal() {
    document.getElementById('izmeniModal').style.display = 'none';
    localStorage.removeItem('modalOpen');
    localStorage.removeItem('modalContent');
}


document.addEventListener('click', function(event) {
    if (event.target.classList.contains('close-alert')) {
        event.target.parentNode.remove();
    }
});
document.addEventListener("DOMContentLoaded", function() {
    var alertDiv = document.querySelector(".mojStil");
    if (alertDiv) {
        setTimeout(function() {
            alertDiv.style.display = "none";
        }, 4000);
    }
});


function addEventListenerOnce(event, element, onEvent, listenerMark = ""){
    let listenerMarker = event + listenerMark;
    console.log(listenerMarker);
    if(element.classList.contains(listenerMarker)){
        return;
    }
    element.classList.add(listenerMarker);
    element.addEventListener(event, onEvent);
}


// setTimeout(function (){
//     document.querySelector(".alert").remove();
// },2000)



$(document).ready(function() {
    // Kada korisnik klikne na checkbox
    $('.dropdown-checkboxes .form-check-input').on('click', function() {
        // Proverite da li je kliknut checkbox u dropdown-u
        if ($(this).parents('.dropdown-menu').length > 0) {
            // Osvežite tekst na dugmetu na osnovu izabranih opcija
            var checkedOptions = $(this).parents('.dropdown-menu').find('.form-check-input:checked');
            var buttonText = 'Izaberite opcije';
            if (checkedOptions.length > 0) {
                buttonText = 'Izabrano: ';
                checkedOptions.each(function(index) {
                    buttonText += $(this).siblings('label').text();
                    if (index < checkedOptions.length - 1) {
                        buttonText += ', ';
                    }
                });
            }
            $(this).parents('.dropdown-checkboxes').find('.dropdown-toggle').text(buttonText);
        }
    });
});


document.querySelector(".modal").addEventListener("click",function (e){
    // if (e.target === document.querySelector(".modal-content")) {
    //     e.preventDefault();
        // this.style.display = "none";
    // }
})
/*Skript za navigaciju na admin delu*/
//
// const shrink_btn = document.querySelector(".shrink-btn");
// const search = document.querySelector(".search");
// const sidebar_links = document.querySelectorAll(".sidebar-links a");
// const active_tab = document.querySelector(".active-tab");
// const shortcuts = document.querySelector(".sidebar-links h4");
// const tooltip_elements = document.querySelectorAll(".tooltip-element");
// let activeIndex;
// shrink_btn.addEventListener("click", () => {
//     document.body.classList.toggle("shrink");
//     setTimeout(moveActiveTab, 400);
//     shrink_btn.classList.add("hovered");
//     setTimeout(() => {
//         shrink_btn.classList.remove("hovered");
//     }, 500);
// });
// search.addEventListener("click", () => {
//     document.body.classList.remove("shrink");
//     search.lastElementChild.focus();
// });
// function moveActiveTab() {
//     let topPosition = activeIndex * 58 + 2.5;
//     if (activeIndex > 3) {
//         topPosition += shortcuts.clientHeight;
//     }
//     active_tab.style.top = `${topPosition}px`;
// }
// function changeLink() {
//     sidebar_links.forEach((sideLink) => sideLink.classList.remove("active"));
//     this.classList.add("active");
//     activeIndex = this.dataset.active;
//     moveActiveTab();
// }
// sidebar_links.forEach((link) => link.addEventListener("click", changeLink));
// function showTooltip() {
//     let tooltip = this.parentNode.lastElementChild;
//     let spans = tooltip.children;
//     let tooltipIndex = this.dataset.tooltip;
//     Array.from(spans).forEach((sp) => sp.classList.remove("show"));
//     spans[tooltipIndex].classList.add("show");
//     tooltip.style.top = `${(100 / (spans.length * 2)) * (tooltipIndex * 2 + 1)}%`;
// }
// tooltip_elements.forEach((elem) => {
//     elem.addEventListener("mouseover", showTooltip);
// });



//Za dodagjaje koji se dinamiski greiraju\



//ovo je custom funkcija
function promeni(e){
    //ovde sad moram da znam koji propertiji postoje !!!
    e.preventDefault();

    const radioButtons = document.querySelectorAll('input[type="radio"][name="tipnekretnine"]');
    let textVrednosti =  null;

    if(document.querySelectorAll('input[type="text"][name="id_tip_nekretnine_atribut[]"]').length > 0){
        textVrednosti = document.querySelectorAll('input[type="text"][name="id_tip_nekretnine_atribut[]"]');
    }
    else{
        textVrednosti = document.querySelectorAll('input[type="text"][name="id_tip_nekretnine_atribut"]')
    }

    const idNekretnine = document.querySelector('input[type="hidden"][name="id"]').value;
    let pokupi = [];


    textVrednosti.forEach((x)=>{
        if(x.value.trim() !== "" && x.value.trim() !== "ne"){
            pokupi.push({"id_tip_nekretnine_atributi":x.dataset.id,"vrednost":x.value.trim()});
        }
    })

    let objekatZaSlanjePoPravilima = {
        "nekretnina_id":idNekretnine,
        "atributi":pokupi
    }
    //
    let url = "/admin/nekretnineatributivrednost";

    let csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    let method = "POST";
    let objekatZaSlanje = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(objekatZaSlanjePoPravilima)
    };

    fetch(url, objekatZaSlanje)
        .then(response => response.text())
        .then(html => {




            document.querySelector(".modal").style.display="none";


            var newDiv = document.createElement('div');

            newDiv.classList.add("alert","alert-success","mojStil");

            newDiv.textContent = 'Uspesno ste izmenili karakteristike za nekretnine';

            newDiv.innerHTML += "<span class=\"close-alert\">x</span>";

            document.querySelector("main").prepend(newDiv);



            setTimeout(function() {
                document.querySelector(".alert").style.display='none';
            }, 4000);



        })
        .catch(error => console.error('Error:', error));
}


document.querySelectorAll(".response-button,.close-button").forEach((x)=>{

    x.addEventListener("click",function (e){
        document.querySelector(".group-item-admin").classList.toggle("show");
    })

})
function dodajSpiner(){


    let obj =  document.querySelector("#modalContent");


    obj.querySelector(".form-container form").style.opacity="0";

    document.querySelector(".lds-spinner").style.display="block"

}
function ukiniSpiner(){
    let obj =  document.querySelector("#modalContent");


    obj.querySelector(".form-container form").style.opacity="1";

    document.querySelector(".lds-spinner").style.display="none"

}

function ispisUploadovaneSlikeIMenjanjeRedosleda(){




    const grafickiPrikazSlika = document.getElementById('graficki-prikaz-slika');
    const inputSlika = document.getElementById("podSlike");





    new Sortable(grafickiPrikazSlika, {
        animation: 150,
        onEnd: function (event) {

            promenjenRedosled = Array.from(grafickiPrikazSlika.querySelectorAll("img")).map(element => parseInt(element.dataset.indeks));

            // // Ovdje možete ažurirati redosled slika prema promjenama korisnika
            // const novaSlika = event.item;
            // const slike = grafickiPrikazSlika.querySelectorAll('img');
            // const nazivSlike = stavka.querySelector('.naziv-slike').innerText;
            // const redosled = Array.from(slike).map((slika, indeks) => {
            //     // Ovdje možete ažurirati redosled u bazi podataka
            //     promenjenRedosled.push({
            //         slika: slika.src, // Dodajte putanju do slike u promenjenRedosled
            //         naziv: nazivSlike
            //     });
            // });
            // console.log(promenjenRedosled);
            console.log(promenjenRedosled);
        }
    });




    inputSlika.addEventListener('change', function() {
        grafickiPrikazSlika.innerHTML = ''; // Obrišite prethodni prikaz

        promenjenRedosled = Array.from({ length: inputSlika.files.length }, (_, indeks) => indeks);


        for (let i = 0; i < inputSlika.files.length; i++) {
            const slika = inputSlika.files[i];
            const slikaStavka = document.createElement('div');
            slikaStavka.className = 'slika-stavka';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(slika);
            img.setAttribute("data-indeks",i);
            img.alt =slika.name;

            const nazivSlike = document.createElement('div');
            nazivSlike.className = 'naziv-slike';
            nazivSlike.innerText = slika.name;

            slikaStavka.appendChild(img);
            slikaStavka.appendChild(nazivSlike);

            grafickiPrikazSlika.appendChild(slikaStavka);
        }
    });
}
