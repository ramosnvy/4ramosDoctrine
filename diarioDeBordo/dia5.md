<h1>Dia 5 - Relacionamento ManyToMany</h1>

<h2> ManyToMany </h2>

Trata-se de um dos tipos de relacionamento dentro do banco de dados, de uma maneira abstrata, é uma relação de muitos 
para muitos. Resumidamente, a EntidadeA pode conter muitas versões da EntidadeB, e a EntidadeB pode ter muitas versõe
da EntidadeA.

<h2> Voltando ao curso </h2>

Criamos a entidade Curso e realizamos a adição dos seus setters e getters, tipagem e finalizamos com a adição das anotações.

~~~ php 
<?php


namespace Alura\Doctrine\Entity;

/**
 * @Entity
 */

class Curso
{

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;
    /**
     * @@Column(type="string")
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

Como um curso também possui alunos, criamos um atributo prrivado $alunos nessa classe. Essa entidade tem uma relação no plural
portanto fazemos a inicialização dela como um ArrayCollection.

~~~ php 

class Curso
{

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;
    /**
     * @@Column(type="string"
     */
    private $nome;

    private $alunos;

    public function __construct()
    {
        $this->alunos = new ArrayCollection();
    }
~~~

Definimos agora o tipo de relação, nesse caso uma relação `ManyToMany`.

~~~ php 
private $nome;

/**
 * @ManyToMany(targetEntity="Aluno")
 */

private $alunos;
~~~ 

Logo em seguida, realizamos a criação do setter e getters.

~~~ php 
public function addAluno(Aluno $aluno)
{
    $this->alunos->add($aluno)
        return $this;
}

public function getAluno()
{
    return $this->alunos;
}
~~~

Feito isso, temos que realizar as mesmas coisas na entidade Alunos, e relacionar cursos com ela. Uma das diferenças ocorre 
agora, devemos informar na entidade Aluno `cursos` é mapeado por `alunos`, já na entidade Curso, devemos dizer que `alunos`
é mapeado inversamente por `cursos`. Como fica isso?

~~~ php 
    /**
     * @ManyToMany(targetEntity="Curso", mappedBy="alunos")
     */
    private $cursos;
~~~ 

~~~ php 
class Curso
{

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;
    /**
     * @@Column(type="string"
     */
    private $nome;

    /**
     * @ManyToMany(targetEntity="Aluno", inversedBy="cursos")
     */

    private $alunos;

~~~

Na entidade Aluno temos um método addCurso(). Quando esse método adiciona um $curso que já existe na lista, ele não faz mais nada, continuando a execução do código sem problemas. Já se esse $curso não existe na lista, ele é adicionado, e adiciona o próprio $aluno como um dos alunos desse curso.

A mesma coisa acontece com addAluno(). Se o $aluno já existir na lista alunos, o método não fará nada. Se não, o $aluno será adicionado à lista, e esse $curso será adicionado à lista de cursos do Aluno. Porém, como o $curso já estará presente na lista, o ciclo será quebrado.

Já temos uma adição de alunos, uma adição de cursos e uma busca de alunos. Precisamos, então, de um método que busque os cursos. Na classe Aluno, criaremos o método getCursos() que retornará uma Collection do Doctrine com os cursos desse aluno. Aproveitaremos também para tipar o retorno de addCurso(), que é a própria instância de $curso:

~~~ php 
public function addCurso(Curso $curso): self
{

    if ($this->cursos->contains($curso)) {
        return $this;
    }

    $this->cursos->add($curso);
    $curso->addAluno($this);

    return $this;
}

public function getCursos(): Collection
{
    return $this->cursos;
}
~~~

Da mesma forma que fizemos com o Telefone, vamos garantir que esse mapeamento está funcionando sem erros. Para isso, executaremos vendor\bin\doctrine orm:înfo no Terminal. Como retorno, teremos uma mensagem informando que 3 entidades foram mapeadas, o que significa que, aparentemente, todos os nossos mapeamentos estão corretos. Se quisermos mais informações, podemos chamar vendor\bin\doctrine orm:mapping:describe Curso. Assim poderemos analisar, por exemplo, todas as relações, checando que relações são essas, qual o campo, como os dados serão unidos no banco de dados, qual o atributo que inverte essa relação, se existirão operações em cascata ou não, entre outras.

