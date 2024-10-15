@extends('storefront::public.layout')

@section('content')
    <section class="order-complete-wrap">
        <div class="container">
            <div class="order-complete-wrap-inner">
                <div class="order-complete">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>

                    <h2>{{ trans('storefront::order_complete.order_paid') }}</h2>
                    <span>{!! trans('storefront::order_complete.your_order_has_been_paid') !!}</span>
                </div>
            </div>
        </div>
    </section>

<script>
    store.clearCart();

    if (store.cartIsEmpty()) {
        this.crossSellProducts = [];
    }

    axios
        .delete(route("cart.clear"))
        .then((response) => {
            store.updateCart(response.data);
        })
        .catch((error) => {
            this.$notify(error.response.data.message);
        });
</script>
@endsection
