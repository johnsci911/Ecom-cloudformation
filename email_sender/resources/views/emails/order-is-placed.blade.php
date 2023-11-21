<x-mail::message>
# Hi {{ $email->user_email }} your order has been placed

## Order Summary:
@component('mail::table')
    | Product Name                   | Description                           | Price                              |
    | ------------------------------ | ------------------------------------- | ----------------------------------:|
    @foreach($cartData as $item)
    | {{ $item->product_name }}      | {{ $item->product_description }}      | ${{ $item->product_price }}        |
    @endforeach
    |                                | Total                                 | ${{ $email->total }}               |
@endcomponent
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

