<h1>Removendo dados</h1>

Podemos utilizar o `getReference();` como método para localizar o aluno que iria ser removido, assim séria
realizada uma query a menos para o banco de dados. Ele retorna uma nova entidade que possui o Atributo PK da entidade no
banco.

Passamos esse resultado para o método `` remove ();`` de **$entityManager** e realizamos o envio apra o banco.

~~~ php 
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
~~~