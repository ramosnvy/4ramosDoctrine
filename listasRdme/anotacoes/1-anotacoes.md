<h1>Anotações</h1>

Anotações são uma das formas de identificação do gerenciador de entidades, para que isso funcione, precisamos passar as 
tags corretas. Se você deseja entender mais sobre cada identificador, acesse esse 
[site](https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/annotations-reference.html).

Um exemplo de uso de anotações:

~~~php 
<?php


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


}
~~~ 

* @Entity, define nossa classe como uma entidade do banco de dados.
* @Id, define esse atributo como um identificador único.
* @GeneratedValue, diz que ele é um valor gerado randomicamente pelo banco de dados.
* @Column, utilizamos para definir atributos dessa coluna.

<h4> </h4>

* Anotações relacionadas: [Dia 2](../../diarioDeBordo/dia2.md)
