<?php

require_once __DIR__ . '/vendor/autoload.php';


use Ramos\estudoDoctrine\Helper\EntityManagerFactory;

$entityManagerFactory = new EntityManagerFactory();

$entityManagerFactory = $entityManagerFactory->getEntityManager();
var_dump($entityManagerFactory->getConnection());