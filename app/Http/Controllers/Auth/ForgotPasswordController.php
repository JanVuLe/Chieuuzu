<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Hiển thị form yêu cầu đặt lại mật khẩu.
     */
    public function showLinkRequestForm()
    {
        return view('shop.auth.forgot_password');
    }

    /**
     * Gửi liên kết đặt lại mật khẩu.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
        ]);

        Log::info('Bắt đầu gửi liên kết đặt lại mật khẩu cho email: ' . $request->email);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                Log::info('Liên kết đặt lại mật khẩu đã gửi thành công cho: ' . $request->email);
                return back()->with('status', 'Liên kết đặt lại mật khẩu đã được gửi!');
            }

            Log::error('Lỗi gửi liên kết đặt lại mật khẩu, trạng thái: ' . $status);
            return back()->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            Log::error('Lỗi ngoại lệ khi gửi email đặt lại mật khẩu: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.']);
        }
    }

    /**
     * Hiển thị form đặt lại mật khẩu.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('shop.auth.reset_password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Xử lý đặt lại mật khẩu.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Token không hợp lệ.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email không tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        Log::info('Bắt đầu đặt lại mật khẩu cho email: ' . $request->email);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
                Log::info('Mật khẩu đã được đặt lại cho user: ' . $user->email);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Log::info('Đặt lại mật khẩu thành công cho: ' . $request->email);
            return redirect()->route('shop.login')->with('status', 'Mật khẩu đã được đặt lại thành công!');
        }

        Log::error('Lỗi đặt lại mật khẩu, trạng thái: ' . $status);
        return back()->withErrors(['email' => __($status)]);
    }
}