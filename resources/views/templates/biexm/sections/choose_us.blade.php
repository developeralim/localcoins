@php
    $content = getContent('choose_us.content', true);
    $elements = getContent('choose_us.element', orderById: true);
@endphp
<section class="section-bg py-2 why_choose">
    <div class="container-fluid">

        <div class="row news-section mt-3">
            <div class="col-md-12 col-lg-12 mb-4">
                <h4 class="text-center">{!! __(@$content->data_values->heading) !!}</h4>
            </div>

            @foreach ($elements as $element)
                <div class="col-sm-6 col-lg-3 mb-3 mb-sm-8">
                    <article class="card h-100">
                        <div class="card-img-top position-relative">
                            <img class="card-img-top" src="{{ frontendImage('choose_us' , @$element->data_values->image, '469x244') }}">
                        </div>
                        <div class="card-body">
                            <h5 style="font-weight: bold;font-size:15px;">{!! __($element->data_values->heading) !!}</h5>
                            <p style="font-size: 14px">{!! __($element->data_values->details) !!}</p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
