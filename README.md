FunddyFixtureBundle
===================

[![Build Status](https://secure.travis-ci.org/funddy/fixture-bundle.png?branch=master)](http://travis-ci.org/funddy/fixture-bundle)

Fixtures bundle for [Funddy fixture component].

Setup and Configuration
-----------------------
Add the following to your composer.json file:
```json
{
    "require": {
        "funddy/fixture-bundle": "2.0.*"
    }
}
```
Update the vendor libraries:

    curl -s http://getcomposer.org/installer | php
    php composer.phar install

For finishing, register the Bundle FunddyFixtureBundle in app/AppKernel.php.
```php
// ...
public function registerBundles()
{
    $bundles = array(
        // ...
        new Funddy\Bundle\FixtureBundle\FunddyFixtureBundle()
        // ...
    );
    // ...
}
```

Usage
-----
Create your fixture definition
```php
<?php

namespace Acme\DemoBundle\Fixture;

use Acme\DemoBundle\Service\UserService;
use Funddy\Fixture\Fixture\Fixture;

class UserFixture extends Fixture
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function load()
    {
        $user = $this->userService->create('keyvan@funddy.com', 'Keyvan Akbary');
        $this->addReference($user, 'user-keyvan');
    }

    public function getOrder() {
        return 0;
    }
}
```

Define your fixtures as services and inject dependencies
```yaml
services:
    acme.demobundle.fixture.userfixture:
        class: Acme\DemoBundle\Fixture\UserFixture
        arguments:
            - @acme.demobundle.service.userservice
        calls:
            - [ setFixtureLinker, [@funddy.component.fixture.fixturelinker] ]
```

Create a fixtures loader command
```php
namespace Acme\DemoBundle\Command;

use Funddy\Bundle\FixtureBundle\ConsoleFixtureLoader\ConsoleFixtureLoader;
use Funddy\Fixture\Fixture\FixtureLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesLoadCommand extends ContainerAwareCommand
{
    private static $fixtureServiceNames = array(
        'acme.demobundle.fixture.userfixture'
    );

    protected function configure()
    {
        $this
            ->setName('acme:fixtures:load')
            ->setDescription('Load all fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixtureLoader = new ConsoleFixtureLoader(new FixtureLoader(), $output);
        $this->loadFixtureServicesIntoLoader($fixtureLoader);
        $fixtureLoader->loadAll();
    }

    private function loadFixtureServicesIntoLoader($fixtureLoader)
    {
        foreach (self::$fixtureServiceNames as $fixtureServiceName) {
            $fixtureLoader->addFixture($this->getContainer()->get($fixtureServiceName));
        }
    }
}
```

That's all, time to load your fixtures through your own command ```acme:fixtures:load```.

  [Funddy fixture component]:  https://github.com/funddy/fixture