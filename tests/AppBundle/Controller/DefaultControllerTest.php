<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\NoteBook;
use AppBundle\Entity\User;
use AppBundle\Manager\NoteBookManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Console\Input\StringInput;

class DefaultControllerTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;


    protected static $application;

    /**
     * @return NoteBookManager
     */
    public function notebookManager()
    {
        $manager = static::$kernel->getContainer()
            ->get('notebook_manager');

        return $manager;
    }


    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet --env=test', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

    public function setUp()
    {
        self::bootKernel();

        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:update --force');

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @return User
     */
    public function createUser()
    {
        $user = new User();

        $user->setName('Sylva');
        $user->setLastname('Etokabeka');
        $user->setEmail('etosylva@yahoo.fr');
        $user->setPassword('password');
        $user->setEnabled(true);
        $notebook = new NoteBook();
        $notebook->setName('Default');
        $user->addNotebook($notebook);
        $this->em->persist($user);
        $this->em->flush();

        return $this->em->getRepository('AppBundle:User')->findOneBy(['name' => $user->getName()]);
    }


    public function testUserAsNotebookDefault()
    {
        $user = $this->createUser();
        foreach ($user->getNotebooks() as $notebook) {
            if ($notebook->getName() == NoteBook::DEFAULT_NOTEBOOK) {

                $this->assertEquals(NoteBook::DEFAULT_NOTEBOOK, $notebook->getName());

                break;
            }
        }

        $this->assertEquals(1, $user->getNotebooks()->count());
    }


    public function testCreateNotebook()
    {
        $notebook = new NoteBook();
        $notebook->setName('Default');
        $this->em->persist($notebook);
        $this->em->flush();

        $notebook = $this->em->getRepository('AppBundle:NoteBook')->findAll();

        $this->assertEquals(1, count($notebook));
    }


    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {

        self::runCommand('doctrine:database:drop --force');
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
