<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;


$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$alunoRepository = $entityManager->getRepository(Aluno::class);

/**
 * @var Aluno[] $alunosList
 */
$alunosList = $alunoRepository->findAll();


  foreach ($alunosList as $aluno){
    echo "ID: {$aluno->getId()}\n Nome:  {$aluno->getNome()} \n\n";
  }

