<h1>Create - Adicionar dados</h1>

Para isso podemos usar `setters` definidos na entidade. Pode parecer fácil mais é uma das partes mais perigosas para qualquer
desenvolvedor. É preciso tomar diversos cuidados com o tipo de informação que entra nesses campos. São muito comuns casos de 
[SQLinjection](https://www.w3schools.com/sql/sql_injection.asp) e outras invasões.

<h2></h2>

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

Aqui você pode ver um exemplos simples de adição de dados. Os setters são perfeitos para isso.

~~~php 
    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }
~~~
