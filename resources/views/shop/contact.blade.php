@extends('shop.layouts.master')
@section('title', 'Liên hệ')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Liên hệ với chúng tôi</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <!-- Thông tin liên hệ -->
                        <div class="col-md-6">
                            <h3>Chiếu UZU & Cói - Hàng thủ công mỹ nghệ</h3>
                            <p><strong>Chị:</strong> Lê Phương Thảo (Chủ Cơ sở)</p>
                            <p><strong>Địa chỉ:</strong> 66 An Hưng, thị trấn An Phú, huyện An Phú, tỉnh An Giang</p>
                            <p><strong>Điện thoại:</strong> <a href="tel:0914377808">0914 377 808</a></p>
                            <p><strong>Email:</strong> <a href="mailto:tanchaulongap@gmail.com">tanchaulongap@gmail.com</a></p>
                            <h3>Gửi tin nhắn cho chúng tôi</h3>
                            <form method="POST" action="{{ route('shop.contact.submit') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Họ và tên</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="message">Tin nhắn</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi</button>
                            </form>
                        </div>
                        <!-- Google Map -->
                        <div class="col-md-6">
                            <h3>Bản đồ</h3>
                            <div class="map-container" style="height: 300px;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.123456789!2d105.087654!3d10.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTAuMTIzNDU2LDEwNS4wODc2NTQ!5e0!3m2!1svi!2s!4v1698765432100!5m2!1svi!2s"
                                    width="100%"
                                    height="100%"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection