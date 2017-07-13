<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Common;

use Exception;
use LidskaSila\Prooph\Common\NetteContainerWrapper\ContainerException;
use LidskaSila\Prooph\Common\NetteContainerWrapper\NotFoundException;
use Nette\DI\Container;
use Nette\DI\ContainerBuilder;
use Nette\DI\MissingServiceException;
use Psr\Container\ContainerInterface;
use Throwable;

class NetteContainerWrapper implements ContainerInterface
{

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var array
	 */
	private $config;

	public function __construct(array $extensionConfig, Container $container)
	{
		$this->config    = $extensionConfig;
		$this->container = $container;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($id)
	{
		try {
			if ($this->isIdConfig($id)) {
				return $this->config;
			} elseif (strpos($id, '@') === 0) {
				return $this->container->getService(ltrim($id, '@'));
			} else {
				return $this->container->getByType($id);
			}
		} catch (MissingServiceException $e) {
			throw new NotFoundException($e->getMessage());
		} catch (Throwable $e) {
			throw new ContainerException($e->getMessage());
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($id)
	{
		if ($this->isIdConfig($id)) {
			return (bool) $this->config;
		} elseif (strpos($id, '@') === 0) {
			return $this->container->hasService(ltrim($id, '@'));
		} else {
			return (bool) $this->container->getByType($id);
		}
	}

	private function isIdConfig($id): bool
	{
		return $id === 'config';
	}
}
