"use strict";
var getData = (function () {
    var table = function () {
        var datatable = $("#table_users").KTDatatable({
            data: {
                type: "remote",
                source: {
                    read: {
                        url: HOST_URL + "/list",
                        map: function (raw) {
                            var dataSet = raw;
                            return void 0 !== raw.data && (dataSet = raw.data), dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: !0,
            },
            layout: { scroll: !1, footer: !1 },
            sortable: !0,
            pagination: !0,
            search: { input: $("#kt_datatable_search_query"), key: "keyword" },
            columns: [
                { field: "no", title: "#", sortable: !1, width: 20, type: "number", selector: { class: "" }, textAlign: "center" },
                { field: "fullname", title: "Full Name" },
                { field: "group_name", title: "Role" },
                {
                    field: "active",
                    title: "Status",
                    template: function (row) {
                        var status = { 0: { title: "Not Active", state: "danger" }, 1: { title: "Active", state: "success" } };
                        return '<span class="label label-' + status[row.active].state + ' label-dot mr-2"></span><span class="font-weight-bold text-' + status[row.active].state + '">' + status[row.active].title + "</span>";
                    },
                },
                {
                    field: "Actions",
                    title: "Actions",
                    sortable: !1,
                    width: 125,
                    autoHide: !1,
                    overflow: "visible",
                    template: function (row) {
                        var actions =
                            '<a href="' +
                            HOST_URL +
                            "/edit/" +
                            row.no +
                            '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit">                  <span class="svg-icon svg-icon-success svg-icon-md">                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">                        <rect x="0" y="0" width="24" height="24"/>                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>                      </g>                    </svg>                  </span>                </a>';
                        return (
                            HOST_URL == BASE_URL + "/support/clients" &&
                                (actions +=
                                    '<a href="' +
                                    HOST_URL +
                                    "/tests/" +
                                    row.no +
                                    '" class="btn btn-sm btn-clean btn-icon mr-2" title="Tests">                        <span class="svg-icon svg-icon-info svg-icon-md">                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">                                    <rect x="0" y="0" width="24" height="24"/>                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>                                    <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>                                </g>                            </svg>                        </span>                    </a>'),
                            (actions +=
                                '<button data-action="delete" data-nya="' +
                                row.no +
                                '" class="btn btn-sm btn-clean btn-icon" title="Delete">                <span class="svg-icon svg-icon-danger svg-icon-md">                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">                        <rect x="0" y="0" width="24" height="24"/>                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>                    </g>                  </svg>                </span>              </button>              ')
                        );
                    },
                },
            ],
        });
        $("#modal-reset-filter-button").on("click", function (e) {
            e.preventDefault(),
                $(".filter-input").each(function () {
                    $(this).val(""),
                        $("select.filter-input").val("").trigger("change"),
                        datatable.setDataSourceParam("query", null),
                        datatable.load(),
                        $("#filter-modal-trigger").removeClass("btn-info"),
                        $("#filter-modal-trigger").addClass("btn-light-info");
                });
        }),
            $("#modal-filter-button").on("click", function (e) {
                e.preventDefault();
                var value = {},
                    i = 0;
                $(".filter-input").each(function (index, element) {
                    if ("" != $(this).val()) {
                        var key = $(this).attr("name");
                        (value[key] = $(this).val()), i++;
                    }
                }),
                    Object.keys(value).length > 0
                        ? (datatable.search(JSON.stringify(value), "multiple"), $("#filter-modal-trigger").removeClass("btn-light-info"), $("#filter-modal-trigger").addClass("btn-info"))
                        : (datatable.setDataSourceParam("query", null), datatable.load(), $("#filter-modal-trigger").removeClass("btn-info"), $("#filter-modal-trigger").addClass("btn-light-info"));
            }),
            $("#reload-button").on("click", function (e) {
                e.preventDefault(), datatable.reload();
            }),
            $("#kt_datatable_search_status").selectpicker();
    };
    return {
        init: function () {
            table();
        },
    };
})();
jQuery(document).ready(function () {
    getData.init();

  	$("#table_users").on("click", "[data-action='detail']", (function() {
        var id = $(this).attr("data-nya");
        $("[name=isPermanent]").attr("checked", !1),
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            url: HOST_URL + "/detail/" + id,
            dataType: "JSON",
            success: function(response) {
                response.status ? ($("#general-modal .modal-dialog").addClass("modal-lg"),
                $("#general-modal .modal-title").html("Detail"),
                $("#general-modal .modal-body").html(response.detail),
                $("#modal-ok-button").attr("data-action", "close-modal"),
                $("#general-modal").modal("show")) : notifyMessage(response.message, "danger")
            },
            error: function(request, status, error) {
                $("#deleteModal").modal("hide"),
                notifyMessage("Terjadi kesalahan. Coba beberapa saat lagi.", "danger")
            }
        })
    }));
});
