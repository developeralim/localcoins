@php
    $content = getContent('feature.content', true);
    $elements = getContent('feature.element', orderById: true);
@endphp
<section class="section-bg py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="sec-heading">
                    <h2 class="text-center font-700">Biexm Features</h2>
                    <p class="text-center mt-4">Select a payment method you like and trade directly with other people just like you</p>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            @foreach ($elements as $element)
                <div class="col-md-3">
                    <div class="features-box">
                        <img width="50px" src="{{ frontendImage('feature' , @$element->data_values->image, '30x30') }}">
                        <h4 class="mt-3">{!! __($element->data_values->title) !!}</h4>
                        <p>{!! __($element->data_values->description) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
