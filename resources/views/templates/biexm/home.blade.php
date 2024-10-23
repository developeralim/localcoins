@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @if ($sections && $sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif
            $('select[name=country]').change(function() {
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            }).change();
            $('#fiat-gateway').on('change', function() {
                var fiats = $(this).find('option:selected').data('fiat');
                var html = ``;
                if (fiats && fiats.length > 0) {
                    $.each(fiats, function(i, v) {
                        html += `<option value="${v.code}">${v.code}</option>`;
                    });
                } else {
                    html = `<option value="">@lang('Select Fiat Currency')</option>`;
                }
                $('.fiat-currency').html(html);
            }).change();
        })(jQuery)
    </script>
@endpush
