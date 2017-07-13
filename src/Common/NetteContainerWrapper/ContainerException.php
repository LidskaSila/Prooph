<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Common\NetteContainerWrapper;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class ContainerException extends Exception implements NotFoundExceptionInterface
{

}
