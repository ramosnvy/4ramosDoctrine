<h1>Persistência e envio de dados</h1>

~~~php 
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;


   $aluno = new Aluno();
   $aluno->setNome('Pedro Ramos');

    $entityManagerFactory = new EntityManagerFactory();
    $entityManager = $entityManagerFactory->getEntityManager();

    $entityManager->persist($aluno);

    $aluno->setNome('Pedro Augusto Ramos');

    $entityManager->flush()

~~~

Temos esse exemplo de código, onde estou criando um novo aluno e definindo seu nome. É possível perceber que no fim do 
código, estou chamando um método `persist()` e estou passando `$aluno` como parâmetro, o que isso significa?

O método `persist()` é feito para monitorar as alterações feitas em um atributo do banco de dados, nesse caso, estou mando 
ele monitorar o atributo `$aluno`. Ele garante que as alterações são feitas e que serão enviadas corretamente para o banco de dados.

Em sequência temos o método `flush()`, ele é o método que faz o envio de todas as alterações para o banco. Quando executamos ele, queremos dizer que todas as informações devem ser enviadas e atualizadas/guardadas pelo banco.