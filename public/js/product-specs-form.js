(function () {
    var template = document.getElementById('spec-row-template');
    var rowsContainer = document.getElementById('specification-rows');
    var addBtn = document.getElementById('add-spec-row');

    if (!template || !rowsContainer || !addBtn) {
        return;
    }

    function bindRemoveButtons() {
        rowsContainer.querySelectorAll('[data-action="remove-spec-row"]').forEach(function (btn) {
            if (btn.dataset.bound) {
                return;
            }
            btn.dataset.bound = 'true';
            btn.addEventListener('click', function () {
                btn.closest('.spec-row').remove();
            });
        });
    }

    function addRow() {
        var clone = template.content.cloneNode(true);
        rowsContainer.appendChild(clone);
        bindRemoveButtons();
    }

    addBtn.addEventListener('click', addRow);
    bindRemoveButtons();

    if (!rowsContainer.children.length) {
        addRow();
    }
})();
