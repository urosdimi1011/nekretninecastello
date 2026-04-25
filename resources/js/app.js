import './bootstrap';
import '../css/app.css';
import PhotoSwipeLightbox from 'photoswipe/lightbox';
import 'photoswipe/style.css';
// import Toastify from 'toastify-js';
// import 'toastify-js/src/toastify.css';

// export function sum(){
//     Toastify({
//         text: "This is a toast",
//         duration: 3000,
//         destination: "https://github.com/apvarun/toastify-js",
//         newWindow: true,
//         close: true,
//         gravity: "top", // `top` or `bottom`
//         position: "left", // `left`, `center` or `right`
//         stopOnFocus: true, // Prevents dismissing of toast on hover
//         style: {
//             background: "linear-gradient(to right, #00b09b, #96c93d)",
//         },
//         onClick: function(){} // Callback after click
//     }).showToast()
// }

const lightbox = new PhotoSwipeLightbox({
    gallery: '.my-gallery',
    children: 'li',
    pswpModule: () => import('photoswipe')
});
lightbox.init();


