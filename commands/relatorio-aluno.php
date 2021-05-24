<?php

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Logging\DebugStack;
use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Entity\Telefone;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$debugStack = new DebugStack();

$entityManagerFactory = new EntityManagerFactory();

$entityManager = $entityManagerFactory->getEntityManager();
$entityManager->getConfiguration()->setSQLLogger($debugStack);

$alunosRepository = $entityManager->getRepository(Aluno::class);

/*
 *@var Aluno[] $alunos
 */
$alunos = $alunosRepository->findAll();

foreach ($alunos as $aluno){

    $telefones = $aluno->getTelefones() ->map(function (Telefone $telefone){
        return $telefone->getNumero();
    }) -> toArray();

    /**
     * @return Collection
     */
    $cursos = $aluno->getCurso();

    echo "ID: {$aluno->getId()}\n";
    echo "Nome: {$aluno->getNome()}\n";
    echo "Telefones:" . implode(",", $telefones) . " \n";

    foreach ($cursos as $curso){
        echo "\tID: {$curso->getId()}\n";
        echo "\tNome: {$curso->getNome()}\n";
        echo "\t \n";
    }

}

print_r($debugStack);

