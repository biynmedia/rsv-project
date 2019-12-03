import '../scss/datatable.scss';

// Solution at : https://datatables.net/forums/discussion/50003/datatables-with-webpack-fn-datatable-undefined
import $ from 'jquery';
window.jQuery = $;
import DataTable from 'datatables.net';
import 'datatables.net-responsive-bs4';

$(function () {
    $('#topicsTable').dataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        }
    } );
});