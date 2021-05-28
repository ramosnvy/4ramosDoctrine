<?php

use Doctrine\Common\Collections\Collection;
use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Entity\Telefone;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

/*@var EntityRepository $alunoRepository */
$alunoRepository = $entityManager->getRepository(Aluno::class);


/*
 *@var Aluno[] $alunos
 */
$alunos = $alunoRepository->buscaCursosPorAluno();

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



