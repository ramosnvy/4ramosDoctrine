<?php

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Entity\Curso;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$alunoId = $argv[1];
$cursoId = $argv[2];

/** @var Aluno $aluno */
$aluno = $entityManager->find(Aluno::class, $alunoId);
/** @var Curso */
$curso = $entityManager->find(Curso::Class, $cursoId);

$aluno->addCurso($curso);

$entityManager->flush();