(function (window, $) {
    'use strict';

    function init(options) {
        if (!options || !options.table || !options.tableSelector || !options.deleteUrl || !options.buttonSelector) return;

        var table = options.table;
        var $table = $(options.tableSelector);
        var $container = $(table.table().container());
        var $button = $(options.buttonSelector);
        var rowSelector = options.rowCheckbox || '.table-row-select';
        var allSelector = options.selectAllSelector || '.table-select-all';
        var mode = options.mode || 'delete';
        var selected = new Set();

        var labels = mode === 'restore' ? {
            action: 'Restore',
            actionLower: 'restore',
            title: 'Restore selected?',
            description: 'You are about to restore',
            successTitle: 'Restored!',
            successFallback: 'records restored successfully.',
            failTitle: 'Restore failed',
            failFallback: 'Unable to restore the selected records.',
            iconClass: 'fas fa-redo-alt'
        } : {
            action: 'Delete',
            actionLower: 'delete',
            title: 'Delete selected?',
            description: 'You are about to delete',
            successTitle: 'Deleted!',
            successFallback: 'records deleted successfully.',
            failTitle: 'Delete failed',
            failFallback: 'Unable to delete the selected records.',
            iconClass: 'fas fa-trash-alt'
        };

        function rowId(row) {
            if (options.getRowId) return String(options.getRowId(row));
            return row && row.id !== undefined && row.id !== null ? String(row.id) : '';
        }

        function filteredIds() {
            var ids = [];
            table.rows({ search: 'applied' }).data().each(function (row) {
                var id = rowId(row);
                if (id) ids.push(id);
            });
            return ids;
        }

        function existingIds() {
            var ids = new Set();
            table.rows().data().each(function (row) {
                var id = rowId(row);
                if (id) ids.add(id);
            });
            return ids;
        }

        function pruneMissingSelections() {
            var existing = existingIds();
            selected.forEach(function (id) {
                if (!existing.has(id)) selected.delete(id);
            });
        }

        function ensureFloatingDock() {
            if (!$button.length) return;

            var dockId = 'bulkActionDock-' + ($table.attr('id') || Math.random().toString(36).slice(2));
            var $dock = $('#' + dockId);
            if (!$dock.length) {
                $dock = $('<div>', {
                    id: dockId,
                    class: 'bulk-floating-dock',
                    'aria-live': 'polite'
                }).appendTo(document.body);
            }

            $button.detach().appendTo($dock);
            $button.addClass('bulk-floating-action');
            $button.find('i').attr('class', labels.iconClass);
            $button.contents().filter(function () { return this.nodeType === 3; }).remove();
            if (!$button.find('.bulk-action-label').length) {
                $button.find('i').after($('<span>', { class: 'bulk-action-label', text: labels.action + ' Selected' }));
            } else {
                $button.find('.bulk-action-label').text(labels.action + ' Selected');
            }

            return $dock;
        }

        var $dock = ensureFloatingDock();

        function syncButton() {
            var count = selected.size;
            $button.prop('disabled', count === 0);
            $button.find('.bulk-select-count').attr('data-count', count);
            $button.attr('aria-label', count ? (labels.action + ' ' + count + ' selected records') : (labels.action + ' selected records'));
            if ($dock && $dock.length) {
                $dock.toggleClass('is-visible', count > 0);
            }
        }

        function syncCheckboxes() {
            // Keep the bulk-selection state in sync with the actual DataTable data.
            // This is especially important when a selected row is removed through
            // the row-level/single delete action and the table is reloaded.
            pruneMissingSelections();

            $container.find('tbody ' + rowSelector).each(function () {
                this.checked = selected.has(String(this.value));
            });

            var applied = filteredIds();
            var appliedSelected = applied.filter(function (id) { return selected.has(id); }).length;
            // DataTables can render/clone the header outside the original table when
            // horizontal scrolling is enabled. Sync every master checkbox inside
            // the DataTables container so the visible checkbox always works.
            var $all = $container.find('thead ' + allSelector);

            $all.prop('checked', applied.length > 0 && appliedSelected === applied.length);
            $all.prop('indeterminate', appliedSelected > 0 && appliedSelected < applied.length);
            syncButton();
        }

        $container.on('change.rsfBulk', 'tbody ' + rowSelector, function () {
            var id = String(this.value);
            if (this.checked) selected.add(id); else selected.delete(id);
            syncCheckboxes();
        });

        $container.on('change.rsfBulk', 'thead ' + allSelector, function () {
            var checked = this.checked;
            var ids = filteredIds();

            ids.forEach(function (id) {
                if (checked) selected.add(id); else selected.delete(id);
            });

            syncCheckboxes();
        });

        table.on('draw.rsfBulk search.dt.rsfBulk page.dt.rsfBulk length.dt.rsfBulk', syncCheckboxes);

        $button.on('click', function () {
            if (!selected.size) return;
            var ids = Array.from(selected);
            var noun = ids.length === 1 ? 'record' : 'records';
            var warningTail = mode === 'restore'
                ? ' They will be returned to the active product list.'
                : ' This action cannot be undone.';

            swal({
                title: labels.title,
                text: labels.description + ' ' + ids.length + ' selected ' + noun + '.' + warningTail,
                icon: 'warning',
                buttons: {
                    cancel: { text: 'Cancel', visible: true, className: 'btn btn-secondary' },
                    confirm: { text: labels.action + ' ' + ids.length, className: mode === 'restore' ? 'btn btn-success' : 'btn btn-danger' }
                },
                dangerMode: mode !== 'restore'
            }).then(function (confirmed) {
                if (!confirmed) return;

                $button.prop('disabled', true).addClass('is-loading');
                $.ajax({
                    url: options.deleteUrl,
                    type: 'POST',
                    data: { ids: ids },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        selected.clear();
                        table.ajax.reload(function () { syncCheckboxes(); }, false);
                        swal(labels.successTitle, response.message || (ids.length + ' ' + labels.successFallback), 'success');
                    },
                    error: function (xhr) {
                        var response = xhr.responseJSON || {};
                        var message = response.message || labels.failFallback;
                        if (response.errors) {
                            var first = Object.values(response.errors)[0];
                            if (Array.isArray(first)) message = first[0];
                        }
                        swal(labels.failTitle, message, 'error');
                    },
                    complete: function () {
                        $button.removeClass('is-loading');
                        syncButton();
                    }
                });
            });
        });

        syncCheckboxes();

        // Expose a small controller so row-level actions (single delete/restore)
        // can immediately remove an affected ID from the bulk selection state.
        return {
            removeSelected: function (id) {
                selected.delete(String(id));
                syncCheckboxes();
            },
            sync: syncCheckboxes
        };
    }

    window.RSFBulkDelete = { init: init };
    window.RSFBulkRestore = {
        init: function (options) {
            options = options || {};
            options.mode = 'restore';
            return init(options);
        }
    };
})(window, jQuery);
