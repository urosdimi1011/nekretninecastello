// import {sum} from "./app.js";



let sortingData = null;
let trenutniTipNekretnine = null;
// sum();
// prikaziModal();

window.onload= function (){
    if(document.querySelectorAll('.my-gallery a').length){
        document.querySelectorAll('.my-gallery a').forEach(function(aElement) {
            var img = aElement.querySelector('img');
            // img.addEventListener('load', function() {
                var naturalWidth = img.naturalWidth;
                var naturalHeight = img.naturalHeight;
                aElement.setAttribute('data-pswp-width', naturalWidth);
                aElement.setAttribute('data-pswp-height', naturalHeight);
            });
        // });

    }
}
document.addEventListener( 'DOMContentLoaded', function() {


    if(window.location.pathname === "/"){
        var splide1 = new Splide('.splide', {
            type: 'loop',
            autoplay: true,
            height: '50rem',
            pauseOnHover: false,
            breakpoints: {
                1500: {
                    height: '60rem',
                },
                1200: {
                    height: '40rem',
                },
                1000: {
                    height: '30rem',
                },
                860: {
                    height: '25rem',
                },
                600: {
                    height: '30rem',
                },

            }
        });

        var splide2 = new Splide('.splide2', {
            type: 'loop',
            perPage: 3,
            breakpoints: {
                1200: {
                    perPage: 2,
                },
                600:{
                    perPage: 1,
                }
            },
            perMove: 1,
            gap:40,
            arrows:false,
            autoplay: true
        });
        splide1.mount();
        splide2.mount();

    }
    else if(window.location.pathname.includes("nekretnine")){

        var elementiZaSlider = document.getElementsByClassName( 'nekretnina-slider' );

        var elementiZaSlider2 = document.getElementsByClassName( 'thumbnail-carousel' );

        for ( var i = 0; i < elementiZaSlider.length; i++ ) {
            var main = new Splide( elementiZaSlider[ i ],{
                gap       : 10,
                pagination: false,
                rewind: true,
                autoplay: true,
                snap:true,
                focus      : 'center',
                breakpoints: {
                    600: {
                        fixedWidth : 60,
                        fixedHeight: 44,
                    },
                },
            } );



            var thumbnails = new Splide( elementiZaSlider2[ i ],{
                fixedWidth : 100,
                fixedHeight: 60,
                gap        : 10,
                rewind     : true,
                pagination : false,
                isNavigation: true,
                arrows:false,
                focus      : 'center',
                breakpoints: {
                    600: {
                        fixedWidth : 60,
                        fixedHeight: 44,
                    },
                },
            } );

            main.sync( thumbnails );
            main.mount();
            thumbnails.mount();
        }

        // for ( var i = 0; i < elementiZaSlider2.length; i++ ) {
        //     new Splide( elementiZaSlider2[ i ],{
        //         fixedWidth : 100,
        //         fixedHeight: 60,
        //         gap        : 10,
        //         rewind     : true,
        //         pagination : false,
        //         isNavigation: true,
        //         focus      : 'center',
        //         breakpoints: {
        //             600: {
        //                 fixedWidth : 60,
        //                 fixedHeight: 44,
        //             },
        //         },
        //     } ).mount();
        // }
        //
        // main.sync( thumbnails );
        // main.mount();
        // thumbnails.mount();

    }

} );
//Ovo otkomentarisati ukoliko budu vratili slajder za slike
// sliderZaNekretnine();
function sliderZaNekretnine(){
    var elms = document.getElementsByClassName( 'istaknuti' );
    console.log(elms);
    if(elms.length){
        for ( let i = 0; i < elms.length; i++ ) {
            new Splide( elms[ i ],{
                perPage: 1,
                type   : 'loop',
                drag   : 'free',
                perMove:1,
                pagination: true,
                lazyLoad : 'nearby',
            } ).mount();
        }
    }
}

const dropdownItems = document.querySelectorAll('.navbar-nav .menu-item-has-children');

dropdownItems.forEach(item => {
    item.addEventListener('mouseenter', () => {
        item.classList.add('hovered');
    });

    item.addEventListener('mouseleave', () => {
        item.classList.remove('hovered');
    });
});


