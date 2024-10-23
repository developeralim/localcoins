@php
    $content        = getContent('banner.content', true);
@endphp
<section class="banner-section section-bg py-4">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6 text-left afterlogin-none">
                <div class="sec-heading">
                    <h2 class="text-left font-700">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="text-left mt-2">{{ __(@$content->data_values->subheading) }}</p>
                </div>
                <img src="{{ frontendImage('banner', @$content->data_values->image) }}" class="bannerImage">
                <div class="scroll-img">
                    <ul>
                        <li>
                            <a href="https://coinmarketcap.com/" target="_blank">
                                <div class="sl-right-cnt">
                                    <div class="sl-right-value-txt"><span class="cur-span">BTC / USDT </span></div>
                                    <div class="sl-right-value-txt"><span class="price-span pri-los">0.00 </span> <span class="price-rod">$0</span></div>
                                    <div class="sl-right-value-txt"><span class="price-span pri-los"> 0.00 % </span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://coinmarketcap.com/" target="_blank">
                                <div class="sl-right-cnt">
                                    <div class="sl-right-value-txt"><span class="cur-span">ETH / USDT </span></div>
                                    <div class="sl-right-value-txt"><span class="price-span pri-los">0.00 </span> <span class="price-rod">$0</span></div>
                                    <div class="sl-right-value-txt"><span class="price-span pri-los"> 0.00 % </span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://coinmarketcap.com/" target="_blank">
                                <div class="sl-right-cnt">
                                    <div class="sl-right-value-txt"><span class="cur-span">BNB / USDT </span></div>
                                    <div class="sl-right-value-txt"><span class="price-span pri-los">0.00 </span> <span class="price-rod">$0</span></div>
                                    <div class="sl-right-value-txt"><span class="price-span pri-los"> 0.00 % </span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://coinmarketcap.com/" target="_blank">
                                <div class="sl-right-cnt">
                                    <div class="sl-right-value-txt"><span class="cur-span">DOGE / USDT </span></div>
                                    <div class="sl-right-value-txt"><span class="price-span pri-los">0.00 </span> <span class="price-rod">$0</span></div>
                                    <div class="sl-right-value-txt"><span class="price-span pri-los"> 0.00 % </span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-5">
                @include($activeTemplate . 'sections.ads_filter_form')
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        "use strict";
        $('select[name=fiat_gateway]').on('change', function() {
            let fiats = $(this).find('option:selected').data('fiat');
            let html = `
                <option selected disabled>@lang('Select Currency')</option>
                <option value="all" @selected(@$request->currency == 'all')>@lang('All')</option>
            `;
            let oldCurrency="{{ @$request->currency }}"
            $.each(fiats || [], function(i, v) {
                html += `<option value="${v.code}" ${v.code == oldCurrency ? 'selected' : ''}>${v.code}</option>`;
            });
            $('.select[name=fiat_currency]').html(html);
        }).val('all');
    </script>
@endpush
