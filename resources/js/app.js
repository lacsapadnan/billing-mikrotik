import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.data("confirmable", (data) => ({
    confirm(e) {
        e.preventDefault();
        Swal.fire({
            title: data.confirmTitle || "Are you sure?",
            text: data.confirmText || "You won't be able to revert this!",
            icon: "warning",
            showCancelButton:
                typeof data.showCancelButton == "undefined"
                    ? true
                    : data.showCancelButton == "true",
            confirmButtonColor: data.confirmButtonColor,
            cancelButtonColor: data.cancelButtonColor,
            confirmButtonText: data.confirmButtonText || "Yes!",
        }).then((result) => {
            if (result.isConfirmed) {
                data.onConfirm()
            }
        });
    },
}));
Alpine.start();

// Element to indecate
var button = document.querySelector("#kt_button_toggle");

// Handle button click event
if (button) {
    button.addEventListener("click", function() {
        button.classList.toggle("active");
    });
}

// handle datatable search
$(document).ready(() => {
    if(typeof LaravelDataTables != 'undefined'){
    var dtb = LaravelDataTables["dataTableBuilder"];
    var search = "";
    $("#dtb-search").on("input", (e) => {
        search = e.target.value;
        dtb.draw();
    });
    dtb.on("preXhr.dt", (e, settings, data) => {
        data.search["value"] = search;
    });
    }
});