document.addEventListener("scroll",function(){
    let header = document.querySelector(".header");

    if(window.pageYOffset >= header.offsetTop + 50){
        header.classList.add("fiksiraj-navigaciju")
    }
    else{
        header.classList.remove("fiksiraj-navigaciju")

    }
    // let a = document.querySelector(".back-to-top");
    // if(window.pageYOffset > 500){
    //     a.classList.add("vidljiv");
    // }
    // else{
    //     a.classList.remove("vidljiv");
    // }
})
document.querySelector(".response-button").addEventListener("click",function (e){

    document.querySelector(".main-nav").classList.toggle("vrati-navigaciju");
    document.querySelector(".black-wall").classList.toggle("active");
    document.querySelector("body").classList.toggle("skloni-scroll");
})
document.querySelector(".close-button").addEventListener("click",function (e){

    document.querySelector(".main-nav").classList.toggle("vrati-navigaciju");
    document.querySelector(".black-wall").classList.toggle("active");
    document.querySelector("body").classList.toggle("skloni-scroll");
})
document.querySelector(".black-wall").addEventListener("click",function (){
    document.querySelector(".main-nav").classList.toggle("vrati-navigaciju");
    document.querySelector(".black-wall").classList.toggle("active");
    document.querySelector("body").classList.toggle("skloni-scroll");
})


const formaDugme = document.querySelector(".dugme-forme-kontakt");
//Kontakt forma

if(window.location.pathname.includes("kontakt")){
    formaDugme.addEventListener("click",regulisiFormu);


}


function regulisiFormu(e){
    e.preventDefault();

    let nemaGreske = [];

    var greske = {
        "akoNemaNista" : "",
        "greska":""
    }
    greske.akoNemaNista = "Morate uneti ime i prezime";
    greske.greska = "Ime i prezime moraju da počinju velikim slovom";

    var imeIPrezime = document.querySelector("#imeIPrezime");
    var imeIPrezimeReg = /^([A-ZČĆĐŠŽa-zčćđšž]+)(\s[A-ZČĆĐŠŽa-zčćđšž]+){1,}$/;


    nemaGreske.push(validateInput(imeIPrezime,imeIPrezimeReg,greske))



    var phoneNumberInput = document.querySelector("#brojTelefona");
    var phoneNumberReg = /^\+(?:[0-9] ?){6,14}[0-9]$/;


    greske.akoNemaNista = "Morate uneti broj telefona";
    greske.greska = "Broj telefona mora početi +381 ...";


    nemaGreske.push(validateInput(phoneNumberInput,phoneNumberReg,greske))

    var emailInput = document.querySelector("#email");
    var emailReg = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;


    greske.akoNemaNista = "Morate uneti email";
    greske.greska = "Nije unet dobar format email adrese";

    nemaGreske.push(validateInput(emailInput,emailReg,greske))


    var porukaInput = document.querySelector("#poruka");
    porukaInput.parentElement.nextElementSibling.innerHTML = "";
    porukaInput.classList.remove("error-form-input");
    if(porukaInput.value.length < 20){
        porukaInput.classList.add("error-form-input");
        porukaInput.parentElement.nextElementSibling.innerHTML = "Morate uneti vise od 20 karaktera";
        nemaGreske.push(false);
    }

    if(!nemaGreske.some(x => x === false)){

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch("/send-mail", {
              method: "POST",
              body: JSON.stringify({
                  "imeIPrezime":imeIPrezime.value,
                  "brojTelefona":phoneNumberInput.value,
                  "email":emailInput.value,
                  "poruka":porukaInput.value
              }),
              headers: {
                "Content-Type": "application/json",
                  "X-CSRF-TOKEN": csrfToken
              }
            }).then(response => {
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
                          background: "linear-gradient(to right, #00b09b, #00b09b)",
                      },
                      onClick: function(){} // Callback after click
                  }).showToast();

                  document.querySelector("form").reset();

              } else {
               document.querySelector(".greska-sa-servera").innerHTML=response.text();
              }
            })
            .catch(error => {
              console.error(error);
            });

    }

}

function validateInput(input, regEx, errorMessage = "") {
    input.classList.remove("error-form-input");
    input.nextElementSibling.innerHTML = "";

    if(input.value === ""){
        input.classList.add("error-form-input");
        input.nextElementSibling.innerHTML = errorMessage.akoNemaNista;

        return false;

    }
    else if (!regEx.test(input.value)) {
        input.classList.add("error-form-input");
        if (errorMessage) {
            input.nextElementSibling.innerHTML = errorMessage.greska;
        }
        return false;
    }

    return true;
}



