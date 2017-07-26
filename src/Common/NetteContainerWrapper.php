<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Common;

use LidskaSila\Prooph\Common\NetteContainerWrapper\ContainerException;
use LidskaSila\Prooph\Common\NetteContainerWrapper\NotFoundException;
use Nette\DI\Container;
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
	public function get($key)
	{
		try {
			return $this->tryToGetByKey($key);
		} catch (MissingServiceException $e) {
			throw new NotFoundException($e->getMessage());
		} catch (Throwable $e) {
			throw new ContainerException($e->getMessage());
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($key)
	{
		if ($this->isKeyConfig($key)) {
			return (bool) $this->config;
		}
		if ($this->isServiceId($key)) {
			return $this->container->hasService($this->extractServiceId($key));
		}

		return (bool) $this->container->getByType($key);
	}

	private function tryToGetByKey($key)
	{
		if ($this->isKeyConfig($key)) {
			return $this->config;
		}
		if ($this->isServiceId($key)) {
			return $this->container->getService($this->extractServiceId($key));
		}

		return $this->container->getByType($key);
	}

	private function isKeyConfig(string $key): bool
	{
		return $key === 'config';
	}

	private function isServiceId(string $key): bool
	{
		return strpos($key, '@') === 0;
	}

	private function extractServiceId(string $key): string
	{
		return ltrim($key, '@');
	}
}
