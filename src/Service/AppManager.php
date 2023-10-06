<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;


class AppManager{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
}