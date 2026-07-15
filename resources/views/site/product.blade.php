<x-layouts.site :title="$product->name">
    <p class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> /
        <a href="{{ route('category.show', $product->category) }}">{{ $product->category->name }}</a> /
        {{ $product->name }}
    </p>

    @php
        $ratingCount = $product->reviewsCount();
        $ratingAvg = $ratingCount > 0 ? $product->averageRating() : 0;
        [$priceWhole, $priceFrac] = explode('.', number_format($product->sale_price, 2, '.', ''));
        $deliveryDate = now()->addDays(4);
    @endphp

    <div class="pdp">
        {{-- Gallery --}}
        <div class="pdp-gallery">
            @if ($product->thumbnail || $product->images->isNotEmpty())
                <div class="pdp-thumbs">
                    @if ($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                            class="pdp-thumb active" onmouseover="document.getElementById('main-image').src = this.src"
                            onclick="document.getElementById('main-image').src = this.src">
                    @endif
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                            class="pdp-thumb" onmouseover="document.getElementById('main-image').src = this.src"
                            onclick="document.getElementById('main-image').src = this.src">
                    @endforeach
                </div>
            @endif

            <div class="pdp-main">
                @if ($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                        class="pdp-main-image" id="main-image">
                @else
                    <div class="pdp-main-image"></div>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div class="pdp-info">
            <a href="{{ route('category.show', $product->category) }}" class="pdp-category">{{ $product->category->name }}</a>
            <h1 class="pdp-title">{{ $product->name }}</h1>

            @if ($ratingCount > 0)
                <a href="#reviews" class="pdp-rating">
                    @include('site.partials._stars', ['rating' => $ratingAvg])
                    <span class="pdp-rating-value">{{ number_format($ratingAvg, 1) }}</span>
                    <span class="pdp-rating-count">{{ number_format($ratingCount) }} {{ Str::plural('rating', $ratingCount) }}</span>
                </a>
            @endif

            <hr class="pdp-divider">

            <div class="pdp-price-block">
                <div class="pdp-price">
                    @if ($product->discountPercentage() > 0)
                        <span class="pdp-price-off">-{{ $product->discountPercentage() }}%</span>
                    @endif
                    <span class="price price-lg">
                        <span class="price-cur">₹</span><span class="price-whole">{{ number_format((int) $priceWhole) }}</span><span class="price-frac">{{ $priceFrac }}</span>
                    </span>
                </div>
                @if ($product->discountPercentage() > 0)
                    <p class="pdp-mrp">M.R.P: <span class="strike">₹{{ number_format($product->mrp, 2) }}</span></p>
                @endif
                <p class="pdp-tax-note">Inclusive of all taxes</p>
            </div>

            @if ($product->description)
                <hr class="pdp-divider">
                <h2 class="pdp-section-heading">About this item</h2>
                <div class="pdp-description rich-content">{!! $product->description !!}</div>
            @endif
        </div>

        {{-- Buy box --}}
        <aside class="pdp-buybox">
            <div class="buybox {{ $product->stock > 0 ? 'product-detail-purchase' : '' }}"
                @if ($product->stock > 0) data-product-id="{{ $product->id }}" data-product-stock="{{ $product->stock }}" @endif>

                <div class="buybox-price">
                    <span class="price price-lg">
                        <span class="price-cur">₹</span><span class="price-whole">{{ number_format((int) $priceWhole) }}</span><span class="price-frac">{{ $priceFrac }}</span>
                    </span>
                </div>

                <div class="buybox-delivery">
                    <p><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        <span><strong>FREE delivery</strong> {{ $deliveryDate->format('l, d M') }}</span></p>
                    <p><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                        <span>Easy 7-day returns &amp; exchange</span></p>
                </div>

                @if ($product->stock > 0)
                    <p class="buybox-stock in-stock">In stock</p>

                    <div class="qty-stepper">
                        <button type="button" class="qty-btn" data-action="qty-decrease" aria-label="Decrease quantity">&minus;</button>
                        <input type="text" class="qty-input" id="quantity" value="1" inputmode="numeric" aria-label="Quantity">
                        <button type="button" class="qty-btn" data-action="qty-increase" aria-label="Increase quantity">+</button>
                    </div>

                    <button type="button" class="btn btn-primary btn-lg btn-pill add-to-cart-btn" data-product-name="{{ $product->name }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Add to Cart
                    </button>
                    <button type="button" class="btn btn-buy-now btn-lg btn-pill buy-now-btn" data-product-name="{{ $product->name }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Buy Now
                    </button>
                @else
                    <p class="buybox-stock out-of-stock">Currently unavailable</p>
                @endif

                <p class="buybox-secure">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Secure transaction
                </p>

                @php $inWishlist = \App\Support\Wishlist::has($product->id); @endphp
                <button type="button" class="btn btn-outline btn-pill wishlist-btn-detail {{ $inWishlist ? 'active' : '' }}"
                    data-action="toggle-wishlist" data-product-id="{{ $product->id }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    <span class="wishlist-btn-label">{{ $inWishlist ? 'In Wishlist' : 'Add to Wishlist' }}</span>
                </button>
            </div>
        </aside>
    </div>

    @if ($product->specifications->isNotEmpty())
        <section class="card card-flush pdp-panel">
            <div class="card-header"><h2 class="card-title">Product details</h2></div>
            <div class="table-wrap" style="box-shadow: none;">
                <table class="spec-table">
                    <tbody>
                        @foreach ($product->specifications as $spec)
                            <tr>
                                <th>{{ $spec->key }}</th>
                                <td>{{ $spec->value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif

    <section class="card card-flush pdp-panel" id="reviews">
        <div class="card-header"><h2 class="card-title">Ratings &amp; Reviews</h2></div>
        <div class="card-body">
        @if ($ratingCount > 0)
            @php $avgRounded = round($ratingAvg); @endphp
            <div class="review-summary">
                <div class="review-summary-score">
                    <span class="review-summary-number">{{ number_format($ratingAvg, 1) }}</span>
                    <span class="rating-stars rating-stars-lg">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $avgRounded ? 'star-filled' : 'star-empty' }}">&#9733;</span>
                        @endfor
                    </span>
                    <span class="review-summary-count">{{ $ratingCount }} {{ Str::plural('review', $ratingCount) }}</span>
                </div>

                <div class="review-summary-bars">
                    @for ($star = 5; $star >= 1; $star--)
                        @php $starCount = $product->approvedReviews->where('rating', $star)->count(); @endphp
                        <div class="review-summary-bar-row">
                            <span class="review-summary-bar-label">{{ $star }}&#9733;</span>
                            <span class="review-summary-bar-track">
                                <span class="review-summary-bar-fill" style="width: {{ $ratingCount ? round(($starCount / $ratingCount) * 100) : 0 }}%"></span>
                            </span>
                            <span class="review-summary-bar-count">{{ $starCount }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        @endif

        @if ($product->approvedReviews->isNotEmpty())
            <div class="review-list">
                @foreach ($product->approvedReviews as $review)
                    <div class="review-item">
                        <div class="review-item-avatar">{{ Str::of($review->user->name)->substr(0, 1)->upper() }}</div>
                        <div class="review-item-body">
                            <div class="review-item-header">
                                <strong>{{ $review->user->name }}</strong>
                                <span class="review-item-date">{{ $review->created_at->format('d M Y') }}</span>
                            </div>
                            <span class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">&#9733;</span>
                                @endfor
                            </span>
                            <p class="review-item-comment">{{ $review->comment }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="muted">No reviews yet. Be the first to share your thoughts!</p>
        @endif

        @if (session('status'))
            <div class="alert alert-success"><p>{{ session('status') }}</p></div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @auth
            @if ($canReview)
                <div class="review-form-box">
                    <h3 class="review-form-title">Write a Review</h3>
                    <form method="POST" action="{{ route('reviews.store', $product) }}" class="review-form">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Your Rating</label>
                            <div class="star-rating-input">
                                <input type="radio" id="star5" name="rating" value="5" required {{ old('rating') == 5 ? 'checked' : '' }}>
                                <label for="star5" title="5 stars">&#9733;</label>
                                <input type="radio" id="star4" name="rating" value="4" {{ old('rating') == 4 ? 'checked' : '' }}>
                                <label for="star4" title="4 stars">&#9733;</label>
                                <input type="radio" id="star3" name="rating" value="3" {{ old('rating') == 3 ? 'checked' : '' }}>
                                <label for="star3" title="3 stars">&#9733;</label>
                                <input type="radio" id="star2" name="rating" value="2" {{ old('rating') == 2 ? 'checked' : '' }}>
                                <label for="star2" title="2 stars">&#9733;</label>
                                <input type="radio" id="star1" name="rating" value="1" {{ old('rating') == 1 ? 'checked' : '' }}>
                                <label for="star1" title="1 star">&#9733;</label>
                            </div>
                            @error('rating')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="comment" class="form-label">Your Review</label>
                            <textarea id="comment" name="comment" rows="4" class="form-control" required placeholder="Share your experience with this product&hellip;">{{ old('comment') }}</textarea>
                            @error('comment')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            @elseif ($alreadyReviewed)
                <p class="muted">You've already reviewed this product. Thank you!</p>
            @else
                <p class="muted">Only customers who have received this product can leave a review.</p>
            @endif
        @else
            <p class="muted"><a href="{{ route('login') }}">Log in</a> to write a review.</p>
        @endauth
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="related-products-section">
            <h2 class="page-title">Related Products</h2>
            <div class="product-grid">
                @foreach ($relatedProducts as $relatedProduct)
                    @include('site.partials._product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </section>
    @endif

    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/wishlist.js') }}"></script>
</x-layouts.site>
