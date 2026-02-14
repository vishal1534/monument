<?php

namespace App\Listeners;

use App\Events\ProcessException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogExceptionMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProcessException  $event
     * @return void
     */
    public function handle(ProcessException $event)
    {
        //dd($event->message);
        Log::channel('databaselog')->error($event->message);
    }
}
