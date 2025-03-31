@push('styles')
<link href="{{ asset('assets/css/plugins/slick/slick.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
@endpush
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="banner">
                @if ($banners->isNotEmpty())
                    @foreach ($banners as $banner)
                        <div>
                            <img src="{{ $banner }}" style="width: 100%; height: 100%; max-height: 400px; object-fit: cover;"
                                style="max-width: 100%; width: auto; height: auto; object-fit: cover; padding: 0%;">
                        </div>
                    @endforeach
                @else
                    <p>Chưa có hình ảnh</p>
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/plugins/slick/slick.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.banner').slick({
            dots: true,               // Hiển thị dấu chấm điều hướng
            infinite: true,           // Lặp vô hạn
            speed: 500,               // Tốc độ chuyển slide (500ms)
            slidesToShow: 1,          // Số slide hiển thị mỗi lần
            slidesToScroll: 1,        // Số slide cuộn mỗi lần
            adaptiveHeight: true,     // Tự động điều chỉnh chiều cao
            autoplay: true,           // Tự động chạy slide
            autoplaySpeed: 3000,      // Chuyển slide sau mỗi 3 giây
        });
    });
</script>
@endpush