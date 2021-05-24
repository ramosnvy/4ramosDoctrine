<h1> Dia 6 </h1>

<h2> Otimização com DQL </h2>

Nesse capítulo descobrimos algumas formas de otimizar as querys que são passadas para o banco de dados.

DQL é basicamente uma maneira de passar querys para o Doctrine, sem precisar criar diversas querys, com isso podemos trazer 
mais informações de uma só maneira. 

Podemos criar uma query da seguinte maneira: 

~~~ php 
$classeAluno =  Aluno::class;
$dql = "SELECT aluno, telefones, cursos FROM $classeAluno aluno JOIN aluno.telefones telefones JOIN aluno.cursos cursos";
~~~ 

Nessa query, estamos pedindo para que o banco pegue a tabela aluno, telefones e cursos da entidade Aluno.

Para mandarmos a query:

~~~php 
$query = $entityManager->createQuery($dql);
/*
 *@var Aluno[] $alunos
 */
$alunos = $query->getResult();
~~~
 Dessa maneira o retorno dessa query retorna um objeto do tipo Aluno.
 
DQL é um maneira muito boa quando se precisa realizar uma consulta pontual com muitos relacionamentos.

<h2> Formatos de busca do Doctrine </h2>

Com o parâmetro fetch, é possível informarmos qual o formato de busca que o Doctrine deverá utilizar. Por padrão, esse 
parâmetro recebe o valor LAZY (preguiçoso), ou seja, ele só busca os telefones se isso realmente for necessário. 
Mudaremos esse valor para EAGER (ansioso), de modo que o Doctrine trará os telefones imediatamente junto com a busca por
$aluno.

~~~ php 

Class Aluno
{

/**
 * @OneToMany(targetEntity="Telefone", mappedBy="Aluno", cascade="remove", {"persist"}, fetch="EAGER")
 */
private $telefones;
~~~ 

