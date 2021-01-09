<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'adresses';
    public $timestamps = false;

    protected $fillable = ['address', 'city', 'uf', 'cep'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
