<?php

namespace Funddy\Bundle\FixtureBundle\ConsoleFixtureLoader;

use Funddy\Component\Fixture\Fixture\Fixture;
use Funddy\Component\Fixture\Fixture\FixtureLoader;
use Funddy\Component\Fixture\Observer\Observer;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 */
class ConsoleFixtureLoader implements Observer
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

    /**
     * @see Observer
     */
    public function update()
    {
        $fixtureName = $this->fixtureLoader->lastLoadedFixtureName();
        $this->output->writeln(sprintf('Loaded <comment>%s</comment>', $fixtureName));
    }
}