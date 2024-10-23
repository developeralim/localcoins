@php
    $cryptos = App\Models\CryptoCurrency::active()->get();
@endphp
@include($activeTemplate . 'partials.buy_sell_quick_filter',compact('cryptos'))
@include($activeTemplate . 'partials.buy_sell_nearest_advertisements',compact('cryptos'))