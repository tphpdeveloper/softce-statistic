<?php

namespace Softce\Statistic\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = ['session_id', 'url', 'visit', 'added', 'buyed', 'agent', 'user_id'];
}
