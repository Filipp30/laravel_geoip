<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AdminUsers extends Model{
    use HasFactory,Notifiable;

    protected $table = 'admin_users';
    public $timestamps = false;

}
