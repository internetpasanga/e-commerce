<x-layouts.site :title="$product->name">
    <p class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> /
        <a href="{{ route('category.show', $product->category) }}">{{ $product->category->name }}</a> /
        {{ $product->name }}
    </p>

    <div class="product-detail">
        <div>
            @if ($product->thumbnail)
                <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->name }}"
                     class="product-detail-main-image" id="main-image">
            @else
                <div class="product-detail-main-image"></div>
            @endif

            @if ($product->images->isNotEmpty())
                <div class="product-detail-thumbs">
                    @if ($product->thumbnail)
                        <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->name }}"
                             onclick="document.getElementById('main-image').src = this.src">
                    @endif
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $product->name }}"
                             onclick="document.getElementById('main-image').src = this.src">
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <p class="product-detail-category">{{ $product->category->name }}</p>
            <h1 class="page-title" style="margin-bottom: 0;">{{ $product->name }}</h1>

            @if ($product->reviewsCount() > 0)
                <p class="rating-summary">
                    <span class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($product->averageRating()) ? 'star-filled' : 'star-empty' }}">&#9733;</span>
                        @endfor
                    </span>
                    {{ number_format($product->averageRating(), 1) }} ({{ $product->reviewsCount() }} {{ Str::plural('review', $product->reviewsCount()) }})
                </p>
            @endif

            <div class="price-row">
                <p class="product-detail-price">₹{{ number_format($product->sale_price, 2) }}</p>
                @if ($product->discountPercentage() > 0)
                    <p class="price-mrp">₹{{ number_format($product->mrp, 2) }}</p>
                    <span class="badge badge-success">{{ $product->discountPercentage() }}% OFF</span>
                @endif
            </div>

            @if ($product->stock > 0)
                <span class="stock-badge inline in-stock">In Stock</span>
            @else
                <span class="stock-badge inline out-of-stock">Out of Stock</span>
            @endif

            @php $inWishlist = \App\Support\Wishlist::has($product->id); @endphp
            <button type="button" class="wishlist-btn-detail {{ $inWishlist ? 'active' : '' }}"
                    data-action="toggle-wishlist" data-product-id="{{ $product->id }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <span class="wishlist-btn-label">{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}</span>
            </button>

            @if ($product->stock > 0)
                <div class="product-detail-purchase" data-product-id="{{ $product->id }}" data-product-stock="{{ $product->stock }}">
                    <div class="qty-stepper">
                        <button type="button" class="qty-btn" data-action="qty-decrease" aria-label="Decrease quantity">&minus;</button>
                        <input type="text" class="qty-input" id="quantity" value="1" inputmode="numeric" aria-label="Quantity">
                        <button type="button" class="qty-btn" data-action="qty-increase" aria-label="Increase quantity">+</button>
                    </div>

                    <div class="product-detail-actions">
                        <button type="button" class="btn btn-primary btn-lg add-to-cart-btn" data-product-name="{{ $product->name }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Add to Cart
                        </button>
                        <button type="button" class="btn btn-outline btn-lg buy-now-btn" data-product-name="{{ $product->name }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Buy Now
                        </button>
                    </div>
                </div>
            @endif

            @if ($product->description)
                <div class="product-detail-description rich-content">{!! $product->description !!}</div>
            @endif
        </div>
    </div>

    @if ($product->specifications->isNotEmpty())
        <section class="card specifications-section">
            <h2 class="section-title">Specifications</h2>

            <div class="table-wrap">
                <table>
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

    <section class="card reviews-section">
        <h2 class="section-title">Reviews</h2>

        @if ($product->reviewsCount() > 0)
            @php $avgRounded = round($product->averageRating()); @endphp
            <div class="review-summary">
                <div class="review-summary-score">
                    <span class="review-summary-number">{{ number_format($product->averageRating(), 1) }}</span>
                    <span class="rating-stars rating-stars-lg">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $avgRounded ? 'star-filled' : 'star-empty' }}">&#9733;</span>
                        @endfor
                    </span>
                    <span class="review-summary-count">{{ $product->reviewsCount() }} {{ Str::plural('review', $product->reviewsCount()) }}</span>
                </div>

                <div class="review-summary-bars">
                    @for ($star = 5; $star >= 1; $star--)
                        @php $starCount = $product->approvedReviews->where('rating', $star)->count(); @endphp
                        <div class="review-summary-bar-row">
                            <span class="review-summary-bar-label">{{ $star }}&#9733;</span>
                            <span class="review-summary-bar-track">
                                <span class="review-summary-bar-fill" style="width: {{ $product->reviewsCount() ? round($starCount / $product->reviewsCount() * 100) : 0 }}%"></span>
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
            <div class="alert alert-success">
                <p>{{ session('status') }}</p>
            </div>
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
                            @error('rating') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="comment" class="form-label">Your Review</label>
                            <textarea id="comment" name="comment" rows="4" class="form-control" required placeholder="Share your experience with this product&hellip;">{{ old('comment') }}</textarea>
                            @error('comment') <span class="field-error">{{ $message }}</span> @enderror
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
        @endif
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="related-products-section">
            <h2 class="section-title">Related Products</h2>

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
