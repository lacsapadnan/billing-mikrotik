import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$('.confirmable').click(function (e) {
    e.preventDefault();
    const data = $(this).data();
    Swal.fire({
        title: data.confirmTitle || 'Are you sure?',
        text: data.confirmText || 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: typeof data.showCancelButton == "undefined"? true: data.showCancelButton == "true",
        confirmButtonColor: data.confirmButtonColor,
        cancelButtonColor: data.cancelButtonColor,
        confirmButtonText: data.confirmButtonText||'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            eval(data.onConfirm)
        }
    })
});


// Element to indecate
var button = document.querySelector("#kt_button_toggle");

// Handle button click event
button.addEventListener("click", function() {
    button.classList.toggle("active");
});

