<?php 

namespace AppBundle\Manager;


abstract class ManagerInterface
{

    abstract public function find($id);


    abstract public function findBy(array $criteres);


    abstract public function findOneBy(array $critere);


    abstract public function remove($entity);


    abstract public function persist($entity, $flush = true);


}