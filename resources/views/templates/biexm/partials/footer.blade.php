@php
    $socialIconElements = getContent('social_icon.element');
    $policyElements = getContent('policy_pages.element');
    $subscribeContent = getContent('subscribe.content', true);
    $cryptos = App\Models\CryptoCurrency::active()->orderBy('name')->take(7)->get();
@endphp

<footer class="foot_sc py-5">
    <div class="container">
        <div class="foot_tp row">
            <div class="col-lg-3 col-md-3 col-6">
                <h5>@lang('Legal')</h5>
                <ul class="list-inline foot_link1">
                    @foreach ($policyElements as $policy)
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="{{ route('policy.pages', $policy->slug) }}">
                                {{ __($policy->data_values->title) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-6">
                <h5>@lang('Quick Link')</h5>
                <ul class="list-inline foot_link1">
                    <li class="">
                        @auth
                            <a href="{{ route('user.home') }}" class="footer-menu__link">@lang('Dashboard')</a>
                        @else
                            <a href="{{ route('home') }}" class="footer-menu__link">@lang('Home')</a>
                        @endauth
                    </li>
                    <li class="">
                        <a href="{{ route('pages', 'about') }}" class="footer-menu__link">
                            @lang('About')
                        </a>
                    </li>
                    <li class="footer-menu__item">
                        <a href="{{ route('user.trade.request.running') }}" class="footer-menu__link">
                            @lang('Trade')
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-6">
                <h5>@lang('Buy Asset')</h5>
                <ul class="list-inline foot_link1">
                    @foreach ($cryptos as $crypto)
                        <li class="footer-menu__item">
                            <a class="footer-menu__link"
                                href="{{ route('advertisement.crypto', ['buy', $crypto->code, 'all']) }}">
                                {{ $crypto->code }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-6">
                <h5>@lang('Sell Asset')</h5>
                <ul class="list-inline foot_link1">
                    @foreach ($cryptos as $crypto)
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="{{ route('advertisement.crypto', ['sell', $crypto->code, 'all']) }}">
                                {{ $crypto->code }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row foot_cpy">
            <div class="col d-flex align-items-center">
                <span class="fw-bold mr-5 follow_us_label">@lang('FOLLOW US')</span>
                <ul class="list-inline soc_lis1 mb-0">
                    @foreach ($socialIconElements as $social)
                        <li class="list-inline-item">
                            <a class="social-list__link flex-center" href="{{ @$social->data_values->url }}"
                                target="_blank">
                                @php echo @$social->data_values->social_icon @endphp
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col copyright">
                <p class="text-center">Copyrights © Biexm 2021. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

@push('script')
    <script>
        "use strict";
        (function($) {
            $('#subscribe-form').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData($(this)[0]);
                let $this = $(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: "{{ route('subscribe') }}",
                    method: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $this.find('button[type=submit]').html(`
                        <span class="right-sidebar__button-icon">
                            <i class="las la-spinner la-spin"></i> {{ __(@$subscribeContent->data_values->button_text) }}
                        </span>`).attr('disabled', true);
                    },
                    complete: function(e) {
                        setTimeout(() => {
                            $this.find('button[type=submit]').html(
                                `{{ __(@$subscribeContent->data_values->button_text) }}`
                            ).attr('disabled', false);
                        }, 500);
                    },
                    success: function(resp) {
                        setTimeout(() => {
                            if (resp.success) {
                                notify('success', resp.message);
                                $($this).trigger('reset');
                            } else {
                                notify('error', resp.message || resp.error);
                            }
                        }, 500);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
