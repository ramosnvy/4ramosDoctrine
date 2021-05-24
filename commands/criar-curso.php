<?php

use Ramos\estudoDoctrine\Entity\Curso;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$curso = new Curso();
$curso->setNome($argv[1]);

$entityManager->persist($curso);
$entityManager->flush();