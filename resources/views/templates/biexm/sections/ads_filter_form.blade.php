@php
    $request        = request();
    $fiatGateways   = App\Models\FiatGateway::getGateways();
    $countries      = json_decode(file_get_contents(resource_path('views/partials/country.json')));
    $cryptos        = App\Models\CryptoCurrency::active()->orderBy('name')->get();
@endphp
<div class="search-box ">
    <ul class="nav nav-pills nav-justified fst_pil">
        <li class="nav-item tab_act" custom="buy">
            <a data-bs-toggle="pill" href="#q_buy" class="@if(! isset($sell)) active @endif">@lang('Quick Buy')</a>
        </li>
        <li class="nav-item tab_act" custom="sell">
            <a data-bs-toggle="pill" href="#q_sell" class="@if(isset($sell)) active @endif">@lang('Quick Sell')</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="q_buy" class="tab-pane fade @if(! isset($sell)) show active @endif">
            <form action="{{ route('advertisement.crypto',['type' => 'buy']) }}" method="get" class="q_bsfrm" accept-charset="utf-8" novalidate="novalidate">
                <div class="qk_rw">
                    <div class="qk_fd1">
                        <input type="number" step="any" name="amount" placeholder="@lang('Enter amount')" class="form-control form--control currency" value="{{@$request->amount &&  @$request->amount > 0 ? getAMount(@$request->amount) : '' }}">
                    </div>
                    <div class="qk_fd1">
                        <div class="select_style1">
                            <select name="crypto" id="crypto">
                                @foreach ($cryptos as $crypto)
                                    <option @if (@$request->crypto == $crypto->code ) selected @endif value="{{ $crypto->code }}">{{ $crypto->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="qk_fd2 payWid">
                        <div class="select_style1">
                            <select class="select form--control" name="fiat_gateway">
                                <option disabled>@lang('Select Payment Gateway')</option>
                                <option selected value="all" @selected(@$request->gateway == 'all')>@lang('All')</option>
                                @foreach ($fiatGateways as $gateway)
                                    <option data-fiat='@json(@$gateway->fiat)' value="{{ $gateway->slug }}"  @selected(@$request->gateway == @$gateway->slug)>
                                        {{ __($gateway->name) }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="qk_fd1">
                        <div class="select_style1">
                            <select class="select form--control" name="fiat_currency">
                                <option selected disabled>@lang('Select Currency')</option>
                            </select>
                        </div>
                    </div>
                    <div class="qk_fd2">
                        <div class="select_style1">
                            <select class="select form--control" name="location">
                                <option selected disabled>@lang('Select Location')</option>
                                <option data-code="all" value="all">@lang('All')</option>
                                @foreach ($countries as $key => $country)
                                    <option value="{{$key}}" @selected(@$request->country == $key) >
                                        {{ __($country->country) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="qk_fd3">
                        <button type="submit" id="searchbuy1" class="btn cm_grnbtn1">Search </button>
                    </div>
                </div>
            </form>
        </div>
        <div id="q_sell" class="tab-pane fade @if(isset($sell)) show active @endif">
            <form action="{{ route('advertisement.crypto',['type' => 'sell']) }}" method="get" class="q_bsfrm" accept-charset="utf-8" novalidate="novalidate">
                <div class="qk_rw">
                    <div class="qk_fd1">
                        <input type="number" step="any" name="amount" placeholder="@lang('Enter amount')" class="form-control form--control currency" value="{{@$request->amount &&  @$request->amount > 0 ? getAMount(@$request->amount) : '' }}">
                    </div>
                    <div class="qk_fd1">
                        <div class="select_style1">
                            <select name="crypto" id="crypto">
                                @foreach ($cryptos as $crypto)
                                    <option @if (@$request->crypto == $crypto->code ) selected @elseif(!@$request->crypto && $loop->first) selected @endif value="{{ $crypto->code }}">{{ $crypto->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="qk_fd2 payWid">
                        <div class="select_style1">
                            <select class="select form--control" name="fiat_gateway">
                                <option selected disabled>@lang('Select Payment Gateway')</option>
                                <option value="all" @selected(@$request->gateway == 'all')>@lang('All')</option>
                                @foreach ($fiatGateways as $gateway)
                                    <option data-fiat='@json(@$gateway->fiat)' value="{{ $gateway->slug }}"  @selected(@$request->gateway == @$gateway->slug)>
                                        {{ __($gateway->name) }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="qk_fd1">
                        <div class="select_style1">
                            <select class="select form--control" name="fiat_currency">
                                <option selected disabled>@lang('Select Currency')</option>
                            </select>
                        </div>
                    </div>
                    <div class="qk_fd2">
                        <div class="select_style1">
                            <select class="select form--control" name="location">
                                <option selected disabled>@lang('Select Location')</option>
                                <option data-code="all" value="all">@lang('All')</option>
                                @foreach ($countries as $key => $country)
                                    <option value="{{$key}}" @selected(@$request->country == $key) >
                                        {{ __($country->country) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="qk_fd3">
                        <button type="submit" id="searchbuy1" class="btn cm_grnbtn1">Search </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>