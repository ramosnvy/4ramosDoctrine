<h1> Configurando o Gerenciador de Entidades</h1>

O Doctrine funciona identificando nossas classes como entidades de tabelas do banco de dados. Para isso funcionar precisamos fazer
algumas configurações iniciais.

Primeiro criamos uma pasta `"Helper"` dentro da pasta ``"src"``, dentro dessa pasta, criamos nosso ``EntityManagerFactory``, essa 
classe é a  base para a criação do nosso gerenciador de entidades.

~~~php 
<?php

namespace Alura\Doctrine\Helper;

class EntityManagerFactory
{

}
~~~ 

Agora para realizarmos a nossa conexão e configuração, devemos criar um método chamado `getEntityManager()`, ele retorna uma 
`EntityManagerInterface`, o retorno é um objeto que vai dar acesso a alguns métodos de manipulação e pesquisa no banco de dados.

Dentro desse método, vamos adicionar `$config`, ela recebe o retorno da função `createAnnotationMetadataConfiguration()`,
um método da classe ` Setup `, ela é padrão do Doctrine. Com esse método, estamos dizendo para o doctrine que queremos criar um gerenciador
baseado em anotações.

Devemos passar o local onde as entidades devem ser gerenciadas, e se estamos trabalhando em modo desenvolvedor.





~~~ php 

class EntityManagerFactory
{

    public function getEntityManager(): EntityManagerInterface
    {
        $rootDir = __DIR__ . '/../../';
        $config = Setup::createAnnotationMetadataConfiguration(
            [$rootDir . '/src'],
            true
        );
    }
}
~~~ 

Agora você pode cuidar da parte de conexão, só precisamos dizer para qual o driver que estamos utilizando, e o caminho 
para nosso banco de dados. Com isso feito, vamos criar um retorno do método `create()` do `EntityManager` padrão do Doctrine.

Esse método aceita 2 parâmetros, primeiro passamos a configuração de conexão, depois devemos passar a configuração do gerenciador.


~~~ php 

class EntityManagerFactory
{

    public function getEntityManager(): EntityManagerInterface
    {
        $rootDir = __DIR__ . '/../../';
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
}
~~~ 

Também precisamos criar um arquivo chamado `cli-config.php`na pasta raiz. Dentro dele vamos passar uma configuração simples.

~~~php 
<?php

use Alura\Doctrine\Helper\EntityManagerFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
~~~




* Anotações relacionadas: [Dia 1](../../diarioDeBordo/dia1.md)

__Lembrando que isso apenas configura e direciona a criação do gerenciados, ainda é preciso instânciar a entidade e chamar o método ` getEntityManager()`__