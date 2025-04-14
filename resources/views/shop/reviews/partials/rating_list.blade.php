<div class="rating-list">
    @for ($i = 5; $i >= 1; $i--)
        @php
            $ratingPercentage = $ratingCount > 0 ? ($ratingDistribution[$i] / $ratingCount) * 100 : 0;
        @endphp
        <div class="rating-item" style="display: flex; align-items: center; margin-bottom: 10px">
            <span style="width: 50px;">{{ $i }} ★</span>
            <div class="progress" style="flex-grow: 1; height: 10px; margin: 0 10px; background-color: #e0e0e0; border-radius: 5px;">
                <div class="progress-bar" style="width: {{ $ratingPercentage }}%; background-color: #ffd700; border-radius: 5px;"></div>
            </div>
            <span style="width: 60px; text-align: right;">{{ number_format($ratingPercentage, 1) }} %</span>
        </div>
    @endfor
</div>