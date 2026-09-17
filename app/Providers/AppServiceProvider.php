<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pastikan semua URL yang digenerate (link di email,
        // asset, dsb) selalu pakai https:// saat production,
        // walaupun request yang masuk kadang kebaca http://
        // gara-gara proxy/load balancer di hosting.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $url = route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);

            return (new MailMessage())
                ->subject('Reset Password - SchoolOS Class')
                ->greeting(
                    'Halo, ' . $notifiable->name . '!'
                )
                ->line(
                    'Kami menerima permintaan reset password ' .
                    'untuk akun SchoolOS Class kamu.'
                )
                ->action('Reset Password', $url)
                ->line(
                    'Link ini akan kedaluwarsa dalam 60 menit.'
                )
                ->line(
                    'Kalau kamu tidak meminta reset password, ' .
                    'abaikan saja email ini — password kamu ' .
                    'tidak akan berubah.'
                );
        });
    }
}
