<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// app/Models/SupervisiIT.php
class SupervisiIT extends Model
{
    protected $connection = 'mysql_it';
    protected $table = 'supervisi';
    protected $fillable = ['item_id', 'user_id', 'tanggal', 'keterangan'];
}
