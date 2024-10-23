@php
    $cryptos = App\Models\CryptoCurrency::active()->orderBy('name')->get();
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();

    $user = auth()->user();

    if (gs('multi_language')) {
        $language = App\Models\Language::all();
        $localLang = $language->where('code', config('app.locale'))->first();
    }
@endphp
 
<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg tp_header cbp-af-header">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img alt="" src="{{ siteLogo() }}"></a>
            <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler header-button" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" type="button">
                <span id="hiddenNav"><i class="fa fa-bars"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav tp_nav2">
                    <li class="nav-item dropdown buy-dropdown mtb-md-2">
                        <a aria-expanded="false" class="nav-link" data-bs-toggle="dropdown" href="javascript:void(0)" role="button">
                            @lang('Buy') <span class="nav-item__icon"><i class="fas fa-caret-down"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($cryptos as $crypto)
                                <li class="dropdown-menu__list">
                                    <a class="dropdown-item dropdown-menu__link" href="{{ route('advertisement.crypto', ['buy', $crypto->code, 'all']) }}">{{ $crypto->code }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown buy-dropdown mtb-md-2">
                        <a aria-expanded="false" class="nav-link" data-bs-toggle="dropdown" href="#" role="button">@lang('Sell')<span class="nav-item__icon mx-1"><i class="fas fa-caret-down"></i></span></a>
                        <ul class="dropdown-menu">
                            @foreach ($cryptos as $crypto)
                                <li class="dropdown-menu__list">
                                    <a class="dropdown-item dropdown-menu__link" href="{{ route('advertisement.crypto', ['sell', $crypto->code, 'all']) }}">{{ $crypto->code }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a aria-current="page" class="nav-link" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link" data-bs-toggle="dropdown" href="#" role="button">@lang('Trades')<span class="nav-item__icon mx-1"><i class="fas fa-caret-down"></i></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu__list">
                                <a class="dropdown-item dropdown-menu__link" href="{{ route('user.trade.request.running') }}">@lang('Running')</a>
                            </li>
                            <li class="dropdown-menu__list">
                                <a class="dropdown-item dropdown-menu__link" href="{{ route('user.trade.request.completed') }}">@lang('Completed')</a>
                            </li>
                        </ul>
                    </li>
                    @foreach ($pages as $k => $data)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                        </li>
                    @endforeach

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center flex-row tp_nav2 ml-auto">
					@if ( ! $user )
                        <li class="nav-item tp_logb1 ml-lg-3">
                            <a href="{{ route('user.register') }}" class="nav-link">@lang('Register')</a>
                        </li>
                        <li class="nav-item tp_logb1 ml-lg-3">
                            <a class="nav-link active" href="{{ route('user.login') }}">@lang('Login')</a>
                        </li>
                    @endif	
                    @auth
                        <li class="nav-item tp_logb1 ml-lg-3">
                            <a class="nav-link active" href="{{ route('user.login') }}"><i class="fa-solid fa-wallet"></i> @lang('My Wallet')</a>
                        </li>
                        <li class="nav-item dropdown profile-dropdown">
                            <a aria-expanded="false" class="nav-link hover-link" data-bs-toggle="dropdown" href="javascript:void(0)" role="button">
                                <i class="fa-solid fa-user"></i> {{ ucfirst(auth()->user()->username) }} <span class="nav-item__icon"><i class="fas fa-caret-down"></i></span>
                            </a>
                            <ul class="dropdown-menu" style="width: 250px;right: 0 !important;left: auto;">
                                <li><a href="{{ route('ticket.index') }}"><i class="fa-solid fa-gauge mx-2"></i> @lang('Dashboard')</a></li>
                                <hr class="my-1">
                                <li><a href="{{ route('ticket.index') }}"><i class="fa-solid fa-headphones mx-2"></i> @lang('Support')</a></li>
                                <hr class="my-1">
                                <li><a href="{{ route('user.profile.setting') }}"><i class="fa-solid fa-pen-to-square mx-2"></i> @lang('Edit Profile')</a></li>
                                <hr class="my-1">
                                <li><a href="{{ route('user.twofactor') }}"><i class="fa-solid fa-shield mx-2"></i> @lang('2FA Security')</a></li>
                                <hr class="my-1">
                                <li><a href="{{ route('user.logout') }}"><i class="fa-solid fa-right-from-bracket mx-2"></i> @lang('Logout')</a></li>
                            </ul>
                        </li>
                    @endauth
					<li class="nav-item ml-4 themeToggler">
						<span class="sun themeLightIcon">
							<img src="{{asset('assets/images/theme-light.png')}}" alt="logo" class="img-fluid">
						</span>
						<span class="moon themeDarkIcon">
							<img src="{{asset('assets/images/theme-dark.png')}}" alt="logo" class="img-fluid">
						</span>
					</li>
				</ul>
            </div>
        </nav>
    </div>
</header>
