<?php

namespace App\Controller;

use App\Entity\Matches;
use App\Form\MatchesType;
use App\Repository\MatchesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/matches')]
class MatchesController extends AbstractController
{
        #[Route('/UpdateStats',name: 'app_matches_Up',methods:['GET','POST'])]
        public function UpdateStats(Matches $match, EntityManagerInterface $entityManager){
            $team1=$match->getTeam1();
            $team2=$match->getTeam2();
            $score1=$match->getScore1();
            $score2=$match->getScore2();

            if($score1>$score2){
                $team1->setWins($team1->getWins()+1);
                $team2->setLosses($team2->getLosses()+1);
            }
            if($score1==$score2){
                $team1->setDraws($team1->getDraws()+1);
                $team2->setDraws($team2->getDraws()+1);
            }
            if($score1<$score2){
                $team1->setLosses($team1->getLosses()+1);
                $team2->setWins($team2->getWins()+1);
            }
            $entityManager->persist($team1);
            $entityManager->persist($team2);
            $entityManager->flush();
        }

    #[Route('/', name: 'app_matches_index', methods: ['GET'])]
    public function index(MatchesRepository $matchesRepository): Response
    {
        return $this->render('matches/index.html.twig', [
            'matches' => $matchesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_matches_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MatchesRepository $matchesRepository,EntityManagerInterface $entityManager): Response
    {
        $match = new Matches();
        $form = $this->createForm(MatchesType::class, $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // dd('jhon');

            $this->UpdateStats($match,$entityManager);
            $matchesRepository->save($match, true);

            return $this->redirectToRoute('app_matches_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('matches/new.html.twig', [
            'match' => $match,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_matches_show', methods: ['GET'])]
    public function show(Matches $match): Response
    {
        return $this->render('matches/show.html.twig', [
            'match' => $match,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_matches_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Matches $match, MatchesRepository $matchesRepository,EntityManagerInterface $entityManager): Response
    {   //$this->match=$match;
        $form = $this->createForm(MatchesType::class, $match);
        $form->handleRequest($request);
        $originalscore1=$match->getScore1();
        $originalscore2=$match->getScore2();
        if ($form->isSubmitted() && $form->isValid()) {

            $matchesRepository->save($match, true);
            $updatedscore1=$match->getScore1();
            $updatedscore2=$match->getScore2();
            if($originalscore1!=$updatedscore1||$originalscore2!=$updatedscore2){
                $this->UpdateStats($match,$entityManager);
            }
       // dd($originalscore1,$updatedscore1,$originalscore2,$updatedscore2);
            return $this->redirectToRoute('app_matches_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('matches/edit.html.twig', [
            'match' => $match,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_matches_delete', methods: ['POST'])]
    public function delete(Request $request, Matches $match, MatchesRepository $matchesRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$match->getId(), $request->request->get('_token'))) {
            $team1=$match->getTeam1();
            $team2=$match->getTeam2();
            $score1=$match->getScore1();
            $score2=$match->getScore2();

            if($score1>$score2){
                $team1->setWins($team1->getWins()-1);
                $team2->setLosses($team2->getLosses()-1);
            }
            if($score1==$score2){
                $team1->setDraws($team1->getDraws()-1);
                $team2->setDraws($team2->getDraws()-1);
            }
            if($score1<$score2){
                $team1->setLosses($team1->getLosses()-1);
                $team2->setWins($team2->getWins()-1);
            }
            $matchesRepository->remove($match, true);
        }

        return $this->redirectToRoute('app_matches_index', [], Response::HTTP_SEE_OTHER);
    }

//    private function setScore1(?\App\Entity\Team $team1)
//    {
//    }
//
//    private function setScore2(?\App\Entity\Team $team2)
//    {
//    }
}
