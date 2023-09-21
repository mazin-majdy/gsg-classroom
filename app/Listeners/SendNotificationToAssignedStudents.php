<?php

namespace App\Listeners;

use App\Jobs\SendClassroomNotification;
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
        $classwork = $event->classwork;

        $job = new SendClassroomNotification($classwork->users, new NewClassworkNotification($classwork));
        $job->onQueue('notifications');

        dispatch($job)->onQueue('notifications');
        // SendClassroomNotification::dispatch($event->classwork->users, new NewClassworkNotification($event->classwork);
    }
}
