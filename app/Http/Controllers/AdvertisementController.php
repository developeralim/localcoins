<?php

namespace App\Http\Controllers;

use App\Models\CryptoCurrency;
use App\Models\FiatCurrency;
use App\Models\FiatGateway;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdvertisementController extends Controller
{

    // public function allAds($type, $crypto, $country = null, $gateway = null, $currency = null, $amount = null)
    // {
    //     $cryptoCurrency = CryptoCurrency::where('code', $crypto)->active()->firstOrFail();
    //     $query          = adsQuery($cryptoCurrency->id, $type == 'buy' ? 2 : 1);
    //     $request        = request();

    //     if ($gateway && $gateway != 'all') {
    //         $fiatGatewayCheck = FiatGateway::where('slug', $gateway)->active()->firstOrFail();
    //         $query->where('advertisements.fiat_gateway_id', $fiatGatewayCheck->id);
    //     }

    //     if ($currency && $currency != 'all') {
    //         $fiatCheck = FiatCurrency::where('code', $currency)->active()->firstOrFail();
    //         $query->where('advertisements.fiat_currency_id', $fiatCheck->id);
    //     }

    //     if ($country && $country != 'all') {
    //         $query->whereHas('user', function ($q) use ($country) {
    //             $q->active()->where('country_code', $country);
    //         });
    //     }

    //     if ($amount) {
    //         $query->where('advertisements.min', '<=', $amount)->where('advertisements.max', '>=', $amount);
    //     }

    //     if (request()->ajax()) {
    //         $totalAds = (clone $query)->count();
    //         $ads      = $query->orderBy('advertisements.id', 'desc')->skip(request()->skip ?? 0)->limit(request()->take ?? 6)->get();
    //         $html     = view("Template::advertisement.$type", compact('ads'))->render();

    //         return response()->json(
    //             [
    //                 'success' => true,
    //                 'html'    => $html,
    //                 'total'   => $totalAds
    //             ]
    //         );
    //     }

    //     $advertisements = $query->with('user')->orderBy('advertisements.id', 'desc')->paginate(getPaginate());
    //     $cryptos        = CryptoCurrency::active()->orderBy('name')->get();
    //     $countries      = json_decode(file_get_contents(resource_path('views/partials/country.json')));
    //     $fiatGateways   = FiatGateway::getGateways();
    //     $pageTitle      = ucfirst($type) . ' ' . $cryptoCurrency->name;

    //     return view('Template::advertisement.all', compact('pageTitle', 'advertisements', 'type', 'crypto', 'cryptos', 'fiatGateways', 'countries','request'));
    // }

    public function cryptoAdvertisements( Request $request,string $type )
    {
        if ( $request->ajax() ) {
            $crypto   = CryptoCurrency::where('code', $request->crypto)->active()->firstOrFail();
            $gateway  = FiatGateway::where('slug', $request->fiat_gateway)->active()->firstOrFail();
            $currency = FiatCurrency::where('code', $request->fiat_currency)->active()->firstOrFail();

            $query  = adsQuery($crypto->id,$type == 'sell' ? 1 : 2)->when( $request->fiat_gateway != 'all' ,function($query) use($gateway){
                $query->where('advertisements.fiat_gateway_id', $gateway->id);
            })->when( $currency != 'all',function( $query ) use($currency){
                $query->where('advertisements.fiat_currency_id', $currency->id);
            })->when( $request->location != 'all',function( $query ) use( $request ){
                $query->whereHas('user', function ($q) use ( $request ) {
                    $q->active()->where('country_code', $request->location);
                });
            })->when($request->amount,function( $query ) use($request){
                $query->where('advertisements.min', '<=', $request->amount)->where('advertisements.max', '>=', $request->amount);
            });

            return DataTables::of( $query )
                ->addIndexColumn()
                ->addColumn('user',function($ad){
                    return sprintf(
                        '
                            <a href="%1%s" class="blu_tx1">BTC_Trade (%2$d; %3$d%)</a>
                            <span class="onlineSts stsOffline " data-toggle="tooltip" data-placement="top" title="" data-original-title="%4$s"></span>
                        ',
                        route('public.profile', $ad->username),
                        $ad->total_trade,
                        getAmount( $ad->total_trade > 0 ? (($ad->trade_requests_count/$ad->total_trade)*100) : 0),
                        __("Typically takes more than 30 minutes to reply")
                    );
                })
                ->addColumn('payment_method',function($ad){
                    return __($ad->gateway_name);
                })
                ->addColumn('price_or_btc',function($ad){
                    return (float) $ad->rate_value . __($ad->fiat_code) ."/". __($ad->crypto_code);
                })
                ->addColumn('limits',function($ad){
                    return showAmount($ad->min) ." - ". showAmount($ad->max) ." ". __($ad->fiat_code);
                })
                ->addColumn('actions',function($ad){
                    return 'hello';
                })
                ->rawColumns(['user','payment_method','limits','actions','price_or_btc'])
                ->make(true);
        }
        $pageTitle  = ucfirst($type) . __(" Ads");
        return view("Template::advertisement.{$type}",compact('pageTitle'));
    }
}
