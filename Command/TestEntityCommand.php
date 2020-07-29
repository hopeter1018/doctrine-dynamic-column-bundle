<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\Command;

use DateTime;
use EasternColor\Img360V1Bundle\Entity\ContactUs;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestEntityCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
          ->setName('hopeter1018:doctrine:dynamic-column:test-entity')
          // ->setDescription('Clean Up AppStorage stored in S3')
          // ->setHelp('This command is to Clean Up AppStorage stored in S3')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('DoctrineDynamicColumn Test');

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $meta = $em->getClassMetadata(ContactUs::class);

        $contactUs = $em->getRepository(ContactUs::class)->find(19);
        $contactUs->s1 = 's0'.date('Y-m-d-H-i-s');
        $em->persist($contactUs);
        $em->flush();

        usleep(200);
        $contactUs->s1 = 's1'.date('Y-m-d-H-i-s');
        $em->persist($contactUs);
        $em->flush();

        usleep(200);
        $contactUs->s1 = 's2'.date('Y-m-d-H-i-s');
        $em->persist($contactUs);
        $em->flush();

        // $em->remove($contactUs);
        // $em->flush();
        //
        // $temp = new ContactUs();
        // $temp
        //   ->setProjectName('123')
        //   ->setContactName('234')
        //   ->setContactNumber('contactNumber')
        //   ->setContactEmail('contactEmail')
        //   ->setHowKnowUs('howKnowUs')
        //   ->setMessage('message')
        //   ->setLocale('en')
        // ;
        // $temp->s1 = 's2';
        // $temp->b1 = false;
        // $temp->datee = new DateTime('2020-07-21');
        // dump($temp->s1, $temp->b1, $temp->datee, '==========');
        // $em->persist($temp);
        // $em->flush($temp);

        $io->text('Done.');
    }
}
