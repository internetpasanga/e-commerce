<x-layouts.site title="Complete Payment">
    <div class="order-confirmation">
        <h1 class="page-title">Redirecting to secure payment&hellip;</h1>
        <p>Please wait while we open the Razorpay payment window. If it doesn't open automatically, click the button below.</p>

        <button type="button" class="btn btn-primary" id="rzp-open-btn">Pay ₹{{ number_format($amount / 100, 2) }}</button>
        <p style="margin-top: 1rem;">
            <a href="{{ route('checkout.create') }}">Cancel and return to checkout</a>
        </p>
    </div>

    <form method="POST" action="{{ route('checkout.razorpay.verify') }}" id="rzp-verify-form">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="rzp-payment-id">
        <input type="hidden" name="razorpay_order_id" id="rzp-order-id">
        <input type="hidden" name="razorpay_signature" id="rzp-signature">
    </form>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        (function () {
            var options = {
                key: {{ \Illuminate\Support\Js::from($razorpayKey) }},
                order_id: {{ \Illuminate\Support\Js::from($razorpayOrderId) }},
                amount: {{ \Illuminate\Support\Js::from($amount) }},
                currency: 'INR',
                name: {{ \Illuminate\Support\Js::from($siteName) }},
                description: 'Order payment',
                prefill: {
                    name: {{ \Illuminate\Support\Js::from($user->name) }},
                    email: {{ \Illuminate\Support\Js::from($user->email) }},
                    contact: {{ \Illuminate\Support\Js::from($shippingAddress->phone) }}
                },
                handler: function (response) {
                    document.getElementById('rzp-payment-id').value = response.razorpay_payment_id;
                    document.getElementById('rzp-order-id').value = response.razorpay_order_id;
                    document.getElementById('rzp-signature').value = response.razorpay_signature;
                    document.getElementById('rzp-verify-form').submit();
                },
                modal: {
                    ondismiss: function () {
                        window.location.href = {{ \Illuminate\Support\Js::from(route('checkout.create')) }};
                    }
                }
            };

            var rzp = new Razorpay(options);

            document.getElementById('rzp-open-btn').addEventListener('click', function () {
                rzp.open();
            });

            rzp.open();
        })();
    </script>
</x-layouts.site>
