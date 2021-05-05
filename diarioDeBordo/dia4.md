<h1>Dia 4 - Relacionamento OneToMany</h1>

Criamos uma entidade em uma nova classe Telefone.php. Fizemos a inicialização dos getters e setters, a ideia dessa 
entidade é estar liga ao aluno, para gerenciar seus telefones.

~~~ php 
<?php


namespace Ramos\estudoDoctrine\Entity;


/**
 *@Entity
 */
class Telefone
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
     private $id;
     
    /**
     * @Column(type="string")
     */
    private $numero;

    public function getId(): int
    {
        return $this->id;
    }


    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }


    public function getNumero(): string
    {
        return $this->numero;
    }


    public function setNumero(string $numero): self
    {
        $this->numero = $numero;
        return $this;
    }
}
~~~ 

Agora passaremos para a questão do ManyToOne e OneToMany, ela está relacionada entre as tabelas Alunos e Telefones, 
são uma forma de mostrar como uma das tabelas corresponde a outra, se 1 aluno pode ou não ter mais de 1 telefone e se
1 telefone pode estar em muitos alunos.

Como um Aluno pode ter vários telefones, adicionaremos um atributo privado $telefones a essa entidade e criaremos um 
método addTelefone() que recebe por parâmetro um objeto $telefone.

Sempre que temos uma relação no Doctrine na qual um dos lados está no plural (ou seja, é uma coleção), nós definimos o 
tipo dele como uma coleção do Doctrine. Para isso, criaremos o construtor dessa classe e definiremos que 
$this->telefones receberá uma nova coleção do Doctrine.

ArrayCollection é uma coleção do Doctrine que se comporta como um array e oferece algumas funcionalidades.

~~~php 
public function __construct()
{
    $this->telefones = new ArrayCollection();
}
~~~ 

Podemos utilizar alguns dos métodos para criar funções que ajudem a adicionar e recuperar os telefones.

~~~ php 
public function getTelefones(): Collection
{
    return $this->telefones;
}

public function addTelefone(Telefone $telefone)
{
    $this->telefones->add($telefone);
    return $this;
}
~~~ 

Precisamos informar também a qual entidade essa relação está ligada.

~~~ php 
    /**
     * @OneToMany(targetEntity="Telefone")
     */
    private $telefones;

~~~ 

No nosso código, estamos dizendo que um Aluno tem vários $telefones. Portanto, isso significa que um Telefone pertence 
a um Aluno, e precisamos informar isso naquela entidade. Assim, em Telefone, criaremos um atributo privado $aluno e 
adicionaremos uma anotação @ManyToOne(targetEntity="Aluno") - ou seja, uma relação na qual muitos telefones podem ser 
mapeados para um Aluno, que é a entidade alvo.

~~~ php 
    /**
     * @ManyToOne(targetEntity="Aluno")
     */
    private $aluno;
~~~ 

Agora para finalizar essa configuração, precisamos dizer na entidade Aluno, que o `$telefones` é mapeada pelo Aluno.

~~~ php 
    /**
     * @OneToMany(targetEntity="Telefone", mappedBy="Aluno")
     */
    private $telefones;

~~~

<h2> Migrations </h2>

Migrations são controladores de versões para bancos de dados, podem ser úteis quando se trabalha em equipe.

<h2> Atualizando o CRUD do Aluno </h2>

Como já temos o código que insere alunos, tudo que precisaremos fazer é adicionar também um telefone. 

~~~ php 
<?php

use Ramos\estudoDoctrine\Entity\Aluno;
use RAmos\estudoDoctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$aluno = new Aluno();
$aluno->setNome($argv[1]);

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

$entityManager->persist($aluno);

$entityManager->flush();
~~~ 

Faremos um for iniciando na posição 2, já que a posição 1 já será ocupada pelo nome. Vamos iterar enquanto i for menor que argc, uma variável que contém o número de argumentos recebidos na linha de comando.

Repare que desde sempre estamos pegando os argumentos a partir da posição 1, mas arrays normalmente começam pelo índice 
0 Estamos fazendo isso pois o índice 0 é o nome do arquivo que está sendo executado (e o argc leva isso em consideração). 
   Se passarmos dois telefones, teremos, portanto, 4 argumentos, e o nosso for, a partir do segundo, iterar incrementando
   1 enquanto $i for menor que 4.

