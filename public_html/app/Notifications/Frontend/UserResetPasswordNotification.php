<?php

namespace App\Notifications\Frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserResetPasswordNotification extends Notification
{
    use Queueable;

	public $token, $email;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct( $token, $email )
    {
	    $this->token = $token;
	    $this->email = $email;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
    	$resetLink = route( 'password.reset', [$this->email, $this->token] );
    	$mm = new MailMessage();
    	$mm->view( toolbox()->frontend()->view('emails.forgot-password'), compact('resetLink') );
    	$mm->from( settings()->getNoReplyEmailAddress(), settings()->getAppName() );
    	$mm->subject( 'Reset Password - ' . settings()->getAppName() );
		return $mm;

		/*
		// *** The default functionality of Laravel 5.4 ***
	    return (new MailMessage)
		    //->view( toolbox()->backend()->view('auth.emails.reset-password') )
		    ->from( settings()->getSupportEmailAddress() )
		    ->line( 'You are receiving this email because we received a password reset request for your account.' )
		    ->action( 'Reset Password', route('admin.password.reset', $this->token) )
		    ->line( 'If you did not request a password reset, no further action is required.' );
		//*/
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
