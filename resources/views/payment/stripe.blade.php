
{{Config::get('stripe.stripe.public')}}

<form action="{{url('/api/v1/orders/pay')}}" method="POST">
  <script
    src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
    data-key="{{Config::get('stripe.stripe.public')}}"
    data-amount="2000"
    data-name="Demo Laravel Site"
    data-description="2 scoops of ice cream ($20.00)"
    data-image="/128x128.png">
  </script>
</form>