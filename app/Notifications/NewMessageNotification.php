<?php



namespace App\Notifications;


use Illuminate\Notifications\Notification;
use App\Models\Notification as AppNotification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;


class NewMessageNotification extends Notification
{
    protected $message;
 	protected $userName;
  
  
    public function __construct($message,$userName)
    {
        $this->message = $message;
        $this->userName = $userName;
    }
  
 	  public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        $notification = AppNotification::create([
            'name' =>  $this->userName,
            'body' => $this->message,
            'user_id' => $notifiable->id,
        ]);
        return (new FcmMessage(notification: new FcmNotification(
                title:  $this->userName,
                body: $this->message,
                
            )))
            ->data(['title' =>  $this->userName, 'body' =>  $this->message])
            ->custom([
                'android' => [
                    'notification' => [
                        'color' => '#0A0A0A',
                    ],
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
                'apns' => [
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
            ]);
    }

    


}
