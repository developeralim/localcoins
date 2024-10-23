<section class="section-bg py-5">
    <div class="container">
        <form class="crypto-sele-cls">
            <h4>Select Cryptocurrency Type</h4>
            <div class="select_style1">
                <select name="search" id="search" aria-invalid="false" class="valid" autocomplete="off">
                    <option value="">Select Crypto</option>
                    @foreach ($cryptos as $crypto)
                        <option @if (request('search') == $crypto->code ) selected @endif value="{{ $crypto->code }}">{{ $crypto->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        <div class="row">
            <div class="col-12 py-5">
                <h3 class="fw-bold mb-3">Buy BTC online in </h3>
                <div class="card datatable-card">
                    <div class="card-body">
                        <div class="cm_tabled1 table-responsive">
                            <table class="table" id="buy_btc_in">
                                <thead>
                                    <tr>
                                        <th>Seller</th>
                                        <th>Payment Method</th>
                                        <th>Price/BTC</th>
                                        <th>Limits</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 py-5">
                <h3 class="fw-bold mb-3">Sell BTC online in </h3>
                <div class="card datatable-card">
                    <div class="card-body">
                        <div class="cm_tabled1 table-responsive">
                            <table class="table" id="sell_btc_in">
                                <thead>
                                    <tr>
                                        <th>Buyer</th>
                                        <th>Payment Method</th>
                                        <th>Price/BTC</th>
                                        <th>Limits</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('script')
    <script>
        $('select[name="search"]').change(function(){
            if ( $(this).val() != "" ) {
                $('.crypto-sele-cls').submit();
            }
        });

        const sellBTCIn = $('#sell_btc_in').dataTable({
            "oLanguage": { 
                "sEmptyTable": "No offers available, please change your payment method or country",
            },
            // "language": {
            //     "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/"+langs+".json"
            // }
        });

        const buyBTCIn = $('#buy_btc_in').dataTable({
            "oLanguage": { 
                "sEmptyTable": "No offers available, please change your payment method or country",
            },
            // "language": {
            //     "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/"+langs+".json"
            // }
        });
    </script>
@endpush