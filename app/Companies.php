<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{

    protected $table = 'companies';
    protected $fillable = [
        'name', 'email', 'logo','website'
    ];
    public $timestamps = false;

    public function employes() {
        return $this->hasMany(Employes::class, 'company_id');
    }
}
