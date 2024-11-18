document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('register-form');
    
    form.addEventListener('submit', function(event) {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        if (!username || !password) {
            event.preventDefault(); 
            alert("Silahkan isi semua kolom sebelum mengirim form.");
        }
    });
});

window.addEventListener('DOMContentLoaded', event => {
    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});

