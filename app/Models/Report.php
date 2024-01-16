<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $guarded = 'id';
    public  function reporter()
    {
        return $this->belongsTo(User::class,'repoter_id');
    }
    public function repotedUser()
    {
        return $this->belongsTo(User::class,'reported_user_id');
    }

}
