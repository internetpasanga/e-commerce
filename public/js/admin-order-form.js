(function () {
    var template = document.getElementById('product-row-template');
    var rowsContainer = document.getElementById('product-rows');
    var addBtn = document.getElementById('add-product-row');

    function bindRemoveButtons() {
        rowsContainer.querySelectorAll('[data-action="remove-product-row"]').forEach(function (btn) {
            if (btn.dataset.bound) {
                return;
            }
            btn.dataset.bound = 'true';
            btn.addEventListener('click', function () {
                if (rowsContainer.querySelectorAll('.product-row').length > 1) {
                    btn.closest('.product-row').remove();
                }
            });
        });
    }

    function addRow() {
        var clone = template.content.cloneNode(true);
        rowsContainer.appendChild(clone);

        if (window.SearchableSelect) {
            window.SearchableSelect.init();
        }

        bindRemoveButtons();
    }

    if (template && rowsContainer && addBtn) {
        addBtn.addEventListener('click', addRow);
        addRow();
    }

    function bindAddressToggle(radioName, newRadioId, fieldsId) {
        var fields = document.getElementById(fieldsId);
        var newRadio = document.getElementById(newRadioId);

        if (!fields || !newRadio) {
            return;
        }

        var radios = document.querySelectorAll('input[name="' + radioName + '"]');

        function sync() {
            fields.style.display = newRadio.checked ? '' : 'none';
        }

        radios.forEach(function (radio) {
            radio.addEventListener('change', sync);
        });

        sync();
    }

    bindAddressToggle('shipping_address_id', 'shipping-address-new', 'new-shipping-address-fields');
    bindAddressToggle('billing_address_id', 'billing-address-new', 'new-billing-address-fields');

    var billingCheckbox = document.getElementById('billing_same_as_shipping');
    var billingSection = document.getElementById('billing-address-section');

    if (billingCheckbox && billingSection) {
        function syncBilling() {
            billingSection.style.display = billingCheckbox.checked ? 'none' : 'block';
        }

        billingCheckbox.addEventListener('change', syncBilling);
        syncBilling();
    }
})();
