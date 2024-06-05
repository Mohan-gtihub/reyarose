<div class="container container-5xl">
        <div class="row">
            <div class="col-lg-5">
                <div class="product-gallery">
                    @if ($item->video)
                        <div class="gallery-wrapper">
                            <div class="gallery-item d-flex align-items-center shadow-sm bg-white rounded-pill px-6 py-4 video-btn text-center">
                                <a href="{{ $item->video }}" title="Watch video" class="product-video">
                                    <i class="text-danger fas fa-play"></i>
                                    <span class="ms-1 text-danger product-video">
                                        Play Video
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($item->previous_price && $item->previous_price != 0)
                        <div class="product-badge bg-success"> -{{ PriceHelper::DiscountPercentage($item) }}</div>
                    @endif
                    <div class="product-thumbnails insize">
                        <div class="product-details-slider owl-carousel">

                            @php
                                $photos = [];
                            @endphp
                            @if ($item->galleries != null)
                                @php
                                    $photos = explode(',', $item->galleries);
                                @endphp
                            @endif
                            @foreach ($photos as $key => $photo)
                                <div class="item">
                                    <img class="no-download" src="{{ uploaded_asset($photo) }}" alt="zoom" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @php
                function renderStarRating($rating, $maxRating = 5)
                {
                    $fullStar = "<i class = 'fas fa-star filled'></i>";
                    $halfStar = "<i class = 'fas fa-star-half filled'></i>";
                    $emptyStar = "<i class = 'far fa-star'></i>";
                    $rating = $rating <= $maxRating ? $rating : $maxRating;

                    $fullStarCount = (int) $rating;
                    $halfStarCount = ceil($rating) - $fullStarCount;
                    $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

                    $html = str_repeat($fullStar, $fullStarCount);
                    $html .= str_repeat($halfStar, $halfStarCount);
                    $html .= str_repeat($emptyStar, $emptyStarCount);
                    $html = $html;
                    return $html;
                }
            @endphp
            <div class="col-lg-7 mt-6 mt-lg-0 ps-lg-80 pe-lg-1">
                <input type="hidden" id="item_id" value="{{ $item->id }}">
                <input type="hidden" id="demo_price" value="{{ PriceHelper::setConvertPrice($item->discount_price) }}">
                <input type="hidden" value="{{ PriceHelper::setCurrencySign() }}" id="set_currency">
                <input type="hidden" value="{{ PriceHelper::setCurrencyValue() }}" id="set_currency_val">
                <input type="hidden" value="{{ $setting->currency_direction }}" id="currency_direction">
                <h3 class="text-dark fw-bold heading-h3 mb-0">{{ $item->name }}</h3>
                <div class="d-flex align-items-center mt-5">
                    <div class="d-flex rating-stars">
                        {!! renderStarRating($item->reviews->avg('rating')) !!}
                    </div>
                    <p class="text-danger mb-0 ms-6">({{ count($reviews) }} reviews)</p>
                </div>
                <h5 class="mt-7 mt-lg-9 mb-0 text-danger heading-h3 fw-semibold price-area">
                    <span id="main_price" class="main-price">{{ PriceHelper::grandCurrencyPrice($item) }}</span>
                    @if ($item->previous_price != 0)
                        <small class="d-inline-block"><del>{{ PriceHelper::setPreviousPrice($item->previous_price) }}</del></small>
                    @endif
                </h5>
                <div class="w-lg-100">
                    <div class="mt-7">
                        @foreach ($attributes as $attribute)
                            @if ($attribute->options->count() != 0)
                                <div class="mb-6 d-flex align-items-center justify-content-between">
                                    <label for="{{ $attribute->name }}" class="options-label left-titles">{{ $attribute->name }}</label>
                                    <span class="text-dark fs-16 ">:</span>
                                    <select class="form-control fs-16 attribute_option w-50" id="{{ $attribute->name }}">
                                        @foreach ($attribute->options->where('stock', '!=', '0') as $option)
                                            <option value="{{ $option->name }}" data-type="{{ $attribute->id }}" data-href="{{ $option->id }}"
                                                data-target="{{ PriceHelper::setConvertPrice($option->price) }}">
                                                {{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="d-flex align-items-center justify-content-cetner">
                        @if ($item->item_type == 'normal')
                            <div class="counter-container d-flex align-items-center justify-content-cetner bg-gray-100 px-3 py-2 w-fit">
                                <button class="counter-button border-0 bg-transparent decrement decreaseQty subclick" data-multiple="{{ $item->multiple }}">
                                    <i class="fas fa-minus fs-18 text-gray-700"></i>
                                </button>
                                <input type="text" class="border-0 cart-qty bg-transparent qtyValue " id="cart-qty" min="{{ $item->min_qty }}" value="{{ $item->min_qty }}">
                                <button class="counter-button border-0 bg-transparent increment increaseQty addclick" data-multiple="{{ $item->multiple }}">
                                    <i class="fas fa-plus fs-18 text-gray-700"></i>
                                </button>
                                <input type="hidden" value="3333" id="current_stock">
                            </div>
                        @endif
                        <div class="ms-2 ms-md-4 ms-lg-6 flex-grow-1">
                            @if ($item->is_stock())
                                <button class="btn px-6 py-4 border-0 text-white w-100 text-uppercase rounded rounded-lg-0 d-flex align-items-center justify-content-center btn-danger"
                                    id="add_to_cart"><span class="d-none d-md-block">Add to Cart</span><span class="d-block d-md-none"><i class="far fa-shopping-bag fs-24 text-white"></i></button>
                            @else
                                <button class="btn px-6 py-4 border-0 text-white text-uppercase rounded-0 d-flex align-items-center justify-content-center btn-danger" id="add_to_cart"
                                    disabled>{{ __('Out of stock') }}</button>
                            @endif
                        </div>
                        <div class="ms-2 ms-md-4 ms-lg-6">
                            <a class="btn btn-gray wishlist_store wishlist_text bg-gray-100 py-4 px-4" href="{{ route('user.wishlist.store', $item->id) }}"><i
                                    class="fa-regular fa-heart text-muted fs-24"></i></a>
                        </div>
                    </div>

                    <div class="my-12 my-lg-8 devider"></div>
                    <div class="line-sep1"></div>
                    <div class=" d-flex justify-content-between">
                        <span class="text-dark fs-16 left-titles"> Availability </span>
                        <span class="text-dark fs-16"> : </span>
                        @if ($item->is_stock())
                            <span class="text-success text-success fs-16 text-start w-50">{{ __('In Stock') }}</span>
                        @else
                            <span class="text-danger text-success fs-16 text-start w-50">{{ __('Out of stock') }}</span>
                        @endif
                    </div>
                    <div class="mt-5 d-flex justify-content-between">
                        <span class="text-dark fs-16 left-titles"> Dimensions </span>
                        <span class="text-dark fs-16 "> : </span>
                        <span class="text-muted fs-16 text-start  w-50">W {{number_format($item->breadth,1)}}” D {{number_format($item->length,1)}}” H {{number_format($item->height,1)}}” </span>
                    </div>
                    <div class="mt-5 d-flex justify-content-between">
                        <span class="text-dark fs-16 left-titles"> SKU </span>
                        <span class="text-dark fs-16"> : </span>
                        <span class="text-muted fs-16 text-start  w-50">{{ $item->sku }}</span>
                    </div>
                    <div class="line-sep2 mt-4 pt-4"></div>
                </div>

                <div class="mt-2">
                    <h5 class="fw-medium mb-4">DESCRIPTION</h5>
                    <p class="text-muted" style="text-align: justify;"> {{ $item->sort_details }}</p>
                </div>
                <style>
                    .left-titles {
                        width: 155px;
                        display: inline-block;
                    }
                </style>
                <div>
                </div>

            </div>
        </div>
    </div>
