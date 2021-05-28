
<h1> Dia 1 - Entendendo o Doctrine e criando a primeira conexão</h1>

Nesse primeiro dia de estudo adotamos uma convenção de negócios, em que as classes que representam as tabelas, devem ficar
dentro de uma pasta chamada "src". Dentro dela, criamos as configurações inicias do Doctrine, para que ele consiga se
conectar com o banco de dados, e com a classe configurada podemos gerenciar as nossas classes/objetos.

Colocamos o arquivo de configuração dentro de um pasta chamada "Helper". Nela, foi criada uma classe PHP chamada
EntityManagerFactory, essa classe é um gerenciador de entidades do Doctrine.


~~~php
<?php

namespace Alura\Doctrine\Helper;

class EntityManagerFactory
{

}
~~~

Dentro dessa classe existe apenas um método pública chamada de **getEntityManager**. O Doctrine funciona mapeando
as nossas entidades (objetos de négocio/ objetos presentes nas tabelas) para o banco de dados. Ele precisa de um
gerenciador de entidades para conseguir fazer isso, é isso que vamos fazer.

~~~php
class EntityManagerFactory
{
    public function getEntityManager(): EntityManagerInterface
    {
        return EntityManager::create($connection, $config);
    }
}
~~~

Esse método consegue nos retornar uma classe chamada **EntityManager**, dentro dele temos o como criar a nossa conexão com o banco e
realizar as configurações do gerenciador (Explicando locais onde ele deve procurar entidades).

Para criarmos as configurações podemos usar a classe **Setup**, ela é uma classe do Doctrine que possui um método
**createAnnotationMetadataCOnfiguration()**, esse método diz para o gerenciador usar as anotações (*"annotations"*)
como forma de buscar entidades.

No PHP, podemos adicionar informações extras a uma classe ou método utilizando os blocos de anotações. Por exemplo,
podemos dizer que o método **getEntityMAnager()** retorna um EntityManagerInterface, ou que ela lança algum tipo de execeção.

A anotação fica dentro de um comentário, ela vem antes de um **@** e recebe o nome da informação que está sendo adicionada.



~~~php
class EntityManagerFactory

    /**
     * @return EntityManagerInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function getEntityManager(): EntityManagerInterface
    {
        $config = Setup::createAnnotationMetadataConfiguration();
        return EntityManager::create($connection, $config);
    }
}
~~~

Foi criada uma variável chamada **$rootDIr** ela ficou responsável por receber o local
do diretório atual ( DIR . '/../..'  para suvir duas pastas acima desse diretório, indo para o diretório raiz).

Esse método ainda tem outros parâmetros. Um deles diz se estamos em modo de desenvolvimento ou não, essa informação pode
útil, pois temos mais informações quando estamos em modo de desenvolvimento (podemos perder performace com isso).

~~~php
public function getEntityManager(): EntityManagerInterface
{
    $rootDir = __DIR__ . '/../..';
    $config = Setup::createAnnotationMetadataConfiguration(
        [$rootDir . '/src'],
        true    /** Esse true é onde definimos se estamos em um hambiente desenvolvimento */
    );
    return EntityManager::create($connection, $config);
}
~~~

Agora temos a parte de configuraação finalizada, precisamos apenas da conexão.

A variável **$connection** recebe uma array, onde é informada o driver que estamos utilizando ( Uma das vantagens do ORM
é que não precisamos saber qual banco está sendo usado, pois poemos migrar de bancos de dados de forma transparente).
Na informação de conexão, vamos passar o driver que queremos utilizar.

Agora a variável precisa receber mais uma informação, essa informação é a localização onde o método pode manipular o banco.
Para isso criamos um **path** que recebe a localização do diretório do arquivo ***banco.sqlite***.

~~~php
public function getEntityManager(): EntityManagerInterface
{
    $rootDir = __DIR__ . '/../..';
    $config = Setup::createAnnotationMetadataConfiguration(
        [$rootDir . '/src'],
        true
    );
    $connection = [
        'driver' => 'pdo_sqlite',
        'path' => $rootDir . '/var/data/banco.sqlite'
    ];
    return EntityManager::create($connection, $config);
}
~~~

Fazemos então a criação de um diretório "var/data" no nosso projeto e realizamos os teste em um arquivo separado, mas
antes configuramos o composer.

~~~composer 
{
    "require": {
        "doctrine/orm": "^2.6"
    },
    "autoload": {
        "psr-4": {
            "Alura\\Doctrine\\": "src/"
        }
    }
}
~~~

Para checkar rodamos o compoer dumpautoload no terminal.

No arquivo de teste, importamos o autoload com **'require_once __DIR__ . '/vendor/autoload.php'**

~~~php
<?php

use Alura\Doctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManagerFactory->getEntityManager();
~~~   

Isso é o suficiente para estabelecer a conexão com o banco de dados. Agora podemos verificar métodos fornecidos pelo PDO,
utilizando o **getEntityManager()**.

~~~php
<?php

use Alura\Doctrine\Helper\EntityManagerFactory;

require_once __DIR__ . '/vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

var_dump($entityManager->getConnection());
~~~


<h3> Extra </h3>

Organização dos diretórios no fim do dia.

![](extras/diretorios.png)

<h2> Final do dia 1 - Conclusões</h2>

Aprendi como criar conexões com o banco de dados e tambêm sobre as funcionalidades disponíveis dentro do Doctrine, acredito
que seja algo extra, mas acabei aprendendo um pouco mais sobre Orientação aos objetos e algumas questões ficaram mais claras.
Tive problemas com o autoload e finalizei o dia um pouco mais cedo, busquei ajuda no forum e estou aguardando respostas.





