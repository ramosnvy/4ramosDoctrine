<?php


namespace Ramos\estudoDoctrine\Repository;


use Doctrine\ORM\EntityRepository;
use Ramos\estudoDoctrine\Entity\Aluno;

class AlunoRepository extends EntityRepository
{
    public function buscaCursosPorAluno()
    {

        $query = $this->createQueryBuilder('a')
            ->join('a.telefones', 't')
            ->join('a.cursos', 'c')
            ->addSelect('t')
            ->addSelect('c')->getQuery();

        return $query->getResult();
    }
}