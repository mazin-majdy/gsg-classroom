<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\ClassworkCreated;
use App\Notifications\NewClassworkNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationToAssignedStudents
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassworkCreated $event): void
    {
        // foreach ($event->classwork->users as $user) {
        //     $user->notify(new NewClassworkNotification($event->classwork));
        // }

        // same foreach
        Notification::send($event->classwork->users, new NewClassworkNotification($event->classwork));
    }
}
