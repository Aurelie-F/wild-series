<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $episode = new Episode();
            $episode->setNumber($faker->numberBetween(1, 10));
            $title = $faker->realText(100);
            $episode->setTitle($title);
            $episode->setSynopsis($faker->realText(300));
            $episode->setSeason($this->getReference('season_' . rand(0, 19)));
            $slug = $this->slugify->generate($title);
            $episode->setSlug($slug);
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SeasonFixtures::class];
    }
}