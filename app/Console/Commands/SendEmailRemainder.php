<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailRemainder;
use App\Models\Collaboration;
use App\Models\CollaborationImage;
use Illuminate\Support\Facades\URL;
use App\Models\CollaboratorType;


class SendEmailRemainder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:remainder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is created for sending email remainder using scheduler ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $collaboratorRole = CollaboratorType::where('title', 'customer')->get();
        if (isset($collaboratorRole) && !empty($collaboratorRole[0]->id))
        {
            $typeId = $collaboratorRole[0]->id;
            $needApproval = Collaboration::with(['images' => function ($query){
                $query->where('status','need approval');
            },'collaborators' => function($query) use ($typeId) {
                return $query->where('type_id', $typeId);
            }])->get();

            $currentDate =  $ldate = date('Y-m-d');
            foreach ($needApproval as $key => $value)
            {
                $colId = $value->id;
                $mailRemainderDay = $value->mail_remainder_days;
                $orderId = $value->order_id;
                if (isset($value->images) && !empty($value->images) && isset($value->collaborators) && !empty($value->collaborators)){
                    $collaborationImages = $value->images;
                    $collaborators = $value->collaborators;
                    foreach ($collaborators as $colKey => $colVal)
                    {
                        if (isset($colVal->email) && !empty($colVal->email))
                        {
                            $receiverMail = $colVal->email;
                            foreach ($collaborationImages as $imgKey => $imgVal ){
                                $mailStatus = $imgVal->sent_mail;
                                $lastMailDate = $imgVal->last_sent_mail_date;
                                $sendMailDate = null;

                                if (!empty($lastMailDate))
                                {
                                    $sendMailDate = strtotime($mailRemainderDay." day", strtotime($lastMailDate));
                                    $sendMailDate = date("Y-m-d", $sendMailDate);
                                }else{
                                    $sendMailDate = $currentDate;
                                }

                                if ($currentDate == $sendMailDate)
                                {
                                    $user = CollaborationImage::where('id', $imgVal->id)
                                        ->update(['sent_mail' => 1, 'last_sent_mail_date' => date('Y-m-d H:i:s')]);
                                    $email = $receiverMail;
                                    $maildata = [
                                        'title' => 'View Approval Needed File on the following link.',
                                        'url' => URL::to($imgVal->path),
                                        'OrderId' => $orderId,
                                        'message' => 'This is testing email for need approval.'
                                    ];
                                    Mail::to($email)->send(new EmailRemainder($maildata));
                                }

                            }
                        }

                    }

                }
            }

        }



    }
}
