<?php

namespace BBM;

use BBM\Game,
    BBM\Play,
    BBM\Umpire,
    BBM\FactoryAbstract,
    BBM\TeamRepository,
    BBM\PlayerRepository,
    BBM\BallparkRepository;

/**
 * Game Factory
 * Create a game from various resources
 */
class GameFactory extends FactoryAbstract
{
    /**
     * Create a game from a Retrosheet file
     *
     * @param string[] $records
     * @return BBM\Game
     */
    public function createGameFromRetrosheetRecords($records)
    {
        // Get an instance of the Team and Site Respositories
        $teamRepository = new TeamRepository($this->em);
        $ballparkRepository = new BallparkRepository($this->em);
        $umpireRepository = new UmpireRepository($this->em);
        $playerRepository = new PlayerRepository($this->em);

        $game = new Game();

        // Loop through each of the records and create a record
        foreach ($records as $record)
        {
            // Break the record into fields
            $fields = $record;

            // Based on the record type, take appropriate action
            switch ($fields[0])
            {
                case 'id':
                    $game->setId($fields[1]);
                    break;
                case 'version':
                    if ($fields[1] != 2)
                        throw new \Exception('Incompatible Version: ' . $fields[1]);
                    break;
                case 'info':
                    switch($fields[1])
                    {
                        case 'visteam':
                            $game->setAwayTeam($teamRepository->findTeamByAbbr($fields[2]));
                            break;
                        case 'hometeam':
                            $game->setHomeTeam($teamRepository->findTeamByAbbr($fields[2]));
                            break;
                        case 'site':
                            $game->setBallpark($ballparkRepository->findBallparkById($fields[2]));
                            break;
                        case 'date':
                            $game->setGameStart(new \DateTime($fields[2]));
                            break;
                        case 'starttime':
                        case 'number':
                        case 'daynight':
                            // Ignore
                            break;
                        case 'usedh':
                            $game->setUseDH($fields[2]);
                            break;
                        case 'umphome':
                            $game->setHomePlateUmpire($umpireRepository->findUmpireById($fields[2]));
                            break;
                        case 'ump1b':
                            $game->setFirstBaseUmpire($umpireRepository->findUmpireById($fields[2]));
                            break;
                        case 'ump2b':
                            $game->setSecondBaseUmpire($umpireRepository->findUmpireById($fields[2]));
                            break;
                        case 'ump3b':
                            $game->setThirdBaseUmpire($umpireRepository->findUmpireById($fields[2]));
                            break;
                        case 'howscored':
                        case 'pitches':
                        case 'temp':
                        case 'winddir':
                        case 'windspeed':
                        case 'fieldcond':
                        case 'precip':
                        case 'sky':
                        case 'timeofgame':
                            //TODO
                            break;
                        case 'attendance':
                            $game->setAttendance($fields[2]);
                            break;
                        case 'wp':
                        case 'lp':
                        case 'save':
                            //TODO
                            break;
                        default:
                            print_r($fields);
                            throw new \Exception('Invalid info record: ' . $fields[1]);
                    }
                    break;
                case 'start':
                    break;
                case 'play':
                    $play = new Play();
                    $play->setInning($fields[1]);
                    $play->setTeam(($fields[2] == 0) ? $game->getAwayTeam() : $game->getHomeTeam());
                    $play->setPlayer($playerRepository->findPlayerById($fields[3]));
                    $play->setPitchCount($fields[4]);
                    $play->setPitches($fields[5]);
                    $play->setEvent($fields[6]);
                    $game->addPlay($play);
                    break;
                case 'sub':
                case 'com':
                case 'data':
                    //TODO
                    break;
                default:
                    throw new \Exception('Invalid Retrosheet Record Type: ' . $fields[0]);
            }
        }

        return $game;
    }
}
