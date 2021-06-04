<h1> Trazendo dados </h1>

Uma das capacidades mais importantes do CRUD é a capacidade de trazer/ler dados de algum campo. 

O Doctrine é bem gentil nesse sentido, ele possui um método chamado `getRepository()`,  esse método recebe como 
parâmetro a classe que queremos o repositório. Atribuindo o resultado dessa chamada a uma 
váriavel, podemos ter acesso a funções de busca dentro desse repositório.

~~~php 
<?php

use Alura\Doctrine\Entity\Aluno;
use Alura\Doctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$alunoRepository = $entityManager->getRepository(Aluno::class);
~~~

Assim, podemos utilizar diversos modos de buscar para capturar as informações que queremos.

* `findAll()` - Esse método busca todas as instâncias do repositório. Ele também concede acesso aos métodos presentes neles.


* `find()` - Podemos utilizar para buscar os alunos que possuem um atributo definido, esse atributo é passado como
  parâmetro e retorna uma chamada que disponibilizada os métodos do repositório, nesse caso: ``getId();`` e `getNome();`.

~~~ php 
$nico = $alunoRepository->find(4);
echo $nico->getNome();
~~~ 


* ``findBy();`` - Podemos utilizar para buscar itens utilizando atributos diferentes do ID, passando
  como parâmetro os critérios de busca (filtros) em um array associativo. Como retorno temos um array com um índice.


~~~php 
$sergioLopes = $alunoRepository->findBy([
    'nome' => 'Sergio Lopes'
]);
var_dump($sergioLopes);
~~~


* `findOneBy();` - Podemos utilizar para buscar itens utilizando atributos diferentes do ID, passando
  como parâmetro os critérios de busca (filtros) em um array associativo. Como retorno temos um objeto do tipo Aluno.

~~~ php 
$neymar  =  $alunoRepository->findOneBy([
    'nome' => 'Neymar Junior'
]);

~~~


