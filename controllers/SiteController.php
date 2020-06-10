<?php


namespace controllers;


use core\Controller;

class SiteController extends Controller
{
    /**
     * @param $name
     * @return string
     * @throws \Throwable
     */
    public function actionHello($name)
    {
        return $this->render('index', ['name' => $name]);
    }
}