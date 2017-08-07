<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Tests\ProjectionManager;

use Mockery;
use PDO;

class FakePDOFactory
{

	public static function create(): PDO
	{
		$fakePDO = Mockery::mock('\PDO');
		assert($fakePDO instanceof PDO);

		return $fakePDO;
	}
}
