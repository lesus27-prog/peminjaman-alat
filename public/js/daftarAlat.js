let isCari = false;
let tglMulai;
let fpTglMulai;
let fpTglSelesai;
function toggleView(isCard) {
    if (isCard) {
        $("#view-card").fadeIn(200);
        $("#view-table").hide();
    } else {
        $("#view-table").fadeIn(200);
        $("#view-card").hide();
    }
}

function syncCard() {
    let visibleIds = [];

    table
        .rows({
            page: "current",
        })
        .every(function () {
            let id = $(this.node()).data("id");
            if (id) visibleIds.push(id);
        });

    $(".alat-card").closest(".col-lg-3").hide();

    visibleIds.forEach(function (id) {
        $('.alat-card[data-id="' + id + '"]')
            .closest(".col-lg-3")
            .show();
    });
}

function updateJamKembali() {
    let jamMulai = $("#jam-mulai").val();
    let tglSelesaiVal = $("#tanggal-selesai").val();

    if (!jamMulai || !tglSelesaiVal || !tglMulai) return;

    let tglSelesai = new Date(fpTglSelesai.input.value);

    let [jamMulaiNum, menitMulaiNum] = jamMulai.split(":").map(Number);

    let isSameDay = tglSelesai.toDateString() === tglMulai.toDateString();

    let maxDate = fpTglSelesai.config.maxDate;

    let isMaxDay =
        maxDate &&
        tglSelesai.toDateString() === new Date(maxDate).toDateString();

    $("#jam-selesai option").each(function () {
        let val = $(this).val();

        if (!val) return;

        let [jamValNum, menitValNum] = val.split(":").map(Number);

        let disable = false;

        if (isSameDay) {
            disable =
                jamValNum < jamMulaiNum ||
                (jamValNum === jamMulaiNum && menitValNum <= menitMulaiNum);
        } else if (isMaxDay) {
            disable =
                jamValNum > jamMulaiNum ||
                (jamValNum === jamMulaiNum && menitValNum > menitMulaiNum);
        }

        $(this)
            .prop("disabled", disable)
            .css("color", disable ? "#aaa" : "");
    });

    let selected = $("#jam-selesai").val();

    if (!selected) return;

    let [jam, menit] = selected.split(":").map(Number);

    let invalid =
        (isSameDay &&
            (jam < jamMulaiNum ||
                (jam === jamMulaiNum && menit <= menitMulaiNum))) ||
        (isMaxDay &&
            (jam > jamMulaiNum ||
                (jam === jamMulaiNum && menit > menitMulaiNum)));

    if (invalid) {
        $("#jam-selesai").val("");
    }
}

function checkNextButton() {
    let tanggalMulai = fpTglMulai.selectedDates.length > 0;
    let jamMulai = $("#jam-mulai").val();
    $("#btn-next").prop(
        "disabled",
        !(tanggalMulai && jamMulai && isCari === true),
    );
}

function reset() {
    fpTglMulai.clear();
    $("#jam-mulai").val("");
    $("#filterJenis").val(null).trigger("change");
    $("#filterTipe").val(null).trigger("change");
    table.search("").columns().search("").draw();
    $("#box-ketersediaan").removeClass("active").slideUp(300);
    $(".alat-table, .alat-card").removeClass("active");
    $(".btn-pinjam")
        .removeClass("btn-danger")
        .addClass("btn-custom")
        .text("Pinjam");

    $(".jumlah").val(1);
    $(".btn-kurang").prop("disabled", true);

    $(".btn-tambah").each(function () {
        let stok = parseInt($(this).siblings(".jumlah").data("stok") || 0);
        $(this).prop("disabled", stok <= 1);
    });

    // if (fpTglSelesai) fpTglSelesai.clear();

    // $('#jam-selesai').val('');
    // $('#jam-selesai option').prop('disabled', false).css('color', '');

    // $('#list-alat').html('');
    // $('#hidden-input').html('');
    // $('#modal-tanggal-mulai').text('');
    // $('#modal-jam-mulai').text('');

    // $('.alat-card').show();
}

function checkKonfirmasiButton() {
    let jumlahAlat = $("#list-alat tr").length;
    $("#btn-konfirmasi").prop("disabled", jumlahAlat === 0);
}

