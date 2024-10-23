@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('login.content', true);
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
                        <form action="{{ route('user.login') }}" class="account-form log_frm1" method="post" onsubmit="return submitUserForm();" accept-charset="utf-8">
                            @csrf
                            <div class="form-group">
                                <label class="form-control-label">@lang('Username or Email')</label>
                                <input class="form-control" placeholder="@lang('Enter Username or Email')" name="username" required type="text" value="{{ old('username') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">@lang('Password')</label>
                                <div class="position-relative">
                                    <input class="form-control" placeholder="@lang('Enter Password')" id="password" name="password" required type="password">
                                    <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></div>
                                </div>
                            </div>
                            <x-captcha :path="$activeTemplate . 'partials.'" />
                            <div class="form-group text-center">
                                <button class="orng_btn1 btn btn--base-two w-100" id="recaptcha" type="submit">@lang('Login Now')</button>
                            </div>
                        
                            <p class="log_tx2">@lang('Don\'t have an account?')<a class="link" href="{{ route('user.register') }}">@lang('Create Now')</a></p>
                            <p class="log_tx2">@lang('Forgot your password?')<a class="forgot" href="{{ route('user.password.request') }}"> @lang('Reset Now')</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
