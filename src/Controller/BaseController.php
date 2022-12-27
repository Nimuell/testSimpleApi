<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    public const STATUS_ACCEPTED = 202;
    public const STATUS_BAD_REQUEST = 400;

}