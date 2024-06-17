<?php

namespace App\DataFixtures;

use App\Entity\Options;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $defaultOptions = [
            'api_key' => [],
            'api_url' => ["https://www.goldapi.io/api"],
            'mnemonic_commodity' => ["XAU", "XAG", "XPT", "XPD"],
            'mnemonic_currency' => ["EUR"]
        ];

        foreach ($defaultOptions as $name => $value) {
            $options = new Options();
            $options->setName($name);
            $options->setValue($value);
            $manager->persist($options);
        }

        $manager->flush();
    }
}
