<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;


   $aluno = new Aluno();
   $aluno->setNome('Pedro Ramos');

    $entityManagerFactory = new EntityManagerFactory();
    $entityManager = $entityManagerFactory->getEntityManager();

    $entityManager->persist($aluno);

    $aluno->setNome('Pedro Augusto Ramos');

    $entityManager->flush();