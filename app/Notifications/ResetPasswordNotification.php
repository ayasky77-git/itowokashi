<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('パスワードリセットのご案内')
            ->line('パスワードリセットのリクエストを受け付けました。')
            ->action('パスワードをリセットする', $this->resetUrl($notifiable))
            ->line('このリンクは ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' 分間有効です。')
            ->line('心当たりがない場合は、このメールを無視してください。');
    }
}