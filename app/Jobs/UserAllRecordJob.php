<?php

namespace App\Jobs;

use App\Models\Report;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Traits\Upload;

class UserAllRecordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,Upload;

    /**
     * Create a new job instance.
     */
    public $user;
    public function __construct($user)
    {
       $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table('deposits')->where('user_id', $this->user->id)->delete();
        DB::table('funds')->where('user_id', $this->user->id)->delete();
        DB::table('payouts')->where('user_id', $this->user->id)->delete();
        DB::table('transactions')->where('user_id', $this->user->id)->delete();
        DB::table('user_kycs')->where('user_id', $this->user->id)->delete();
        DB::table('user_logins')->where('user_id', $this->user->id)->delete();

        SupportTicket::where('user_id', $this->user->id)->get()->map(function ($item) {
            $item->messages()->get()->map(function ($message) {
                if (count($message->attachments) > 0) {
                    foreach ($message->attachments as $img) {
                        $this->fileDelete($img->driver, $img->file);
                        $img->delete();
                    }
                }
            });
            $item->messages()->delete();
            $item->delete();
        });
        Vehicle::where('user_id',$this->user->id)->get()->map(function ($item){
            $item->biddingHistory()->delete();
            $item->reacts()->delete();
            $item->details->delete();
            foreach ( $item->reports as $report){
                $report->conversation()->delete();
            }
            $item->reports()->delete();
            foreach ($item->path_name as $path){
                $this->fileDelete($item->driver,$path);
            }
            $item->delete();
        });
        DB::table('bidding_history')->where('user_id',$this->user->id)->delete();
        DB::table('plan_purchase_history')->where('user_id',$this->user->id)->delete();
        Report::where('repoter_id',$this->user->id)
            ->orWhere('reported_user_id',$this->user->id)->get()->map(function ($item){
                $item->conversation()->delete();
                $item->delete();
            });
        DB::table('messages')->where('sender_id',$this->user->id)
            ->orWhere('receiver_id',$this->user->id)->delete();


        DB::table('in_app_notifications')->where('in_app_notificationable_id', $this->user->id)->where('in_app_notificationable_type',User::class)->delete();
    }
}
