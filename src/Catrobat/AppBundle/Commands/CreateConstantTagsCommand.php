<?php

namespace Catrobat\AppBundle\Commands;

use Catrobat\AppBundle\Services\CatrobatFileExtractor;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Catrobat\AppBundle\Entity\ProgramManager;
use Catrobat\AppBundle\Entity\UserManager;
use Catrobat\AppBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Process\Process;
use Catrobat\AppBundle\Entity\Program;
use Catrobat\AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Catrobat\AppBundle\Entity\FeaturedProgram;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Helper\ProgressBar;

class CreateConstantTagsCommand extends ContainerAwareCommand
{

    private $output;

    public function __construct(EntityManager $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('catrobat:create:tags')
            ->setDescription('Creating constant tags !');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $tag = new Tag();
        $tag1 = new Tag();
        $tag2 = new Tag();
        $tag3 = new Tag();
        $tag4 = new Tag();
        $tag5 = new Tag();

        $tag->setEn("Animation");
        $tag->setDe("Animation");
        $tag->setIt("Animation");
        $tag->setFr("Animation");

        $this->em->persist($tag);

        $tag1->setEn("Games");
        $tag1->setDe("Games");
        $tag1->setIt("Games");
        $tag1->setFr("Games");

        $this->em->persist($tag1);

        $tag2->setEn("Music");
        $tag2->setDe("Music");
        $tag2->setIt("Music");
        $tag2->setFr("Music");

        $this->em->persist($tag2);

        $tag3->setEn("Art");
        $tag3->setDe("Art");
        $tag3->setIt("Art");
        $tag3->setFr("Art");

        $this->em->persist($tag3);

        $tag4->setEn("Story");
        $tag4->setDe("Story");
        $tag4->setIt("Story");
        $tag4->setFr("Story");

        $this->em->persist($tag4);

        $tag5->setEn("Experimentel");
        $tag5->setDe("Experimentel");
        $tag5->setIt("Experimentel");
        $tag5->setFr("Experimentel");

        $this->em->persist($tag5);


        $this->em->flush();

        $this->writeln("Five basic tags added!");
    }


    private function executeSymfonyCommand($command, $args, $output)
    {
        $command = $this->getApplication()->find($command);
        $args['command'] = $command;
        $input = new ArrayInput($args);
        $command->run($input, $output);
    }

    private function executeShellCommand($command, $description)
    {
        $this->write($description." ('".$command."') ... ");
        $process = new Process($command);
        $process->setTimeout(3600);
        $process->run();
        if ($process->isSuccessful()) {
            $this->writeln('OK');

            return true;
        } else {
            $this->writeln('failed!');

            return false;
        }
    }

    private function write($string)
    {
        if ($this->output != null) {
            $this->output->write($string);
        }
    }

    private function writeln($string)
    {
        if ($this->output != null) {
            $this->output->writeln($string);
        }
    }
}