function modalDeleteAlat(id) {
    let alat = $(`.alat-table[data-id="${id}"], .alat-card[data-id="${id}"]`);

    alat.removeClass("active")
        .find(".btn-pinjam")
        .removeClass("btn-danger")
        .addClass("btn-custom")
        .text("Pinjam");

    alat.find(".jumlah").val(1);
    alat.find(".btn-kurang").prop("disabled", true);

    alat.find(".btn-tambah").each(function () {
        let stok = parseInt($(this).siblings(".jumlah").data("stok")) || 0;
        $(this).prop("disabled", stok <= 1);
    });
}

$(document).ready(function () {
    $("#toggle-view").on("change", function () {
        toggleView($(this).is(":checked"));
    });

    toggleView($("#toggle-view").is(":checked"));

    var elem = document.querySelector("#toggle-view");
    var switchery = new Switchery(elem, {
        size: "small",
        color: "#28a745",
        secondaryColor: "#f56767",
    });

    if (!$.fn.DataTable.isDataTable(".data-table")) {
        table = $(".data-table").DataTable({
            responsive: false,
            autoWidth: false,
            pageLength: 10,
            lengthChange: true,
            dom: "lrtip",
            ordering: false,
            language: {
                search: "",
                zeroRecords: "Data tidak ditemukan",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                lengthMenu: "_MENU_",
                paginate: {
                    next: ">>",
                    previous: "<<",
                },
            },
        });

        $("#show-entries").html($(".dataTables_length").detach());
        $("#show-entries").prepend('<span class="me-1">Show :</span>');
        table.on("draw", function () {
            syncCard();
        });
    }

    let timeout;
    $("#searchInput").on("input", function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            table.search(this.value).draw();
        }, 300);
    });

    $("#btn-cari").on("click", function () {
        let tanggalMulai = $("#tanggal-mulai").val();
        let jamMulai = $("#jam-mulai").val();

        if (!tanggalMulai || !jamMulai) {
            toastr.warning("Silahkan pilih tanggal dan jam!");
            return;
        }

        isCari = true;

        let formatTglMulai = new Date(tanggalMulai).toLocaleDateString(
            "id-ID",
            {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            },
        );

        $("#tanggal").text(formatTglMulai);
        $("#jam").text(jamMulai.slice(0, 5));

        $.ajax({
            url: "/check-alat",
            type: "GET",
            data: {
                _token: "{{ csrf_token() }}",
                tglMulai: tanggalMulai,
                jamMulai: jamMulai,
            },

            beforeSend: function () {
                $("#btn-cari")
                    .prop("disabled", true)
                    .html(
                        '<i class="fa-solid fa-spinner fa-spin"></i> Loading...',
                    );
            },

            success: function (response) {
                console.log(response);
                $(".btn-pinjam").each(function () {
                    let jamKey = jamMulai;
                    let id = parseInt($(this).data("id"));

                    let stokTersedia = response[id] ?? 0;

                    let row = $(this).closest("tr");
                    let card = $('.alat-card[data-id="' + id + '"]');

                    // Cache element
                    let rowJumlah = row.find(".jumlah");
                    let cardJumlah = card.find(".jumlah");

                    let rowStok = row.find(".stok-tersedia");
                    let cardStok = card.find(".stok-tersedia");

                    let rowBtnControl = row.find(".btn-tambah, .btn-kurang");
                    let cardBtnControl = card.find(".btn-tambah, .btn-kurang");

                    let cardBtnPinjam = card.find(".btn-pinjam");

                    // Update jumlah
                    rowJumlah
                        .attr("data-stok", stokTersedia)
                        .val(stokTersedia > 0 ? 1 : 0);

                    cardJumlah
                        .attr("data-stok", stokTersedia)
                        .val(stokTersedia > 0 ? 1 : 0);

                    // Update stok text
                    let stokText =
                        stokTersedia > 0
                            ? "Tersedia : " + stokTersedia
                            : "Tidak Tersedia";

                    let stokClassRemove =
                        stokTersedia > 0 ? "empty" : "available";

                    let stokClassAdd = stokTersedia > 0 ? "available" : "empty";

                    rowStok
                        .removeClass(stokClassRemove)
                        .addClass(stokClassAdd)
                        .text(stokText);

                    cardStok
                        .removeClass(stokClassRemove)
                        .addClass(stokClassAdd)
                        .text(stokText);

                    // Kondisi stok habis
                    if (stokTersedia <= 0) {
                        $(this)
                            .prop("disabled", true)
                            .removeClass("btn-custom")
                            .addClass("btn-secondary")
                            .text("Habis");

                        cardBtnPinjam
                            .prop("disabled", true)
                            .removeClass("btn-custom")
                            .addClass("btn-secondary")
                            .text("Habis");

                        rowBtnControl.prop("disabled", true);
                        cardBtnControl.prop("disabled", true);

                        card.addClass("disabled-card");
                    } else {
                        $(this)
                            .prop("disabled", false)
                            .removeClass("btn-secondary")
                            .addClass("btn-custom")
                            .text("Pinjam");

                        cardBtnPinjam
                            .prop("disabled", false)
                            .removeClass("btn-secondary")
                            .addClass("btn-custom")
                            .text("Pinjam");

                        rowBtnControl.prop("disabled", false);
                        cardBtnControl.prop("disabled", false);

                        card.removeClass("disabled-card");
                    }
                });

                $("#box-ketersediaan").addClass("active").slideDown(400);

                $("html, body").animate(
                    {
                        scrollTop: $("#box-ketersediaan").offset().top - 80,
                    },
                    500,
                );
            },

            // error: function () {
            //     toastr.error("Gagal mengambil data alat, silahkan coba lagi!");
            // },

            error: function (xhr) {
                console.log(xhr);
                console.log(xhr.responseText);
                toastr.error("Gagal mengambil data alat!");
            },
            complete: function () {
                $("#btn-cari")
                    .prop("disabled", false)
                    .html('<i class="fa-solid fa-magnifying-glass"></i> Cari');
            },
        });

        checkNextButton();
    });

    fpTglMulai = flatpickr("#tanggal-mulai", {
        locale: "id",
        minDate: "today",
        altInput: true,
        altInputClass: "form-control form-input",
        altFormat: "l, d F Y",
        disable: [(date) => date.getDay() === 0 || date.getDay() === 6],

        onChange: function (selectedDates) {
            if (!selectedDates.length) return;

            if (isCari) {
                // reset();
                isCari = false;
            }

            tglMulai = selectedDates[0];

            let daysAdded = 0;
            let tempDate = new Date(tglMulai);

            while (daysAdded < 3) {
                tempDate.setDate(tempDate.getDate() + 1);

                if (tempDate.getDay() !== 0 && tempDate.getDay() !== 6) {
                    daysAdded++;
                }
            }

            let tglMax = tempDate;

            fpTglSelesai.set("minDate", tglMulai);
            fpTglSelesai.set("maxDate", tglMax);

            fpTglSelesai.clear();

            $("#jam-selesai").val("");

            $("#jam-selesai option").prop("disabled", false).css("color", "");

            updateJamKembali();
            checkNextButton();
        },
    });

    fpTglSelesai = flatpickr("#tanggal-selesai", {
        locale: "id",
        altInput: true,
        altFormat: "l, d F Y",
        disable: [(date) => date.getDay() === 0 || date.getDay() === 6],
        onChange: updateJamKembali,
    });

    $("#jam-mulai").on("change", function () {
        if (isCari) {
            reset();
            isCari = false;
        }

        $("#jam-selesai").val("");

        updateJamKembali();
        checkNextButton();
    });

    $("#tanggal-selesai").on("change", updateJamKembali);

    $("#btn-next").prop("disabled", true);
    checkNextButton();
    $("#tanggal_pakai, #jam_pakai, .btn-pinjam").on(
        "change click",
        checkNextButton,
    );

    $("#btn-reset").on("click", function () {
        reset();
        checkNextButton();
        applyFilter();
    });

    $(document).on("click", ".btn-tambah, .btn-kurang", function () {
        let parent = $(this).closest("[data-id]");
        let id = parent.data("id");
        let input = parent.find(".jumlah");
        let jumlah = parseInt(input.val());
        let stok = parseInt(input.data("stok"));

        if ($(this).hasClass("btn-tambah") && jumlah < stok) jumlah++;
        if ($(this).hasClass("btn-kurang") && jumlah > 1) jumlah--;

        $(`[data-id="${id}"]`).each(function () {
            let jml = $(this).find(".jumlah");
            let s = parseInt(jml.data("stok"));

            jml.val(jumlah);

            $(this)
                .find(".btn-kurang")
                .prop("disabled", jumlah <= 1);
            $(this)
                .find(".btn-tambah")
                .prop("disabled", jumlah >= s);
        });
    });

    function toggleAlat(idTipe) {
        let alatTable = $(`.alat-table[data-id="${idTipe}"]`);
        let alatCard = $(`.alat-card[data-id="${idTipe}"]`);

        let btnTablePinjam = alatTable.find(".btn-pinjam");
        let btnCardPinjam = alatCard.find(".btn-pinjam");

        if (alatTable.hasClass("active") || alatCard.hasClass("active")) {
            alatTable.removeClass("active");
            alatCard.removeClass("active");

            btnTablePinjam
                .removeClass("btn-danger")
                .addClass("btn-custom")
                .text("Pinjam");

            btnCardPinjam
                .removeClass("btn-danger")
                .addClass("btn-custom")
                .text("Pinjam");
        } else {
            alatTable.addClass("active");
            alatCard.addClass("active");

            btnTablePinjam
                .addClass("btn-danger")
                .removeClass("btn-custom")
                .text("Batal");

            btnCardPinjam
                .addClass("btn-danger")
                .removeClass("btn-custom")
                .text("Batal");
        }
    }

    $(document).on("click", ".btn-pinjam", function (e) {
        e.stopPropagation();
        let idTipe = $(this).data("id");
        toggleAlat(idTipe);
        checkNextButton();
    });

    function ucwords(str) {
        return str.toLowerCase().replace(/\b\w/g, (c) => c.toUpperCase());
    }

    $("#btn-next").on("click", function () {
        let alatDipilih = $(".alat-table.active, .alat-card.active").length > 0;

        if (!alatDipilih) {
            toastr.error("Silakan pilih minimal 1 alat");
            return;
        }

        let tglMulaiFormat = fpTglMulai.altInput.value;
        let tglMulaiAsli = fpTglMulai.input.value;
        let jamMulai = $("#jam-mulai").val();

        $("#modal-tanggal-mulai").text(tglMulaiFormat);
        $("#modal-jam-mulai").text(jamMulai.slice(0, 5));

        $("#hidden-tanggal-mulai").val(tglMulaiAsli);
        $("#hidden-jam-mulai").val(jamMulai);

        $("#list-alat").html("");
        $("#hidden-input").html("");

        let alat = {};
        $(".alat-table.active, .alat-card.active").each(function () {
            let id = $(this).data("id");
            let nama = $(this).data("nama");
            let jumlah = parseInt($(this).find(".jumlah").val()) || 1;

            alat[id] = {
                nama,
                jumlah,
            };
        });

        let index = 0;
        for (let id in alat) {
            let item = alat[id];

            $("#list-alat").append(`
                        <tr data-index="${index}" data-id="${id}">
                            <td>${index + 1}</td>
                            <td>${ucwords(item.nama)}</td>
                            <td>${item.jumlah}</td>
                           <td class="text-center">
                                <button type="button" class="btn btn-sm btn-delete">
                                     <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                                                    </tr>
                                                    `);

            $("#hidden-input").append(`
                        <input type="hidden" name="alat[${index}][id]" value="${id}">
                        <input type="hidden" name="alat[${index}][jumlah]" value="${item.jumlah}">
                    `);

            index++;
        }
        checkKonfirmasiButton();
        $("#modal-detail-peminjaman").modal("show");
    });

    $(document).on("click", ".btn-delete", function () {
        let row = $(this).closest("tr");
        let id = row.data("id");

        modalDeleteAlat(id);
        row.remove();

        $(`#hidden-input input[value="${id}"]`).remove();
        $("#list-alat tr").each(function (index) {
            $(this)
                .find("td:first")
                .text(index + 1);
        });
        checkKonfirmasiButton();
    });

    $("#filterJenis").select2({
        placeholder: "All Jenis",
        allowClear: true,
        width: "100%",
    });

    $("#filterTipe").select2({
        placeholder: "All Tipe",
        allowClear: true,
        width: "100%",
    });

    $("#filterJenis").on("change", function () {
        let val = $(this).val();
        table
            .column(2)
            .search(val || "")
            .draw();
    });

    $("#filterTipe").on("change", function () {
        let val = $(this).val();
        table
            .column(1)
            .search(val || "")
            .draw();
    });

    $("#toggle-view")
        .on("change", function () {
            $("#grid-icon").toggleClass("active", this.checked);
        })
        .trigger("change");
});
