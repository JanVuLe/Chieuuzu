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

            <!-- Về công ty -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.2s;">Về công ty</h5>
                <ul class="list-unstyled">
                    <li class="mb-2 animate__animated animate__fadeIn" style="animation-delay: 0.4s;">
                        <a href="#" class="text-white text-decoration-none hover-link">Giới thiệu công ty</a>
                    </li>
                    <li class="mb-2 animate__animated animate__fadeIn" style="animation-delay: 0.6s;">
                        <a href="#" class="text-white text-decoration-none hover-link">Tuyển dụng</a>
                    </li>
                    <li class="mb-2 animate__animated animate__fadeIn" style="animation-delay: 0.8s;">
                        <a href="#" class="text-white text-decoration-none hover-link">Gửi góp ý, khiếu nại</a>
                    </li>
                </ul>
            </div>

            <!-- Theo dõi chúng tôi -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.2s;">Theo dõi chúng tôi</h5>
                <div class="d-flex">
                    <a href="#" class="btn btn-social btn-social-facebook me-2 animate__animated animate__zoomIn" style="animation-delay: 0.4s;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-social btn-social-twitter me-2 animate__animated animate__zoomIn" style="animation-delay: 0.6s;">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-social btn-social-instagram animate__animated animate__zoomIn" style="animation-delay: 0.8s;">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>
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
</style>