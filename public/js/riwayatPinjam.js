$(document).ready(function () {
    function countActiveFilters() {
        let count = 0;

        if (filterState.kelas) count++;

        if (filterState.tipe) count++;
        if (filterState.start || filterState.end) count++;

        return count;
    }

    function animateValue(id, start, end, duration) {
        let obj = document.getElementById(id);
        let startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;

            let progress = Math.min((timestamp - startTime) / duration, 1);
            progress = 1 - Math.pow(1 - progress, 3);

            let value = Math.floor(progress * (end - start) + start);
            obj.innerText = value;

            if (progress < 1) requestAnimationFrame(step);
        }

        requestAnimationFrame(step);
    }

    function updateStatsFromTable() {
        let rows = table
            .rows({
                search: "applied",
            })
            .nodes();

        let $rows = $(rows);

        let total = $rows.length;
        let tepat = 0;
        let terlambat = 0;

        $rows.each(function () {
            let status = $(this).find("[data-status]").data("status");

            if (status === "tepat waktu") tepat++;
            if (status === "terlambat") terlambat++;
        });

        let currentTotal = parseInt($("#totalPinjam").text()) || 0;
        let currentTepat = parseInt($("#totalTepatWaktu").text()) || 0;
        let currentTerlambat = parseInt($("#totalTerlambat").text()) || 0;

        animateValue("totalPinjam", currentTotal, total, 500);
        animateValue("totalTepatWaktu", currentTepat, tepat, 500);
        animateValue("totalTerlambat", currentTerlambat, terlambat, 500);
    }

    let table;
    table = $(".data-table").DataTable({
        responsive: false,
        autoWidth: false,
        pageLength: 10,
        lengthChange: true,
        ordering: false,
        dom: "lrtip",
        language: {
            zeroRecords: "Data tidak ditemukan",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            lengthMenu: "_MENU_",
            paginate: {
                next: ">>",
                previous: "<<",
            },
        },
    });

    table.on("draw", function () {
        updateStatsFromTable();
    });

    updateStatsFromTable();

    let filterState = {
        kelas: "",

        tipe: "",
        start: null,
        end: null,
    };
    // ===================== FILTER APPLY =====================
    $(".btn-universal").on("click", function () {
        table
            .column(2)
            .search(
                filterState.kelas ? "^" + filterState.kelas + "$" : "",
                true,
                false,
            )
            .draw();

        table
            .column(3)
            .search(
                filterState.tipe ? "^" + filterState.tipe + "$" : "",
                true,
                false,
            )
            .draw();

        table.draw();

        let total = countActiveFilters();
        $("#filterBadge")
            .text(total)
            .toggle(total > 0);

        $("#filterModal").modal("hide");
    });

    // ===================== RESET =====================
    $(".btn-back").on("click", function () {
        filterState = {
            kelas: "",

            tipe: "",
            start: null,
            end: null,
        };

        $("select.filter-input").prop("selectedIndex", 0);
        $("input.filter-input").val("");

        startPicker.clear();
        endPicker.clear();

        table.search("").columns().search("").draw();

        $("#filterBadge").hide().text("0");
    });

    // ===================== SEARCH =====================
    $("#searchInput").on("keyup", function () {
        table.search($(this).val()).draw();
    });

    // ===================== DROPDOWN FILTER =====================
    $("#filterKelas").on("change", function () {
        filterState.kelas = $(this).val();
    });

    $("#filterTipe").on("change", function () {
        filterState.tipe = $(this).val();
    });

    // ===================== DETAIL TOGGLE =====================
    $(document).on("click", ".btn-detail", function () {
        let detail = $(this).siblings(".detail-alat");
        let icon = $(this).find("i");
        let isPlus = icon.hasClass("fa-plus");

        detail.stop(true, true).slideToggle(220);
        $(this).toggleClass("active");

        if (isPlus) {
            icon.removeClass("fa-plus").addClass("fa-minus");
        } else {
            icon.removeClass("fa-minus").addClass("fa-plus");
        }
    });

    // ===================== DATE PICKER =====================
    let startPicker = flatpickr("#startDate", {
        altInput: true,
        altFormat: "d M Y",
        dateFormat: "Y-m-d",
        maxDate: "today",
        disable: [(date) => date.getDay() === 0 || date.getDay() === 6],
        onChange: function (selectedDates) {
            filterState.start = selectedDates[0] || null;

            if (filterState.start) {
                endPicker.set("minDate", filterState.start);
            }
        },
    });

    let endPicker = flatpickr("#endDate", {
        altInput: true,
        altFormat: "d M Y",
        dateFormat: "Y-m-d",
        maxDate: "today",
        disable: [(date) => date.getDay() === 0 || date.getDay() === 6],
        onChange: function (selectedDates) {
            filterState.end = selectedDates[0] || null;
        },
    });

    // ===================== DATE FILTER DATATABLE =====================
    $.fn.dataTable.ext.search.push(function (settings, data) {
        let dateStr = data[5];
        if (!dateStr) return true;

        function parseDate(str) {
            let [day, month, year] = str.split(" ");
            let months = {
                Jan: 0,
                Feb: 1,
                Mar: 2,
                Apr: 3,
                May: 4,
                Jun: 5,
                Jul: 6,
                Aug: 7,
                Sep: 8,
                Oct: 9,
                Nov: 10,
                Dec: 11,
            };
            return new Date(year, months[month], day);
        }

        let rowDate = parseDate(dateStr);

        let start = filterState.start;
        let end = filterState.end;

        if (start && !end) return rowDate >= start;
        if (!start && end) return rowDate <= end;
        if (start && end) return rowDate >= start && rowDate <= end;

        return true;
    });

    // ===================== MOVE UI =====================
    $("#show-entries").html($(".dataTables_length").detach());
    $("#show-entries").prepend('<span style="margin-right:5px;">Show :</span>');

    window.exportPdf = function () {
        let url = "/export-laporan-peminjaman";
        let params = [];

        if (filterState.kelas) {
            params.push("kelas=" + filterState.kelas);
        }

        if (filterState.tipe) {
            params.push("tipe=" + filterState.tipe);
        }

        if (filterState.start) {
            params.push(
                "start=" + filterState.start.toLocaleDateString("sv-SE"),
            );
        }

        if (filterState.end) {
            params.push("end=" + filterState.end.toLocaleDateString("sv-SE"));
        }

        if (params.length > 0) {
            url += "?" + params.join("&");
        }

        window.open(url, "_blank");
    };
    
    $(function () {
        $("[title]").tooltip({
            placement: "top",
            offset: "0,3",
        });
    });
});
