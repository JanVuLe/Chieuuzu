<div class="reviews-list" style="margin-top: 30px;">
    @if($reviews->isNotEmpty())
        @foreach($reviews as $review)
            <div class="review-item" style="border-bottom: 1px solid #e0e0e0; padding: 15px 0;">
                <div class="reviewer-name" style="font-weight: bold; margin-bottom: 5px;">
                    {{ $review->user->name ?? 'Ẩn danh' }}
                </div>
                <div class="review-rating" style="margin-bottom: 5px;">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                            <span style="color: #ffd700;">★</span>
                        @else
                            <span style="color: #ccc;">☆</span>
                        @endif
                    @endfor
                </div>
                <div class="review-comment" style="color: #333;">
                    {{ $review->comment ?? 'Không có bình luận' }}
                </div>
            </div>
        @endforeach
    @else
        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
    @endif
</div>