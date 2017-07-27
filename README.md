# LidskaSila/Prooph

[![Build Status](https://img.shields.io/travis/LidskaSila/Prooph.svg?style=flat-square)](https://travis-ci.org/LidskaSila/Prooph)
[![Quality Score](https://img.shields.io/scrutinizer/g/LidskaSila/Prooph.svg?style=flat-square)](https://scrutinizer-ci.com/g/LidskaSila/Prooph)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/LidskaSila/Prooph.svg?style=flat-square)](https://scrutinizer-ci.com/g/LidskaSila/Prooph)

Nette extension for <a href="https://github.com/prooph">prooph</a> toolbox family.

## Why bother?
<ol>
	<li>
		It allows you to 
		<a href="https://github.com/LidskaSila/Prooph/blob/master/docs/Configuration.md">
			configure prooph libraries through Nette *.neon config
		</a>
	</li>
	<li>
		It allows you to
		<a href="https://github.com/LidskaSila/Prooph/blob/master/docs/AsynchronousMessaging.md">
			configure routes for asynchronous messaging
		</a> with simple bridge interface to adapt your infrastructure.
	</li>
</ol>

<a href="https://github.com/LidskaSila/Prooph/blob/master/docs/KeepLearning.md">
	New to Prooph, DDD, CQRS or Event Sourcing? Hunting for inspiration and learning sources?
</a>

# Quick start

### 1) Install this Nette extension through composer
`composer require lidskasila/prooph`

### 2) Register package in your config.neon
```yaml
extensions:
    prooph: LidskaSila\Prooph\ProophExtension
```

## Documentation

<ol>
	<li>
		<a href="https://github.com/LidskaSila/Prooph/blob/master/docs/Configuration.md">
			Configuration
		</a>
	</li>
	<li>
		<a href="https://github.com/LidskaSila/Prooph/blob/master/docs/AsynchronousMessaging.md">
			Asynchronous messaging
		</a>
	</li>
</ol>

## Contribute

Please feel free to fork and extend existing or add new features and send a pull request with your changes! 
To establish a consistent code quality, please provide unit tests for all your changes and may adapt the documentation.
