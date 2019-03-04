<?php

namespace App\Notifications\User;

use App\Models\Customer;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomerResetPasswordNotification extends Notification
{
    /**
     * @var Customer
     */
    private $user;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a new notification instance.
     *
     * AdminResetPasswordNotification constructor.
     * @param Customer $user
     * @param $token
     */
    public function __construct(Customer $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    private function mailInfo($notifiable) {
        return [
            'mail_header' => 'Reset Your Password',
            'mail_message' => 'You are receiving this email because we received a password reset request for your account.',
            'email_address' => $this->user->email,
            'user_name' => $this->user->name,
            'button_text' => 'Reset Password!',
            'button_link' => $this->resetPasswordUrl($notifiable),
            'additional_info' => 'If you did not request a password reset, no further action is required.',
            // TODO: setup the remover link
            'remove_email_link' => ''
        ];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        return (new MailMessage)->view(
            'mail.single_button_mail', $this->mailInfo($notifiable)
        )->subject('['.config('app.name').']'.' Reset Password');

    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetPasswordUrl($notifiable)
    {
        return route('customer.password.reset', $this->token);
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}