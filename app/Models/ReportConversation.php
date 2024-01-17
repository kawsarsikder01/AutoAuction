<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportConversation extends Model
{
    use HasFactory;
    protected $table = 'report_conversation';
    protected $fillable = ['sender_id','reporter_id','reported_id','admin_id','report_id','message'];

    public  function reporter()
    {
        return $this->belongsTo(User::class,'reporter_id');
    }
    public function repotedUser()
    {
        return $this->belongsTo(User::class,'reported_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function report()
    {
        return $this->belongsTo(Report::class,'report_id');
    }
}
