<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Doctrine\Bundle\DoctrineBundle;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
