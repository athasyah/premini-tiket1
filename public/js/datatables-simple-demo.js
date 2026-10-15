window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Ambil semua tabel yang menggunakan Simple-DataTables
    document.querySelectorAll("table.sortable").forEach((table) => {
        new simpleDatatables.DataTable(table, {
            columns: JSON.parse(table.dataset.sortable || "[]") // Ambil konfigurasi dari atribut data-sortable
        });
    });
});
