@extends($activeTemplate . 'layouts.frontend')
<div class="section section-bg pt-5 pb-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="filter-singular py-5">
                    @include($activeTemplate . 'sections.ads_filter_form',[
                        'buy' => true
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section section-bg pb-2">
    <div class="container">
        <div class="row">
            <div class="col-12 py-5">
                <h3 class="fw-bold mb-3">Results for buying BTC online in </h3>
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
        </div>
    </div>
</div>
@push('script')
    <script>
        const buyBTCIn = $('#buy_btc_in').dataTable({
            "oLanguage": { 
                "sEmptyTable": "No offers available, please change your payment method or country",
            },
            // "language": {
            //     "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/"+langs+".json"
            // },
            serverSide:true,
            processing:true,
            "columns" : [
                {name:'user',data:'user'},
                {name:'payment_method',data:'payment_method'},
                {name:'price_or_btc',data:'price_or_btc'},
                {name:'limits',data:'limits'},
                {name:'actions',data:'actions'},
            ]
        });
    </script>
@endpush 