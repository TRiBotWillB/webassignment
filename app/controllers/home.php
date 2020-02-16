<?php

class home extends BaseController
{

    public function index()
    {
        $this->view('home/index',
            [
            ]);

    }

}