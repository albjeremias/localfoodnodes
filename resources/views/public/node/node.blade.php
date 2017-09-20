@extends('public.layout')

@section('title', $node->name)

@section('content')
    <div class="header">
        <div class="top">
            <div class="d-flex justify-content-between">
                <div>
                    <h1>{{ $node->name }}</h1>
                    <div class="hidden-xl-up">
                        {{ trans_choice('public/weekdays.' . $node->delivery_weekday, 2) }} {{ $node->delivery_time }}
                        {{ $node->getDeliveryIntervalAsString() }}
                    </div>
                    <div>{{ $node->address }} {{ $node->zip }} {{ $node->city }}</div>
                </div>
                <div class="col-12 col-xl-5 hidden-lg-down text-right">
                    <h1>{{ trans_choice('public/weekdays.' . $node->delivery_weekday, 2) }} {{ $node->delivery_time }}</h1>
                    <div>{{ $node->getDeliveryIntervalAsString() }}</div>
                </div>
            </div>
        </div>
        <div id="map"></div>
    </div>

    <div class="container top-container">
        <div class="row">
            <div class="col-12 col-lg-8">

                <!-- Products -->
                <div class="card">
                    <div class="card-header">
                        {{ trans('public/node.products') }}

                        @if (Request::has('date'))
                            <a class="badge" href="{{ $node->permalink()->url }}">{{ trans('public/node.switch_product_view') }}</a>
                        @else
                            <a class="badge" href="{{ $node->permalink()->url }}?date={{ $node->getDeliveryDates()->first() }}">{{ trans('public/node.switch_weekly_view') }}</a>
                        @endif
                    </div>

                    <div class="card-block product-filter date-filter">
                        <div class="tags dates">
                            @foreach ($node->getDeliveryDates() as $deliveryDate)
                                @if (Request::input('date') === $deliveryDate)
                                    <div class="date text-center active">
                                        <a href="{{ $node->permalink()->url }}?date={{ $deliveryDate }}" class="badge active">{{ $deliveryDate }}</a>
                                    </div>
                                @else
                                    <div class="date text-center">
                                        <a href="{{ $node->permalink()->url }}?date={{ $deliveryDate }}" class="badge">{{ $deliveryDate }}</a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <script>
                            $('.date-filter .dates').hide();
                            $(document).ready(function() {
                                var activeIndex = parseInt($('.date-filter .dates .active').index());
                                var centeredIndex = activeIndex - 2; // Moves active item to center of slide
                                var centeredIndex = centeredIndex < 0 ? 0 : centeredIndex;

                                $('.date-filter .dates').slick({
                                  arrows: true,
                                  infinite: false,
                                  initialSlide: centeredIndex,
                                  nextArrow: '<i class="fa fa-chevron-right slick-nav slick-next"></i>',
                                  prevArrow: '<i class="fa fa-chevron-left slick-nav slick-prev"></i>',
                                  slidesToScroll: 5,
                                  slidesToShow: 5,
                                  responsive: [{
                                    breakpoint: 576,
                                    settings: {
                                      slidesToShow: 3,
                                      slidesToScroll: 3,
                                    }
                                  }]
                                });
                                $('.date-filter .dates').show();
                            });
                        </script>
                    </div>

                    <div class="card-block product-filter tag-filter">
                        <div class="tags">
                            @foreach ($tags as $label => $tag)
                                @if ($tag['active'])
                                    <a href="{{ $tag['url'] }}" class="badge active">{{ $label }}</a>
                                @else
                                    <a href="{{ $tag['url'] }}" class="badge">{{ $label }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @if ($products->count() > 0)
                        @if (Request::has('date'))
                            @include('public.node.product-weekly-view')
                        @else
                            @include('public.node.product-default-view')
                        @endif
                    @else
                        <div class="card-block">
                            {{ trans('public/node.no_products') }}
                        </div>
                    @endif
                </div> <!-- Product end -->

                <!-- Events -->
                @if ($events->count() > 0)
                    <div class="events row no-gutters">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        {{ trans('public/node.events') }}
                                        @if (Request::has('date'))
                                            - {{ Request::get('date') }} <a href="{{ $node->permalink()->url }}"><i class="fa fa-times-circle"></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-block">
                                    @foreach ($events as $event)
                                        @include('public.components.event')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">{{ $node->name }}</div>
                    <div class="card-block">
                        {!! $node->info !!}
                        <div class="row">
                            <div class="col-12">
                                <div class="fb-share-button" data-href="{{ $_SERVER['REQUEST_URI'] }}" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">{{ trans('public/node.share') }}</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">{{ trans('public/node.info') }}</div>
                    <div class="card-block node-metrics">
                        <div class="row">
                            <div class="metric col-4">
                                <div class="value">{{ $node->userLinks()->count() }}</div>
                                <div class="label">{{ trans('public/node.locals') }}</div>
                            </div>
                            <div class="metric col-4">
                                <div class="value">{{ $node->producerLinks()->count() }}</div>
                                <div class="label">{{ trans('public/node.producers') }}</div>
                            </div>
                            <div class="metric col-4">
                                <div class="value">{{ $node->getAverageProducerDistance() }}km</div>
                                <div class="label">{!! trans('public/node.avg_dist') !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <p>
                            <b>{{ trans('public/node.pick_up_order') }}</b><br>
                            {{ $node->address }} {{ $node->zip }} {{ $node->city }}<br>
                            {{ trans_choice('public/weekdays.' . $node->delivery_weekday, 2) }} {{ $node->delivery_time }}
                        </p>
                        <p>
                            <a href="{{ $node->link_facebook }}" target="_blank">{{ trans('public/node.find_communication') }}</a>
                            @if ($node->link_facebook_producers)
                                <br><a href="{{ $node->link_facebook_producers }}" target="_blank">{{ trans('public/node.find_producer_communication') }}</a>
                            @endif
                        </p>

                        @if ($node->email)
                            <p>{{ trans('public/node.contact') }} <a href="mailto:{{ $node->email }}">{{ $node->email }}</a></p>
                        @endif
                    </div>
                    @if (Auth::check())
                        <div class="card-footer">
                            @if ($user->isAddedToNode($node->id))
                                <a class="btn btn-success w-100" href="/account/user/node/{{ $node->id }}">{{ trans('public/node.leave') }}</a>
                            @else
                                <a class="btn btn-success w-100" href="/account/user/node/{{ $node->id }}">{{ trans('public/node.join') }}</a>
                            @endif
                        </div>
                    @endif
                </div>

                @if (isset($calendar))
                    <div class="card">
                        <div class="calendar node-calendar">
                            <div class="calendar-nav">
                                <i class="fa fa-chevron-left calendar-nav-item" id="calendar-nav-prev"></i>
                                <i class="fa fa-chevron-right calendar-nav-item" id="calendar-nav-next"></i>
                            </div>
                            @foreach ($calendar as $monthDate => $month)
                                <div class="month {{ $calendarMonth !== $monthDate ? 'hidden' : '' }}">
                                    <div class="month-header">{{ trans('public/node.calendar') }} - {{ date('F Y', strtotime($monthDate)) }}</div>
                                    <div class="days">
                                        @for ($i = 0; $i < $month['offsetStart']; $i++)
                                            <div class="day disabled"></div>
                                        @endfor

                                        @if ($month['days'])
                                            @foreach ($month['days'] as $dayDate => $dayData)
                                                @if (!empty($dayData['events']))
                                                    <a href="{{ $dayData['url'] }}" class="{{ join(' ', $dayData['activities']) }}">
                                                        <div class="date">{{ date('j', strtotime($dayDate)) }}</div>
                                                    </a>
                                                @else
                                                    <div class="day">
                                                        <div class="date">{{ date('j', strtotime($dayDate)) }}</div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                        @for ($i = 0; $i < $month['offsetEnd']; $i++)
                                            <div class="day disabled"></div>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-block">
                            <div class="calendar-explanation">
                                <p><i class="fa fa-square text-success"></i> {{ trans('public/node.pickup') }}</p>
                                <p><i class="fa fa-square text-event"></i> {{ trans('public/node.event') }}</p>
                            </div>
                        </div>
                    </div> <!-- Calendar end -->
                @endif

                <!-- Node images -->
                @if ($node->images()->count() > 0)
                    <div class="card image-card">
                        <div class="card-header">{{ trans('public/node.images') }}</div>
                        <div class="images slick-slider-wrapper">
                            @foreach ($node->images() as $image)
                                <a data-fancybox="gallery" href="{{ $image->url('medium') }}">
                                    <img class="card-image-bottom" src="{{ $image->url('small') }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Producer -->
                @if ($node->producerLinks()->count() > 0)
                    <div class="card">
                        <div class="card-header">{{ trans('public/node.producers') }}</div>
                        <div class="card-block">
                            <div class="producers">
                                @foreach ($node->producerLinks() as $producerLink)
                                    <div class="producer">
                                        <a href="{{ $producerLink->getProducer()->permalink()->url }}">{{ $producerLink->getProducer()->name }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div> <!-- Sidebar end -->
        </div>
    </div>

    @include('public.components.header-map', [
        'lat' => $node->location['lat'],
        'lng' => $node->location['lng']
    ])

    <script>
        jQuery(document).ready(function() {
            $('.calendar-nav-item').on('click', function(event) {
                if ($(this).hasClass('disabled')) {
                    return;
                }

                var $current = $('.calendar').find('.month:visible');

                if ($(this).is('#calendar-nav-prev')) {
                    var $requested = $current.prev('.month');
                } else {
                    var $requested = $current.next('.month');
                }

                $current.addClass('hidden');
                $requested.removeClass('hidden');

                updateNavigation($requested);
            });
        });

        function updateNavigation($current) {
            $prev = $current.prev('.month');
            $next = $current.next('.month');

            if ($prev.length === 0) {
                $('#calendar-nav-prev').addClass('disabled');
            } else {
                $('#calendar-nav-prev').removeClass('disabled');
            }

            if ($next.length === 0) {
                $('#calendar-nav-next').addClass('disabled');
            } else {
                $('#calendar-nav-next').removeClass('disabled');
            }
        }

        updateNavigation($('.calendar').find('.month:visible'));
    </script>
@endsection

@section('modal')
    @if (Session::has('added_to_cart_modal'))
        <div class="modal fade" id="added-to-cart-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body body-text">
                        <div class="row">
                            <div class="col-6">
                                <a href="#" class="choice continue-shopping" data-dismiss="modal">{{ trans('public/checkout.continue_shopping') }}</a>
                            </div>
                            <div class="col-6">
                                <a href="/checkout" class="choice go-to-checkout">{{ trans('public/checkout.go_to_checkout') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#added-to-cart-modal').modal('show');
        </script>
    @endif
@endsection
