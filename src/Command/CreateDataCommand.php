<?php

namespace App\Command;

use App\Entity\Ad;
use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-data',
    description: 'This command provides data for testing purpose',
)]
class CreateDataCommand extends Command
{
    /** @var EntityManagerInterface */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, string $name = null)
    {
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $ad1 = new Ad();
        $ad1->setTipology('Chalet');
        $ad1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $ad1->setSize('1200');
        $ad1->setGardenSize('150');
        $this->entityManager->persist($ad1);

        $ad2 = new Ad();
        $ad2->setTipology('Apartamento');
        $ad2->setDescription('Lorem ipsum dolor sit amet');
        $ad2->setSize('120');
        $this->entityManager->persist($ad2);

        $ad3 = new Ad();
        $ad3->setTipology('Apartamento');
        $ad3->setSize('120');
        $this->entityManager->persist($ad3);

        $picture1 = new Picture();
        $picture1->setAd($ad1);
        $picture1->setUrl('https://idealista.com/img/1');
        $picture1->setQuality('HD');
        $this->entityManager->persist($picture1);

        $picture2 = new Picture();
        $picture2->setAd($ad1);
        $picture2->setUrl('https://idealista.com/img/2');
        $picture2->setQuality('SD');
        $this->entityManager->persist($picture2);

        $picture3 = new Picture();
        $picture3->setAd($ad1);
        $picture3->setUrl('https://idealista.com/img/3');
        $picture3->setQuality('HD');
        $this->entityManager->persist($picture3);

        $picture4 = new Picture();
        $picture4->setAd($ad2);
        $picture4->setUrl('https://idealista.com/img/4');
        $picture4->setQuality('SD');
        $this->entityManager->persist($picture4);

        // Clear Unit Of Work
        $this->entityManager->flush();

        $io->success('Success: Data Was Inserted!');

        return COMMAND::SUCCESS;
    }
}
