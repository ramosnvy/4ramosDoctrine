<?php


namespace Ramos\estudoDoctrine\Entity;

/**
 * @Entity
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
    /**
     * @ManyToOne(targetEntity="aluno")
     */
    private $aluno;


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

    public function getAluno(): Aluno
    {
        return $this->aluno;
    }


    public function setAluno($aluno): self
    {
        $this->aluno = $aluno;
        return $this;
    }
}
