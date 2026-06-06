$(document).ready(function () {
    let filterState = {
        jenis: "",
        tipe: "",
        kondisi: "",
    };

    function countActiveFilters() {
        let count = 0;

        if (filterState.jenis) count++;
        if (filterState.tipe) count++;
        if (filterState.kondisi) count++;
        return count;
    }

    $("#btnApplyFilter").on("click", function () {
        table
            .column(1)
            .search(
                filterState.jenis ? "^" + filterState.jenis + "$" : "",
                true,
                false,
            )
            .draw();
        table
            .column(2)
            .search(
                filterState.tipe ? "^" + filterState.tipe + "$" : "",
                true,
                false,
            )
            .draw();
        table
            .column(4)
            .search(
                filterState.kondisi ? "^" + filterState.kondisi + "$" : "",
                true,
                false,
            )
            .draw();

        let total = countActiveFilters();

        $("#filterBadge")
            .text(total)
            .toggle(total > 0);

        $("#filterModal").modal("hide");
    });

    $("#btnResetFilter").on("click", function () {
        filterState = {
            jenis: "",
            tipe: "",
            kondisi: "",
        };

        $("select.filter-input").prop("selectedIndex", 0);
        table.search("").columns().search("").draw();

        $("#filterBadge").hide().text("0");
    });

    $("#filterJenis").on("change", function () {
        filterState.jenis = $(this).val();
    });

    $("#filterTipe").on("change", function () {
        filterState.tipe = $(this).val();
    });

    $("#filterKondisi").on("change", function () {
        filterState.kondisi = $(this).val();
    });

    window.exportPdf = function () {
        let url = "/export-laporan-kondisi";
        let params = [];

        if (filterState.jenis) {
            params.push("jenis=" + encodeURIComponent(filterState.jenis));
        }

        if (filterState.tipe) {
            params.push("tipe=" + encodeURIComponent(filterState.tipe));
        }

        if (filterState.kondisi) {
            params.push("kondisi=" + encodeURIComponent(filterState.kondisi));
        }

        if (params.length > 0) {
            url += "?" + params.join("&");
        }

        window.open(url, "_blank");
    };
});
