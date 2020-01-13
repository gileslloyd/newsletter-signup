<?php
declare(strict_types=1);

abstract class Controller
{
	/**
	 * @var League\Tactician\CommandBus
	 */
	protected $command_bus;

	/**
	 * @var League\Container\Container
	 */
	protected $container;

	public function __construct()
	{
		$this->command_bus = CommandBus::instance();
		$this->container = \DI\Container::instance();
	}

	protected function write(string $output): void
	{
		echo $output."\n";
	}
}
