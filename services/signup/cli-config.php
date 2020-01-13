<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'src/Signup/Infrastructure/bootstrap.php';

$entityManager = ORM::instance()->getEntityManager();

$helperSet = ConsoleRunner::createHelperSet($entityManager);

return $helperSet;