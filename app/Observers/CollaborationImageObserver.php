<?php

namespace App\Observers;

use App\Models\OrderLog;
use App\Http\Traits\Searchable;
use App\Models\CollaborationImage;
use Illuminate\Support\Facades\Auth;

class CollaborationImageObserver
{
    use Searchable;


    private static function insertOrderLog($collaborationImage, $log, $deleted = false)
    {
        OrderLog::create([
            'user_id'                => Auth::user()->id,
            'collaboration_id'       => $collaborationImage['collaboration_id'] ?? '',
            'collaboration_image_id' => $deleted ? null : ($collaborationImage['id']),
            'log'                    => $log,
            'notes'                  => $collaborationImage['notes'] ?? '',
            'date'                   => date('m/d/Y', strtotime(now()))
        ]);
    }

    /**
     * Handle the CollaborationImage "created" event.
     *
     * @param  \App\Models\CollaborationImage  $collaborationImage
     * @return void
     */
    public function created(CollaborationImage $collaborationImage)
    {
        //
    }

    /**
     * Handle the CollaborationImage "updated" event.
     *
     * @param  \App\Models\CollaborationImage  $collaborationImage
     * @return void
     */
    public function updated(CollaborationImage $collaborationImage)
    {
        // Logs
        $approvalCheck = $collaborationImage['is_approval_check'];
        $status        = $collaborationImage['status'];
        if ($status == 'uploads') {
            $this->insertOrderLog($collaborationImage, $this->fileUploaded);
        }
        if ($status == 'need approval' && !$approvalCheck) {
            $this->insertOrderLog($collaborationImage, $this->fileMovedToApprove);
        }
        if ($status == 'need approval' && $approvalCheck) {
            $this->insertOrderLog($collaborationImage, $this->fileApprovalNeeded);
        }
        if ($status == 'approved') {
            $this->insertOrderLog($collaborationImage, $this->fileApprove);
        }
        if ($status == 'customers') {
            $this->insertOrderLog($collaborationImage, $this->fileMovedToCustomer);
        }
        if ($status == 'rejected') {
            $this->insertOrderLog($collaborationImage, $this->fileRejectedForCustomer);
        }
    }

    /**
     * Handle the CollaborationImage "deleted" event.
     *
     * @param  \App\Models\CollaborationImage  $collaborationImage
     * @return void
     */
    public function deleted(CollaborationImage $collaborationImage)
    {
        $this->insertOrderLog($collaborationImage, $this->fileDeleted, true);
    }

    /**
     * Handle the CollaborationImage "restored" event.
     *
     * @param  \App\Models\CollaborationImage  $collaborationImage
     * @return void
     */
    public function restored(CollaborationImage $collaborationImage)
    {
        //
    }

    /**
     * Handle the CollaborationImage "force deleted" event.
     *
     * @param  \App\Models\CollaborationImage  $collaborationImage
     * @return void
     */
    public function forceDeleted(CollaborationImage $collaborationImage)
    {
        //
    }
}
