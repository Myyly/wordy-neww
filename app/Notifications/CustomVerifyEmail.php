<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
class CustomVerifyEmail extends VerifyEmail
{

    public function __construct()
    {
        //
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->from('myylyymecafe@gmail.com', 'FLASHCARD')
            ->subject('Xác minh tài khoản của bạn')
            ->line('Vui lòng nhấn vào nút bên dưới để xác minh địa chỉ email của bạn.')
            ->action('Xác minh Email', $verificationUrl)
            ->line('Nếu bạn không tạo tài khoản, bạn có thể bỏ qua email này.');
    }
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
