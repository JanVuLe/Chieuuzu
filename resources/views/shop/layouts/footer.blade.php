<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <!-- Thông tin liên hệ -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h4 class="text-uppercase mb-3 animate__animated animate__fadeIn">Chiếu Uzu</h4>
                <h5 class="text-uppercase mb-3">Thông tin liên hệ</h5>
                <ul class="list-unstyled">
                    <li class="mb-2 animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                        <i class="bi bi-geo-alt-fill me-2"></i> An Hưng, TT An Phú, An Phú, An Giang
                    </li>
                    <li class="mb-2 animate__animated animate__fadeIn" style="animation-delay: 0.4s;">
                        <i class="bi bi-telephone-fill me-2"></i> 0914 377808
                    </li>
                    <li class="mb-2 animate__animated animate__fadeIn" style="animation-delay: 0.6s;">
                        <i class="bi bi-envelope-fill me-2"></i> tanchaulongap@gmail.com
                    </li>
                </ul>
            </div>

            <!-- Danh mục -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.2s;">Danh mục</h5>
                <ul class="list-unstyled">
                    <li class="mb-2 animate__animated animate__fadeIn" style="animation-delay: 0.4s;">
                        <a href="{{ route('shop.news.index') }}" class="text-white text-decoration-none hover-link">Tin tức</a>
                    </li>
                    <li class="mb-2 animate__animated animate__fadeIn" style="animation-delay: 0.6s;">
                        <a href="{{ route('shop.contact') }}" class="text-white text-decoration-none hover-link">Tuyển dụng</a>
                    </li>
                </ul>
            </div>

            <!-- Theo dõi chúng tôi -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-uppercase fw-bold mb-3">Theo dõi chúng tôi</h5>
                <ul class="list-unstyled d-flex gap-3">
                    <li>
                        <a href="https://www.facebook.com/vu.v.le.12/" class="text-decoration-none text-dark d-flex align-items-center">
                            <i class="bi bi-facebook fs-4 me-2"></i> <span>vu.v.le</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/@VuLe-rq6nm" class="text-decoration-none text-dark d-flex align-items-center">
                            <i class="bi bi-youtube fs-4 me-2"></i> <span>VuLe-rq6nm</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="bg-light my-4">

        <div class="row">
            <div class="col-md-12 text-center">
                <p class="mb-0 animate__animated animate__fadeIn" style="animation-delay: 1s;">
                    © {{ date('Y') }} Shop. Tân Phú Hưng. Chiếu Uzu & Cối. Hàng thủ công mỹ nghệ.
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    footer {
        flex-shrink: 0;
        background-color: #f8f9fa;
        padding: 10px 0;
        text-align: center;
        width: 100%; /* Đảm bảo footer chiếm toàn bộ chiều ngang */
    }
    footer .container {
        max-width: 1140px; /* Giới hạn chiều rộng của container */
        margin: 0 auto; /* Căn giữa container */
    }
    footer.bg-dark {
        background: linear-gradient(180deg, #212529, #343a40);
    }
    footer h4, footer h5 {
        color: #00c4cc;
        font-weight: 600;
    }
    footer ul li {
        color: #d1d1d1;
        transition: color 0.3s ease;
    }
    footer ul li:hover {
        color: #ffffff;
    }
    .hover-link {
        position: relative;
        transition: color 0.3s ease;
    }
    .hover-link:hover {
        color: #00c4cc !important;
    }
    .hover-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: #00c4cc;
        transition: width 0.3s ease;
    }
    .hover-link:hover::after {
        width: 100%;
    }
    .btn-social {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
    .btn-social:hover {
        transform: scale(1.1);
    }
    .btn-social-facebook {
        background-color: #3b5998;
        color: white;
    }
    .btn-social-twitter {
        background-color: #1da1f2;
        color: white;
    }
    .btn-social-instagram {
        background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        color: white;
    }
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }
    #wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    #page-wrapper {
        flex: 1;
    }
</style>