No corpo, informaremos que o $numeroTelefone pode ser encontrado em $argv[i]. Então, criaremos uma instância de Telefone
e chamaremos setNumero() passando $numeroTelefone como argumento. Por fim, adicionaremos o $telefone ao $aluno por meio do método addTelefone().

~~~  php 
for ($i = 2; $i < $argc; $i++) {
    $numeroTelefone = $argv[$i];
    $telefone = new Telefone();
    $telefone->setNumero($numeroTelefone);

    $aluno->addTelefone($telefone);

}
~~~ 
 
Seremos informados de um erro de persistência, como o Doctrine não estava de olho no ` $telefone`, agora ele acha estranho essa adição.
Para corrigir esse problema poderiamos chamar o método `persist()` fazendo com que o Doctrine observe determinada entidade, 
mas não estamos acessando o banco de dados e inserindo os dados nele. 

Mas existe uma opção, ao invés de chamarmos o persist() para cada entidade "filha" do Aluno, trabalharemos no mapeamento 
de Aluno. Na relação @OneToMany com Telefones, informaremos que queremos que algumas operações aconteçam em cascata - ou 
seja, cascade. Essas operações serão remove (toda vez que removermos um aluno, todos os telefones dele serão excluídos) e 
persist (toda vez que inserirmos um aluno, todos os telefones relacionados a ele também deverão ser inseridos).

~~~php 
private $nome;
/**
 * @OneToMany(targetEntity="Telefone", mappedBy="Aluno", cascade={"remove", "persist"})
 */
private $telefones;
~~~ 

Feito isso, podemos remover todos os métodos de persist do laço.

`` ---------------------------------------------------------------------------``

Agora só falta atualizar o modelo de buscas dos alunos.

Agora, se executarmos php commands\buscar-alunos.php, teremos "Vinicius Dias" como retorno, mas não os telefones que 
inserimos no banco. Para resolvermos isso, no foeach de buscar-alunos.php, criaremos uma variável $telefones recebendo a
chamada do método getTelefones(), que retorna uma coleção de objetos do tipo telefone.

Queremos um array de strings, de forma que possamos, na exibição, simplesmente chamar um implode($telefones),
utilizando uma vírgula para separar os itens desse array. Como exemplo, criaremos um array qualquer e comentaremos a 
linha em que chamamos o getTelefones().

~~~php 
foreach ($alunoList as $aluno) {
    //$telefones = $aluno->getTelefones();
    $telefones = ['telefone1', 'telefone2'];
    echo "ID: {$aluno->getId()}\nNome: {$aluno->getNome()}\n\n";
    echo "Telefones: " . implode(',', $telefones);
}
~~~

O Doctrine possui um método chamado map(), que recebe uma função que transforma o seu retorno no novo índice do array - 
ou seja, ela vai retornar uma nova coleção modificada pela nossa edição, que no caso será um Telefone $telefone.

Chamaremos o método getTelefones que retorna uma coleção, a partir da qual chamaremos o map(), que recebe uma function() 
cujo parâmetro será Telefone $telefone. O retorno dessa função será a chamada de getNumero() a partir de $telefone. 
Assim, a partir de agora a nossa lista de $telefones será uma lista de strings. Entretanto, ela continuará sendo uma 
lista do Doctrine, e não poderemos usar o implode() com ela.

ara transformar essa lista em um array, basta chamarmos o método toArray(). Com esse array de telefones, podemos 
chamar o implode() e colá-los com vírgula.



~~~ php 
foreach ($alunoList as $aluno) {
    $telefones = $aluno
        ->getTelefones()
        ->map(function (Telefone $telefone){
            return $telefone->getNumero();
        })
        ->toArray();

    echo "ID: {$aluno->getId()}\nNome: {$aluno->getNome()}\n\n";
    echo "Telefones: " . implode(',', $telefones);
}
~~~ 

<h2> Dia 4 - Conclusões.</h2>

Tive uma ideia mais ampla de como podem ser feitas as ligações entre diferentes tabelas no banco de daddos, dando acesso
a objetos e métodos. Falamos um pouco sonre o OneToMany e sobre o ManyToOne, que são formas de descrever e dizer ao Doctrine,
como a relação entre as duas tabelas ocorrem. Por fim demos uma atualizada no CRUD, onde tivemos praticamente 100% focados
na Orientação a Objetos, durante essa parte do caminho eu tive várias dúvidas, onde precisei rever algumas coisas para entender
todas as ligações feitas, acredito ter conseguido absorver grande parte contéudo de hoje, tentarei investir mais tempo em alguns
conteúdos sobre Orientação a Objetos.