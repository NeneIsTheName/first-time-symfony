<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Pokemon;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pokemon = new Pokemon;
        $pokemon->setName("Bulbasaur");
        $pokemon->setDescription("For some time after its birth, it uses the nutrients that are packed into the seed on its back in order to grow.");
        $pokemon->setPokedexNumber(1);

        $manager->persist($pokemon);

        $pokemon = new Pokemon;
        $pokemon->setName("Ivysaur");
        $pokemon->setDescription("The more sunlight Ivysaur bathes in, the more strength wells up within it, allowing the bud on its back to grow larger.");
        $pokemon->setPokedexNumber(2);

        $manager->persist($pokemon);

        // $manager->persist($product);

        $manager->flush();
    }
}