document.querySelectorAll(".custom-select").forEach(function(selectElement) {
    var classes = selectElement.className;
    var id = selectElement.id;
    var name = selectElement.name;
    var placeholder = selectElement.getAttribute("placeholder");

    var template =  '<div class="' + classes + '">';
    template += '<span class="custom-select-trigger">' + placeholder + '</span>';
    template += '<div class="custom-options">';

    selectElement.querySelectorAll("option").forEach(function(optionElement) {
        var optionClass = optionElement.className;
        var optionValue = optionElement.value;
        var optionText = optionElement.textContent;
        var selected = ""
        if(optionElement.selected){
            selected = "selection";
        }

        template += '<span class="custom-option ' + optionClass + ' ' + selected + '" data-value="' + optionValue + '">' + optionText + '</span>';
    });

    template += '</div></div>';

    var wrapper = document.createElement("div");
    wrapper.className = "custom-select-wrapper";
    selectElement.parentNode.insertBefore(wrapper, selectElement);
    selectElement.style.display = "none";
    wrapper.appendChild(selectElement);
    wrapper.insertAdjacentHTML("beforeend", template);




    document.querySelectorAll(".custom-option").forEach(function(option) {

        if(option.closest(".custom-select").classList.contains("tipNekretnine-select")
            && option.classList.contains("selection")){
            trenutniTipNekretnine = option.dataset.value;
            option.closest(".custom-select").querySelector(".custom-select-trigger").textContent = option.textContent;
        }

    })


});
if(window.location.pathname === "/nekretnine"){
    document.querySelector(".custom-option:first-of-type").addEventListener("mouseover", function() {
        this.closest(".custom-options").classList.add("option-hover");
    });
}
else if(window.location.pathname === "/kontakt"){
    const tekstArea = document.getElementById('poruka');
    tekstArea.addEventListener('input', azurirajBrojKaraktera);
}

document.querySelectorAll(".custom-select-trigger").forEach(function(trigger) {
    trigger.addEventListener("click", function(event) {
        this.closest(".custom-select").classList.toggle("opened");
        event.stopPropagation();

/*        document.querySelectorAll(".custom-select").forEach(function(select) {
            select.classList.remove("opened");
        });*/



    });
});


document.querySelectorAll(".custom-option").forEach(function(option) {
    option.addEventListener("click", function() {


        dodajSpiner();

        var select = this.closest(".custom-select-wrapper").querySelector("select");
        let url = "";
        select.value = this.getAttribute("data-value");

        if(this.parentNode.parentNode.classList.contains("tipNekretnine-select")){
            trenutniTipNekretnine = select.value;
            console.log(trenutniTipNekretnine);
            document.querySelector(".tip-naslov").textContent = "("+this.textContent+")";
        }
        else {
            sortingData = select.value;
        }

        url =  `/nekretnine?`;

        if(trenutniTipNekretnine !== ""){

                url += `&tip=${trenutniTipNekretnine}`;
        }
        if(sortingData != null){
                url += `&sort=${sortingData}`;
        }


        url += `&page=1`;



        this.closest(".custom-options").querySelectorAll(".custom-option").forEach(function(opt) {
            opt.classList.remove("selection");
        });
        this.classList.add("selection");
        this.closest(".custom-select").classList.remove("opened");
        this.closest(".custom-select").querySelector(".custom-select-trigger").textContent = this.textContent;


        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(url, {
            method: "GET",
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                "X-CSRF-TOKEN": csrfToken
            }
        })
            .then(response => {
                if (response.ok) {
                    response.json().then((x)=>ispisiNekretnine(x));
                } else {
                }
            })
            .catch(error => {
                console.error(error);
            });

    });
});

function ispisPaginacije(celaPaginacija, blokZaPaginaciju) {
    var paginacija = celaPaginacija;

    var paginacijaHtml = '<ul class="pagination">';

    if (paginacija.current_page > 1) {
        paginacijaHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${paginacija.current_page - 1}"> < </a></li>`;
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
            var aktivna = i === paginacija.current_page ? 'active disabled' : '';
            paginacijaHtml += '<li class="page-item ' + aktivna + '"><a class="page-link" rel="noopener noreferrer" href="#" data-page="' + i + '">' + i + '</a></li>';
        } else if (i > 1 && i < paginacija.current_page - 1 && !prikaziDots1) {
            paginacijaHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            prikaziDots1 = true;
        } else if (i < paginacija.last_page && i > paginacija.current_page + 1 && !prikaziDots2) {
            paginacijaHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            prikaziDots2 = true;
        }
    }

    if (paginacija.current_page < paginacija.last_page) {
        paginacijaHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${paginacija.current_page + 1}"> > </a></li>`;
    }

    paginacijaHtml += '</ul>';

    blokZaPaginaciju.innerHTML += paginacijaHtml;
}

