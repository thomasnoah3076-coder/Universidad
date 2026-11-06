/**
 * CustomDataTable
 *
 * Inicializa DataTables sobre la tabla con id #example1 con:
 * - comportamiento responsive,
 * - textos en inglés,
 * - paginación y búsqueda del lado del cliente.
 *
 * Requiere que jQuery, DataTables y la extensión Responsive ya estén
 * cargados en la página.
 */
(function (window, document) {
    'use strict';

    class CustomDataTable {
        constructor(selector) {
            this.selector = selector || '#example1';
            this.table = document.querySelector(this.selector);

            if (!this.table) {
                return;
            }

            if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.DataTable) {
                return;
            }

            this.init();
        }

        init() {
            window.jQuery(this.table).DataTable({
                responsive: this.table.dataset.responsive !== 'false',
                ordering: this.table.dataset.ordering !== 'false',
                autoWidth: false,
                pageLength: 10,
                language: {
                    processing: 'Processing...',
                    search: 'Search:',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    loadingRecords: 'Loading...',
                    zeroRecords: 'No matching records found',
                    emptyTable: 'No data available in table',
                    paginate: {
                        first: 'First',
                        previous: 'Previous',
                        next: 'Next',
                        last: 'Last',
                    },
                    aria: {
                        sortAscending: ': activate to sort column ascending',
                        sortDescending: ': activate to sort column descending',
                    },
                },
            });
        }
    }

    // Expuesta por si alguna vista necesita inicializar otra tabla manualmente.
    window.CustomDataTable = CustomDataTable;

    document.addEventListener('DOMContentLoaded', function () {
        new CustomDataTable('#example1');
    });
})(window, document);
