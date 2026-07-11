<x-layouts.site title="My Reviews">
    @include('site.partials._account-header')

    @include('site.partials._account-nav')

    <div class="profile-tab-panel active">
        <section class="card">
            <h2 class="section-title">My Reviews</h2>

            @if ($reviews->isEmpty())
                <div class="cart-empty">
                    <p>You haven't written any reviews yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">Browse Products</a>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>
                                        @if ($review->product)
                                            <a href="{{ route('product.show', $review->product) }}">{{ $review->product->name }}</a>
                                        @else
                                            <span class="muted">Product removed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">&#9733;</span>
                                            @endfor
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($review->comment, 80) }}</td>
                                    <td>
                                        @if ($review->status === 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @elseif ($review->status === 'rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                        @else
                                            <span class="badge badge-muted">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 1rem;">
                    {{ $reviews->links() }}
                </div>
            @endif
        </section>
    </div>

    <script src="{{ asset('js/avatar-upload.js') }}"></script>
</x-layouts.site>
