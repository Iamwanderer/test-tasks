<?php

namespace controllers;

use \models\DatabaseShell;
use \view\Render;


class SiteController
{
    private function sanitizer($data, $filter, $length)
    {
        $result = mb_substr(trim($data), 0, $length, 'UTF-8');
        $result = filter_var($result, $filter);
        return $result;
    }

    public function getIndex()
    {
        (new DatabaseShell)->tableMaker();
        (new Render)->Render('setDataForm');
    }

    public function setData()
    {
        $phone = $this->sanitizer($_POST['phone'], FILTER_SANITIZE_NUMBER_INT, 35);
        $email = $this->sanitizer($_POST['email'], FILTER_VALIDATE_EMAIL, 35);

        if (!$email || !$phone) {
            (new Render)->Render('setDataForm', 'Error! Please enter correct phone and e-mail');
            exit;
        }

        if ((new DatabaseShell)->setData($phone, $email)) {
            header('Location: /get');
            exit;
        }
    }


    public function getData()
    {
        if (!$_POST) {
            (new Render)->Render('getDataForm', '');
            exit;
        }

        $email = $this->sanitizer($_POST['email'], FILTER_VALIDATE_EMAIL, 35);

        if (!$email) {
            (new Render)->Render('getDataForm', 'Error! Please enter correct e-mail');
            exit;
        }
        
        $result = (new DatabaseShell)->getData($email);
        header("Location: /$result");
        exit;
    }

    public function successNotice()
    {
        (new Render)->Render('success');
        exit;
    }

    public function absenceNotice()
    {
        (new Render)->Render('absence');
        exit;
    }

    public function notFound()
    {
        header("HTTP/1.0 404 Not Found");
    }
}
