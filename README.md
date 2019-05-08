# custom-notifications
> Package for custom notification (DatabaseChannels) in Laravel.

This package help you to improve laravel notification in various types of model and class.
Let's see how easily to setup. 

## Installation
You can install the package via composer:
```sh
npm install rezawikan/custom-notifications
```

## Usage

The service provider will automatically get registered. Or you may manually add the service provider in your config/app.php file:

```php
'providers' => [
    // ...
    Rezawikan\CustomNotifications\CustomNotificationServiceProvider::class,
];
```

Migrate the database and create your first notification for use this package.
```ssh
php artisan migrate
```

```ssh
php artisan make:notification NotificationName
```

Use the custom database channel in notification. If you want to add additional method such us mail or SMS it's fine.
```php
use Rezawikan\CustomNotifications\Notifications\Channels\DatabaseChannel;

/**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
          DatabaseChannel::class
        ];

    }
```

Customize your representation array of the notification. You can add anything, according your data that your recieve on the construct method.
> - note that if you changes `toArray` function with another structure. You can restructure on database with `php artisan notifications:restructure`
>```php
>/**
>     * Get the array representation of the notification.
>     *
>     * @param  mixed  $notifiable
>     * @return array
>     */
>    public function toArray($notifiable)
>    {
>        return [
>            'comment' => [
>              'id'   => $this->comment->id,
>              'body' => $this->comment->body
>            ]
>        ];
>    }
> ```

Now, move to user model. You must the the relation to the notification table.

```php
use Illuminate\Notifications\Notifiable;
use App\App\Notifications\Models\DatabaseNotification;

class User extends Authenticatable
{
  use Notifiable;
  
  /**
     * [posts description]
     * @return [type] [description]
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at','desc');
    }
}

```

## Attribute
There are attribute value on the $notification object. In this package, we have additional value.
```php
$notification->models
$notification->type_class
```

## Tips on the blade view
Generate notification in controller. Make sure you have login to your app.
```php
$notifications = $request->user()->notifications;
```
Create slot blade, put on the resources/notifications/notification.blade.php
```php
<div>
{{ $slot }}
Mark as read
</div>
```

Create component blade, put on the resources/notifications/types/<b>name</b>.blade.php
Name of file, must according to model name.</b>
In our example, we use model comment, you can add with other model.
```php
@component('notifications/notification')
  {{ $notification->data->author->name }} posted comment
@endcomponent
```

On the index blade or that want to display the notifications list.

```php
@foreach($notifications as $notification)
  @include('notifications/type/'. snake_case($notification->type), compact('notification'))
@endforeach
```


## Meta

Mochammad Rezza Wikandito – [@rezawikan](https://twitter.com/rezawikan) – reza.wikan.dito@gmail.com

[https://github.com/rezawikan/custom-notifications](https://github.com/rezawikan/)


