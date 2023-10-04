<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index()
  {
    return view('Admin.dashboard');
  }

  public function paidUsers()
  {
    return view('Admin.users');
  }

  public function getMonthly(Request $request)
  {

  }
}
