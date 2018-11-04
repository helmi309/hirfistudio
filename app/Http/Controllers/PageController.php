<?php

namespace App\Http\Controllers;

/**
 * Class PageController
 *
 * @package App\Http\Controllers
 */
class PageController extends Controller
{
    public function __construct()
    {
//        $this->middleware('guest', ['only' => ['getLogin']]);
    }

    /**
     * Create new instance PageController
     */

    /**
     * @return string
     */
    public function backoffice()
    {
        return view('backoffice');
    }

    public function signup()
    {
        return view('signup');
    }
    public function getLogin()
    {
        return view('signin');
    }


    public function form()
    {
        return view('form');
    }

    public function form_spl()
    {
        return view('form_spl');
    }

    public function contact()
    {
        return view('contact');
    }

    public function location()
    {
        return view('location');
    }

    public function employee()
    {
        return view('employee');
    }

    public function galerry()
    {
        return view('galerry');
    }
    public function token()
    {
        return csrf_token();
    }
}
