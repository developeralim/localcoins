@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content        = getContent('registration.content', true);
        $policyElements = getContent('policy_pages.element');
    @endphp
    <section class="account section-bg py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-5 mx-auto">
                    @include($activeTemplate . 'partials.social_login')
                    <div class="log_bx1">
                        <h4>{{ __(@$content->data_values->heading) }}</h4>
                        <p class="text-white-dark2">{{ __(@$content->data_values->subheading) }}</p>
                        <form action="{{ route('user.register') }}" class="account-form log_frm1" method="post" onsubmit="return submitUserForm();" accept-charset="utf-8">
                            @csrf
                            <div class="form-group">
                                <label class="form-control-label">@lang('First Name')</label>
                                <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required placeholder="@lang('First Name')">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">@lang('Last Name')</label>
                                <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required placeholder="@lang('Last Name')">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">@lang('Email Address')</label>
                                <input class="form-control checkUser" id="email" name="email" required type="email" value="{{ old('email') }}" placeholder="@lang('Email Address')">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">@lang('Password')</label>
                                <div class="position-relative">
                                    <input class="form-control  @if (gs('secure_password')) secure-password @endif" id="password" name="password" required type="password" placeholder="@lang('Enter Password')">
                                    <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">@lang('Confirm Password')</label>
                                <div class="position-relative">
                                    <input class="form-control" id="password_confirmation" name="password_confirmation" required type="password" placeholder="@lang('Enter Password Again')">
                                    <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password_confirmation"></div>
                                </div>
                            </div>

                            @if (gs('agree'))
                                <div class="form-group d-flex align-items-center justify-content-start">
                                    <input @checked(old('agree')) class="form-check-input" id="agree"
                                        name="agree" required type="checkbox">
                                    <label class="form-check-label" for="agree">@lang('I agree with')</label>
                                    @foreach ($policyElements as $policy)
                                        <a class="link" href="{{ route('policy.pages', $policy->slug) }}"
                                            target="_blank">{{ __($policy->data_values->title) }}</a>
                                        @if (!$loop->last)
                                            ,&nbsp;
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <x-captcha :path="$activeTemplate . 'partials.'" />

                            <div class="form-group text-center">
                                <button class="orng_btn1 btn btn--base-two w-100" id="recaptcha" type="submit">@lang('Register Now')</button>
                            </div>
                             
                            <p class="log_tx2">@lang('Already have an account?')<a class="link" href="{{ route('user.login') }}">@lang('Login')</a></p>
                            <p class="log_tx2">@lang('Forgot your password?')<a class="forgot" href="{{ route('user.password.request') }}"> @lang('Reset Now')</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="custom--modal order-modal modal fade"
        id="existModalCenter" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i></button>
                <div class="modal-body text-center">
                    <h4 class="notice-text">@lang('You are with us')</h4>
                    @lang('You already have an account please Login')
                    <div class="buttons">
                        <a class="btn btn--xm btn--base mt-2" href="{{ route('user.login') }}">@lang('Login')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif


@push('script')
    <script>
        "use strict";
        (function($) {

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                var data = {
                    email: value,
                    _token: token
                }

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .custom--modal .modal-body .notice-text {
            margin-bottom: 18px;
        }
    </style>
@endpush
