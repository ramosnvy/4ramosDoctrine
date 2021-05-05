<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Entity\Telefone;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;


   $aluno = new Aluno();
   $aluno->setNome($argv[1]);

    $entityManagerFactory = new EntityManagerFactory();
    $entityManager = $entityManagerFactory->getEntityManager();

    for($i = 2; $i < $argc; $i++ ){
        $numeroTelefone = $argv[$i];
        $telefone = new Telefone();
        $telefone->setNumero($numeroTelefone);
        $aluno->addTelefone($telefone);
    }

    $entityManager->flush();