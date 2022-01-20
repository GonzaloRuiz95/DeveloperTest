<?php

namespace App\Command;

use App\Entity\Ad;
use App\Services\AdQualityCalculator;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:update-score',
    description: 'This command provides dummy data for testing purpose',
)]
class UpdateScoreCommand extends Command
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

        $ads = $this->entityManager->getRepository(Ad::class)->findAll();
        $adQualityCalculator = new AdQualityCalculator();

        foreach ($ads as $ad)
        {
            $score = $adQualityCalculator->__invoke($ad);
            $ad->setScore($score);

            if ($score < 40) {
                $ad->setIrrelevantSince(new DateTimeImmutable());
            }

            if ($score >= 40 && !is_null($ad->getIrrelevantSince())){
                $ad->setIrrelevantSince(null);
            }

            $this->entityManager->persist($ad);

            $this->entityManager->flush($ad);

            $adsFormatter[] = [
                'id'               => $ad->getId(),
                'typology'         => $ad->getTipology(),
                'description'      => $ad->getDescription(),
                'size'             => $ad->getSize(),
                'garden-size'      => $ad->getGardenSize(),
                'irrelevant-since' => $ad->getIrrelevantSince(),
                'score'            => $ad->getScore()
            ];
        }

        echo json_encode($adsFormatter, JSON_PRETTY_PRINT) . PHP_EOL;

        $io->success('Success: Data Was Updated!');

        return Command::SUCCESS;
    }
}
