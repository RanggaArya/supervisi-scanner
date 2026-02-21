<?php

// app/Models/InventoryIT.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InventoryIT extends Model
{
    protected $connection = 'mysql_it';
    protected $table = 'items';
    protected $fillable = ['qr_code', 'nama_barang', 'spesifikasi', 'lokasi'];
}

// app/Models/InventoryAlkes.php
class InventoryAlkes extends Model
{
    protected $connection = 'mysql_alkes';
    protected $table = 'items';
    protected $fillable = ['qr_code', 'nama_barang', 'spesifikasi', 'lokasi'];
}

// app/Models/InventoryRT.php
class InventoryRT extends Model
{
    protected $connection = 'mysql_rt';
    protected $table = 'items';
    protected $fillable = ['qr_code', 'nama_barang', 'spesifikasi', 'lokasi'];
}
