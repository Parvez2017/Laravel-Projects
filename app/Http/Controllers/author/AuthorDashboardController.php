<?php

namespace App\Http\Controllers\author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorDashboardController extends Controller
{
    public function index(){

        return view('author.index');


    }
}
