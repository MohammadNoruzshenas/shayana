<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class FooterLink extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function link()
    {
        if (Route::has($this->link)) {
            return route($this->link);
        } else {
            return $this->link;
        }
    }
}
