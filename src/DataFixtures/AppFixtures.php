<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Commentaire;
use App\Entity\IdentityUser;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Voyage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\ORM\Doctrine\Populator;
use FOS\UserBundle\Model\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;


/**
 * Class AppFixtures
 * NE PAS OUBLIER DE RELANCER LA COMMANDE SUIVANTE APRES CHAQUE CHANGEMENT DU FICHIER
 *
 *      php bin/console doctrine:fixtures:load
 *
 */
class AppFixtures extends Fixture
{
    private $userTMP;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userTMP = $userManager->createUser();
        $this->userTMP->setUsername('toto' . uniqid());
        $this->userTMP->setEmail('dd' . uniqid());
        $this->userTMP->setPlainPassword('toto');
        $userManager->updateUser($this->userTMP);
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $generator = \Faker\Factory::create();
        $populator = new Populator($generator, $manager);


        $populator->addEntity(IdentityUser::class, 1, [
            "user" => function () {  return $this->userTMP; }
        ]);

        //$populator->addEntity(Category::class, 10);
        $populator->addEntity(Tag::class, 10);




        $populator->addEntity(Voyage::class, 80, [
            "price" => function() use ($generator) {
                return $generator->randomFloat(2, 0, 99999999.99);
            },
            "imageName" => function() { return 'ss.jpg'; },
            "user" => function () {  return $this->userTMP; }
        ]);

        $populator->addEntity(Commentaire::class, 20);


        $populator->execute();


        //$manager->flush();
    }
}