// function ispisPaginacije(celaPaginacija,blokZaPaginaciju){
//     var paginacija = celaPaginacija;
//
//
//     var paginacijaHtml = '<ul class="pagination">';
//
//         paginacijaHtml += `<li class="page-item ${paginacija.current_page > 1 ? "" : "disabled"}"><a class="page-link" href="#" ${paginacija.current_page > 1 ? 'data-page="' + (paginacija.current_page - 1) + '"': ""}> < </a></li>`;
//
//     for (var i = 1; i <= paginacija.last_page; i++) {
//         var aktivna = i === paginacija.current_page ? 'active disabled' : '';
//         paginacijaHtml += '<li class="page-item ' + aktivna + '"><a class="page-link" rel="noopener noreferrer" href="#" data-page="' + i + '">' + i + '</a></li>';
//     }
//
//     paginacijaHtml += `<li class="page-item ${paginacija.current_page < paginacija.last_page ? "" : "disabled"}"><a class="page-link" href="#" ${paginacija.current_page < paginacija.last_page ? 'data-page="' + (paginacija.current_page + 1) + '"': ""}> > </a></li>`;
//     //
//     // if (paginacija.current_page < paginacija.last_page) {
//     //     paginacijaHtml += '<li class="page-item"><a class="page-link" href="#" data-page="' + (paginacija.current_page + 1) + '">›</a></li>';
//     // }
//
//     paginacijaHtml += '</ul>';
//
//
//     blokZaPaginaciju.innerHTML += paginacijaHtml;
// }

function ispisiNekretnine(ne){
    let html = "";

    document.querySelector(".rez").innerHTML = ne.pagination.total;

    let obj =  document.querySelector(".nekretnine-sve-js");
    if(ne.components.length){
        ne.components.forEach(x=>{
            html += "<div class=\"col-12 col-md-6 col-lg-4\">";
            html+=x;
            html+= "</div>"
        })
        obj.innerHTML = html;
        ispisPaginacije(ne.pagination,obj);
    }
    else{
        html+=`<div class="col-12 text-center ako-nema-nekretnina-poruka">
                        <p>Trenutno nema nekretnina za zadati kriterijum filtriranja</p>
               </div>`
        obj.innerHTML = html;
    }



    // sliderZaNekretnine();
    document.querySelectorAll(".page-item").forEach(function (e){
        e.addEventListener("click",function (event){

            if(this.classList.contains("disabled")){
                return;
            }

            dodajSpiner();

            event.preventDefault()

            var pageNumber = this.querySelector(".page-link").getAttribute('data-page');

            var url = `/nekretnine?page=${pageNumber}`;
            if(sortingData!= null){
                url+=`&sort=${sortingData}`;
            }
            if(trenutniTipNekretnine != null){
                url+=`&tip=${trenutniTipNekretnine}`;
            }
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(function(response) {
                    if (response.ok) {

                        return response.json();
                    } else {
                        console.error('Greška u AJAX zahtevu');
                        return null;
                    }
                })
                .then(function(data) {
                    if (data) {
                        ispisiNekretnine(data);
                    }
                })
                .catch(function(error) {
                    // Greška u zahtevu
                    console.error(error);
                });
        })
    })

}

document.addEventListener("click", function() {
    document.querySelectorAll(".custom-select").forEach(function(select) {
        select.classList.remove("opened");
    });
});


function dodajSpiner(){


    let obj =  document.querySelector(".nekretnine-sve-js");
    var spinner = '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';

    obj.innerHTML = spinner;

}


function azurirajBrojKaraktera() {
    const tekstArea = document.getElementById('poruka');
    const brojPreostalihKaraktera = document.getElementById('brojPreostalihKaraktera');
    const maksimalniBrojKaraktera = 250;

    const trenutniBrojKaraktera = tekstArea.value.length;
    const preostaliKarakteri = maksimalniBrojKaraktera - trenutniBrojKaraktera;

    brojPreostalihKaraktera.textContent = `${preostaliKarakteri}`;
}
