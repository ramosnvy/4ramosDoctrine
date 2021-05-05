<h1> Dia 3 - Finalizando o CRUD </h1>

Essa parte do curso começou mostrando a existência de uma variável pronta, já inicializada, chamada ```$argv ```. A  
partir do índice 1, ela tem acesso aos valores que são passados na  linha de comando.

~~~ php 
$aluno = new Aluno();
$aluno->setNome($argv[1]);

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$entityManager->persist($aluno);

$entityManager->flush();

~~~ 

Exemplo:
Se chamarmos php commands\criar-aluno.php passando, por exemplo, "Aluno Teste", essa string será passada como 
parâmetro para $argv. 

~~~php 
php commands\criar-aluno.php "Aluno Teste"
php commands\criar-aluno.php "Nico Steppat"
php commands\criar-aluno.php "Flavio Almeida"
php commands\criar-aluno.php "Sergio Lopes

~~~

<h2> Buscando alunos </h2>>

O Doctrine fornece acesso a features como repositórios. Se no banco existe uma tabela Aluno, vamos ter um repositório de 
Aluno.

A partir do $entityManager ,chamaremos o método getRepository(), esse método recebe como parâmetro a classe que queremos
o repositório. Atribuindo o resultado dessa chamada a uma váriavel, podemos ter acesso a funções de busca dentro desse repositório.

~~~ php 
<?php

use Alura\Doctrine\Entity\Aluno;
use Alura\Doctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$alunoRepository = $entityManager->getRepository(Aluno::class);

~~~

O ``` getRepository(); ``` fornece meios de fazer buscar por itens do banco de dados. Podemos usar o ``` $alunoRepository ```  
para chamar um método `` findAll(); `` que literalmente trará todos os itens da lista. Atribuiremos essa chamada a u
m $alunoList, ou seja, uma lista de alunos.

Em seguida, criaremos um foreach iterando por cada $aluno em $alunoList. Adicionaremos também uma annotation informando 
que esse $alunoList é um array de Aluno, e faremos um echo $aluno->getId().

~~~php 
/**
 * #var Aluno[] $alunoList
 */
$alunoList = $alunoRepository->findAll();

foreach ($alunoList as $aluno) {
    echo "ID: {$aluno->getId()}\nNome: {$aluno->getNome()}\n\n";
}
~~~  

Existem outros métodos disponíveis, como:

* ``find()`` - Podemos utilizar para buscar os alunos que possuem um atributo definido, esse atributo é passado como
parâmetro e retorna uma chamada que disponibilizada os métodos do repositório, nesse caso: ``getId();`` e `getNome();`.
  
~~~ php 
$nico = $alunoRepository->find(4);
echo $nico->getNome();
~~~ 

* ``findBy();`` - Podemos utilizar para buscar itens por outros utilizando outros atributos diferentes do ID, passando 
  como parâmetro os critérios de busca (filtros) em um array associativo. Como retorno temos um array com um índice.
  
~~~php 
$sergioLopes = $alunoRepository->findBy([
    'nome' => 'Sergio Lopes'
]);
var_dump($sergioLopes);
~~~

* `findOneBy();` - Podemos utilizar para buscar itens por outros utilizando outros atributos diferentes do ID, passando
  como parâmetro os critérios de busca (filtros) em um array associativo. Como retorno temos um objeto do tipo Aluno.
  
~~~ php 
$neymar  =  $alunoRepository->findOneBy([
    'nome' => 'Neymar Junior'
]);

~~~


<h2> Atualizando aluno </h2>

Nem sempre precisamos pegar um repositório para buscar entidades, caso você queria buscar apenas uma entidade, você pode
usar diretamente o `$entityManager`  para fazer um `find();`,esse método espera como primeiro parâmetro a classe que 
queremos buscar (no nosso caso, Aluno), e o $id do item a ser buscado.  

~~~php 
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ramos\estudoDoctrine\Entity\Aluno;
use Ramos\estudoDoctrine\Helper\EntityManagerFactory;

$id = $argv [1];
$novoNome = $argv [2];

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$aluno = $entityManager->find(Aluno::class, $id);

$aluno -> setNome($novoNome);
$entityManager->flush();
~~~ 

> Nesta última aula, nós vimos como atualizar uma entidade gerenciada pelo Doctrine, mas diferentemente de 
> quando criamos uma nova entidade, não foi necessário chamar o método persist. 
> Como utilizamos o próprio Doctrine para buscar a entidade que foi atualizada, ela já estava sendo observada e gerenciada 
> pelo Doctrine. Logo, quando fizemos as modificações em seus atributos, e chamamos o flush, o Doctrine pôde verificar 
> que houve modificações, e as realizou no banco.
