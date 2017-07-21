<?php declare(strict_types = 1);

namespace LidskaSila\Prooph\Common;

interface Configurator
{

	public function getConfigKey(): ?string;

	public function buildDefaultConfig(): array;

	public function loadConfiguration(array $config): void;
}
