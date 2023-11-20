<x-mail::message>
# An order is placed

Product: {{ $email->product_name }} has been placed

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
