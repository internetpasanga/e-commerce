(function () {
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrfMeta ? csrfMeta.content : null;

    function showToast(message, type) {
        var stack = document.getElementById('toast-stack');
        if (!stack) {
            return;
        }
        var toast = document.createElement('div');
        toast.className = 'toast toast-' + (type || 'success');
        toast.textContent = message;
        stack.appendChild(toast);
        setTimeout(function () {
            toast.classList.add('is-leaving');
            setTimeout(function () {
                toast.remove();
            }, 200);
        }, 3000);
    }

    function updateCartCount(count) {
        var badge = document.getElementById('cart-count');
        if (!badge) {
            return;
        }
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
        badge.classList.remove('is-bumping');
        void badge.offsetWidth;
        badge.classList.add('is-bumping');
    }

    function addToCart(productId, quantity) {
        return fetch('/cart/' + productId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ quantity: quantity }),
        }).then(function (res) {
            return res.json().then(function (body) {
                return { ok: res.ok, body: body };
            });
        });
    }

    // Quantity stepper + Add to Cart / Buy Now on the product detail page.
    var purchaseBox = document.querySelector('.product-detail-purchase');

    if (purchaseBox) {
        var qtyInput = document.getElementById('quantity');
        var maxStock = parseInt(purchaseBox.dataset.productStock, 10) || 1;
        var productId = purchaseBox.dataset.productId;

        function clampQty() {
            var val = parseInt(qtyInput.value, 10);
            if (isNaN(val) || val < 1) {
                val = 1;
            }
            if (val > maxStock) {
                val = maxStock;
            }
            qtyInput.value = val;
        }

        purchaseBox.querySelector('[data-action="qty-decrease"]').addEventListener('click', function () {
            qtyInput.value = (parseInt(qtyInput.value, 10) || 1) - 1;
            clampQty();
        });

        purchaseBox.querySelector('[data-action="qty-increase"]').addEventListener('click', function () {
            qtyInput.value = (parseInt(qtyInput.value, 10) || 1) + 1;
            clampQty();
        });

        qtyInput.addEventListener('input', function () {
            qtyInput.value = qtyInput.value.replace(/[^0-9]/g, '');
        });

        qtyInput.addEventListener('blur', clampQty);

        var addBtn = purchaseBox.querySelector('.add-to-cart-btn');
        var buyBtn = purchaseBox.querySelector('.buy-now-btn');

        if (addBtn) {
            addBtn.addEventListener('click', function () {
                clampQty();
                addBtn.disabled = true;

                addToCart(productId, parseInt(qtyInput.value, 10))
                    .then(function (result) {
                        if (result.ok) {
                            updateCartCount(result.body.count);
                            showToast((addBtn.dataset.productName || 'Item') + ' added to cart.', 'success');
                        } else {
                            showToast(result.body.message || 'Something went wrong.', 'error');
                        }
                    })
                    .finally(function () {
                        addBtn.disabled = false;
                    });
            });
        }

        if (buyBtn) {
            buyBtn.addEventListener('click', function () {
                clampQty();
                buyBtn.disabled = true;

                addToCart(productId, parseInt(qtyInput.value, 10))
                    .then(function (result) {
                        if (result.ok) {
                            window.location.href = '/cart';
                        } else {
                            showToast(result.body.message || 'Something went wrong.', 'error');
                            buyBtn.disabled = false;
                        }
                    });
            });
        }
    }

    // Add to Cart buttons on product listing cards (home/category pages).
    document.addEventListener('click', function (event) {
        var btn = event.target.closest('.add-to-cart-btn');

        if (!btn || btn.closest('.product-detail-purchase')) {
            return;
        }

        var productId = btn.dataset.productId;
        if (!productId) {
            return;
        }

        event.preventDefault();
        btn.disabled = true;

        addToCart(productId, 1)
            .then(function (result) {
                if (result.ok) {
                    updateCartCount(result.body.count);
                    showToast((btn.dataset.productName || 'Item') + ' added to cart.', 'success');
                } else {
                    showToast(result.body.message || 'Something went wrong.', 'error');
                }
            })
            .finally(function () {
                btn.disabled = false;
            });
    });
})();
