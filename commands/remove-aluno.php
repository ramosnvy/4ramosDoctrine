<?php

require_once  __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;

$id = $argv[1];

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();


$aluno = $entityManager->getReference(Aluno::class, $id);

$entityManager->remove($aluno);

$entityManager->flush();