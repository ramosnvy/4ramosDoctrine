<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;

$id = $argv [1];
$novoNome = $argv [2];

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$aluno = $entityManager->find(Aluno::class, $id);

$aluno -> setNome($novoNome);
$entityManager->flush();