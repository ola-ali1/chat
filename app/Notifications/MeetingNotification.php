<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Benwilkins\FCM\FcmMessage;

class MeetingNotification extends Notification
{
    use Queueable;

    /** @var */
    protected $joiningId;

    /** @var */
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @param $joiningId
     * @param $password
     */
    public function __construct($joiningId, $password)
    {
        $this->meetingId = $joiningId;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['fcm'];
    }

//    /**
//     * Get the mail representation of the notification.
//     *
//     * @param  mixed  $notifiable
//     * @return \Illuminate\Notifications\Messages\MailMessage
//     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

//    /**
//     * Get the array representation of the notification.
//     *
//     * @param  mixed  $notifiable
//     * @return array
//     */
//    public function toArray($notifiable)
//    {
//        return [
//            //
//        ];
//    }


    public function toFcm($notifiable)
    {
        $message = new FcmMessage();
        $message->content([
            'title'        => 'Foo',
            'body'         => 'Bar',
            'sound'        => '', // Optional
            'icon'         => '', // Optional
            'click_action' => '' // Optional
        ])->data([
            'joining_id' => $this->joiningId,
            'password'   => $this->password
        ])->priority(FcmMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.

        return $message;
    }
}
