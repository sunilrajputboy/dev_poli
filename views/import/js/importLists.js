$(document).ready(function() {
    $('#importLists').DataTable({
        "order": [
            [0, "desc"]
        ],
        "bProcessing": true,
        "iDisplayLength": 10,
        "bFilter": true,
        "bPaginate": true,
        "serverSide": true,
        "scrollX": true,
        stateSave: true,
        "ajax": {
            url: "../import/importLists",
            error: function() {}
        }
    });
});

;