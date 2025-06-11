<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstituteResource;
use App\Models\Institute;

class NavBarController extends Controller
{
    public function index(){

        $institute = Institute::all(['id' , 'name' , 'short_name']);
        return $this->respondOk(InstituteResource::collection($institute), __('institute.index'));
    }
}
