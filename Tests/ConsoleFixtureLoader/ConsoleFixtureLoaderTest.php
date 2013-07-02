<?php

namespace Funddy\Bundle\FixtureBundle\Tests\ConsoleFixtureLoader;

use Funddy\Bundle\FixtureBundle\ConsoleFixtureLoader\ConsoleFixtureLoader;
use Mockery as m;

class ConsoleFixtureLoaderTest extends \PHPUnit_Framework_TestCase
{
    const IRRELEVANT_FIXTURE_NAME = 'X';

    private $fixtureLoaderMock;
    private $outputMock;
    private $consoleFixtureLoader;
    private $dummyFixture;

    public function setUp()
    {
        $this->fixtureLoaderMock = m::mock('Funddy\Fixture\Fixture\FixtureLoader');
        $this->fixtureLoaderMock->shouldReceive('attach');
        $this->outputMock = m::mock('Symfony\Component\Console\Output\OutputInterface');
        $this->dummyFixture = m::mock('Funddy\Fixture\Fixture\Fixture');
        $this->consoleFixtureLoader = new ConsoleFixtureLoader($this->fixtureLoaderMock, $this->outputMock);
    }

    /**
     * @test
     */
    public function addFixture()
    {
        $this->fixtureLoaderAddFixtureShouldBeCalled();
        $this->consoleFixtureLoader->addFixture($this->dummyFixture);
    }

    private function fixtureLoaderAddFixtureShouldBeCalled()
    {
        $this->fixtureLoaderMock->shouldReceive('addFixture')->once()->with($this->dummyFixture);
    }

    /**
     * @test
     */
    public function loadAllShouldCallFixtureLoader()
    {
        $this->fixtureLoaderLoadAllShouldBeCalled();
        $this->consoleFixtureLoader->loadAll();
    }

    private function fixtureLoaderLoadAllShouldBeCalled()
    {
        $this->fixtureLoaderMock->shouldReceive('loadAll')->once()->withNoArgs();
    }

    /**
     * @test
     */
    public function fixtureLoadedShouldWriteOnOutput()
    {
        $this->outputWriteLnShouldBeCalledWith('Loaded <comment>X</comment>');
        $this->consoleFixtureLoader->fixtureLoaded(self::IRRELEVANT_FIXTURE_NAME);
    }

    private function outputWriteLnShouldBeCalledWith($message)
    {
        $this->outputMock
            ->shouldReceive('writeln')->once()->with($message);
    }
}
