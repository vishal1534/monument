<?php

namespace App\Observers;

use App\Models\CollaboratorMail;
use App\Models\OrderLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CollaborationMailObserver
{
    /**
     * Handle the CollaboratorMail "created" event.
     *
     * @param \App\Models\CollaboratorMail $collaboratorMail
     *
     * @return void
     */
    public function created(CollaboratorMail $collaboratorMail)
    {
        OrderLog::create([
            'user_id' => Auth::user()->id,
            'collaboration_id' => $collaboratorMail['collaboration_id'],
            'log' => 'Email sent to ' . $collaboratorMail['send_to'],
            'notes' => $collaboratorMail['content'],
            'date' => date('m/d/Y', strtotime(now()))
        ]);
    }

    /**
     * Handle the CollaboratorMail "updated" event.
     *
     * @param \App\Models\CollaboratorMail $collaboratorMail
     *
     * @return void
     */
    public function updated(CollaboratorMail $collaboratorMail)
    {
        //
    }

    /**
     * Handle the CollaboratorMail "deleted" event.
     *
     * @param \App\Models\CollaboratorMail $collaboratorMail
     *
     * @return void
     */
    public function deleted(CollaboratorMail $collaboratorMail)
    {
        //
    }

    /**
     * Handle the CollaboratorMail "restored" event.
     *
     * @param \App\Models\CollaboratorMail $collaboratorMail
     *
     * @return void
     */
    public function restored(CollaboratorMail $collaboratorMail)
    {
        //
    }

    /**
     * Handle the CollaboratorMail "force deleted" event.
     *
     * @param \App\Models\CollaboratorMail $collaboratorMail
     *
     * @return void
     */
    public function forceDeleted(CollaboratorMail $collaboratorMail)
    {
        //
    }
}
