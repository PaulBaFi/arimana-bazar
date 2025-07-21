<?php

require_once "models/LandingModel.php";

class LandingController
{
    private $model;

    public function __construct()
    {
        $this->model = new LandingModel();
    }

    public function index()
    {
        include "landing/index.php";
    }
}
