<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Entity\Telefone;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;


$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$alunoRepository = $entityManager->getRepository(Aluno::class);

/**
 * @var Aluno[] $alunosList
 */
$alunosList = $alunoRepository->findAll();

foreach ($alunosList as $aluno) {
    $telefones = $aluno
        ->getTelefones()
        ->map(function (Telefone $telefone){
            return $telefone->getNumero();
        })
        ->toArray();

    echo "ID: {$aluno->getId()}\nNome: {$aluno->getNome()}\n\n";
    echo "Telefones: " . implode(',', $telefones);
}

