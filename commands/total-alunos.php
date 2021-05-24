<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;


$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$classeAluno = Aluno::class;
$dql = "SELECT COUNT(a) FROM $classeAluno a ";

$query = $entityManager->createQuery($dql);
$totalAlunos = $query->getSingleScalarResult();

echo "Total de alunos: $totalAlunos";

