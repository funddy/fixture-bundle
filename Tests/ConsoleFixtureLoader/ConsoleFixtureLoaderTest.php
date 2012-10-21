<?php

namespace Funddy\Bundle\FixtureBundle\Tests\ConsoleFixtureLoader;

use Funddy\Bundle\FixtureBundle\ConsoleFixtureLoader\ConsoleFixtureLoader;
use Mockery as m;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 */
class ConsoleFixtureLoaderTest extends \PHPUnit_Framework_TestCase
{
    const IRRELEVANT_FIXTURE_NAME = 'XX';

    private $fixtureLoaderMock;
    private $outputMock;
    private $consoleFixtureLoader;
    private $dummyFixture;

    public function setUp()
    {
        $this->fixtureLoaderMock = m::mock('Funddy\Component\Fixture\Fixture\FixtureLoader');
        $this->fixtureLoaderMock->shouldReceive('attach');
        $this->outputMock = m::mock('Symfony\Component\Console\Output\OutputInterface');
        $this->dummyFixture = m::mock('Funddy\Component\Fixture\Fixture\Fixture');
        $this->consoleFixtureLoader = new ConsoleFixtureLoader($this->fixtureLoaderMock, $this->outputMock);
    }

    /**
     * @test
     */
    public function addFixture()
    {
        $this->fixtureLoaderAddFixtureShouldBeCalled();
        $this->assertEmpty($this->consoleFixtureLoader->addFixture($this->dummyFixture));
    }

    private function fixtureLoaderAddFixtureShouldBeCalled()
    {
        $this->fixtureLoaderMock->shouldReceive('addFixture')->once()->with($this->dummyFixture);
    }

    /**
     * @test
     */
    public function loadAll()
    {
        $this->fixtureLoaderLoadAllShouldBeCalled();
        $this->assertEmpty($this->consoleFixtureLoader->loadAll());
    }

    private function fixtureLoaderLoadAllShouldBeCalled()
    {
        $this->fixtureLoaderMock->shouldReceive('loadAll')->once()->withNoArgs();
    }

    /**
     * @test
     */
    public function update()
    {
        $this->fixtureLoaderLastLoadedFixtureNameShouldBeCalled();
        $this->outputWriteLnShouldBeCalled();
        $this->assertEmpty($this->consoleFixtureLoader->update());
    }

    private function fixtureLoaderLastLoadedFixtureNameShouldBeCalled()
    {
        $this->fixtureLoaderMock
            ->shouldReceive('lastLoadedFixtureName')->once()->withNoArgs()->andReturn(self::IRRELEVANT_FIXTURE_NAME);
    }

    private function outputWriteLnShouldBeCalled()
    {
        $this->outputMock
            ->shouldReceive('writeln')->once();
    }
}
