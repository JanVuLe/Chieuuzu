@component('mail::message')
# Xin chào từ Chiếu UZU & Cói 🌾

Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản của mình. Nhấn nút bên dưới để tiếp tục:

@component('mail::button', ['url' => $url])
Đặt lại mật khẩu
@endcomponent

Liên kết này sẽ hết hạn sau 60 phút.

Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.

Trân trọng,<br>
**Chiếu UZU & Cói**  
@endcomponent
