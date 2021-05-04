## Dia 2 - Persistindo a primeira entidade. <h1>

Essa aula foi totalmente dedicada a como realizar o rastreio da classe, explicando para o Doctrine por anotações, 
como deve ser lida cada classe.

***Um passo importante antes de começarmos com as anotações, como já foi dito, as anotações são feitas por comentários, 
  mas existe uma pequena diferença entre comentários e anotações.***

~~~ php
    /*
     * Isso é um comentário.
     */
    
    /**
     * Isso é uma anotação.
     */
~~~ 

Comentários possuem um ```*```inicial a menos, é importante ficar ligeiro com esse detalhe.


*  No diretório do projeto, criamos a pasta commands. E dentro da pasta src, criamos a pasta Entity.

* Dentro da pasta Entity, criamos a classe Aluno, com o namespace Ramos\estudoDoctrine\Entity e fizemos a anotação 
  que identifica essa classe como entidade **@Entity**.
  
* Nessa classe, fizemos a atribuição privada de ```id``` (Inicializando o seu getter junto) e a atribuição de ```nome ```
  (Inicializando o seu getter e setter junto).
  
* Anotamos o ```id ``` com ```@Id```, ```@GeratedValue``` <- mostrando que ele possui um valor gerado automaticamente,
  ```@Column``` <- usada para definir algumas informações, damos o ele como um tipo Integer.
  
* Em ```nome ``` anotamos apenas  ```@Column```, damos seu valor como String.

~~~ php
?php


namespace Ramos\estudoDoctrine\Entity;

/**
 * @Entity
 */

class Aluno
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
    private $nome;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

}
~~~ 

* Para que o Doctrine consiga funcionar, ele precisa que exista um arquivo chamado **cli-config.php** na pasta raiz do 
projeto. 

~~~ php
<?php

use Alura\Doctrine\Helper\EntityManagerFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
~~~ 

Ele é um arquivo de configuração onde devemos passar algumas informações de conexão ao Doctrine.

Depois de realizar tudo isso, podemos criar nosso primeiro schema de banco de dados, Schemas são utilizados para gerir 
e organizar os objetos do banco de dados. Para criar, devemos ir ao terminal e rodar 
```vendor\bin\doctrine orm:schema-tool:create ```, esse é um dos milhares de comandos presentes no Doctrine. 


## Realizando a adição dos primeiros Alunos.<h2>

Para isso foi criado uma pasta chamada ```Commands```, onde irão ficar guardadas execuções de criação ou coisas 
relacionadas ao banco.crie o arquivo criar-aluno.php. Neste arquivo, receba, por parâmetro na linha de comando, 
o nome do aluno e implemente o código para inseri-lo no banco de dados:

~~~ php 
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

Nesse código é possível ver a presença de dois novos métodos, ```persist();``` e ```flush();```

 * ```persist();``` é responsável por monitorar as alterações realizadas em um atributo do banco de dados.

* ``` flush(); ```  é o método que faz o envio de todas as alterações para o banco. Quando executamos ele, queremos dizer
que todas as informações devem ser enviadas e atualizadas/guardadas pelo banco.
  

## Final dia 2 - Conclusões <h3>

Foi um dia que não encontrei problemas dentro do estudo, tudo ainda parece claro e tranquilo. Acredito ter conseguido 
tomar as melhores notas possíveis. 

Aprendemoos:

* Como implementar uma entidade.
  
* Informações sobre anotações.
  
* Com funcionam as anotações `@Id, @GeneratedValue e @Column`.
* A implementar o arquivo que faz a linha de comando do Doctrine funcionar.
* Como cria o schema do banco de dados.
* Como inserir uma entidade no banco.
