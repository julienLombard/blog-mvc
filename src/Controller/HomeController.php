<?php

namespace Controller;

use App\Controller;

/**
 * Class DefaultController
 * @package Controller
 */
class HomeController extends Controller
{
    /**
    * @return \App\Response\Response
    */
    public function show()
    {
        return $this->render("home.html.twig", []);
    }
}