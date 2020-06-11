<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employes extends Model
{
    protected $table = 'employes';
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'company_id'
    ];
    protected $appends = ['companyName'];


    public $timestamps = false;



    public function companies()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function getCompanyNameAttribute()
    {
        if ($this->companies) {
            return $this->companies->name;
        } else {
            return '';
        }
    }
}
