(function () {
    var checkbox = document.getElementById('billing_same_as_shipping');
    var billingList = document.getElementById('billing-address-list');

    if (!checkbox || !billingList) {
        return;
    }

    function sync() {
        billingList.style.display = checkbox.checked ? 'none' : 'block';
    }

    checkbox.addEventListener('change', sync);
    sync();
})();
