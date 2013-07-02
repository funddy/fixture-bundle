<?php

namespace Funddy\Bundle\FixtureBundle\ConsoleFixtureLoader;

use Funddy\Fixture\Fixture\Fixture;
use Funddy\Fixture\Fixture\FixtureLoader;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleFixtureLoader
{
    private $fixtureLoader;
    private $output;

    public function __construct(FixtureLoader $fixtureLoader, OutputInterface $output)
    {
        $this->fixtureLoader = $fixtureLoader;
        $this->fixtureLoader->attach($this);
        $this->output = $output;
    }

    public function addFixture(Fixture $fixture)
    {
        $this->fixtureLoader->addFixture($fixture);
    }

    public function loadAll()
    {
        $this->fixtureLoader->loadAll();
    }

    public function fixtureLoaded($fixtureName)
    {
        $this->output->writeln(sprintf('Loaded <comment>%s</comment>', $fixtureName));
    }
}