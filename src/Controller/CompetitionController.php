<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Repository\CompetitionRepository;
use App\Repository\MatchesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/competition')]
class CompetitionController extends AbstractController
{
    #[Route('/', name: 'app_competition_index', methods: ['GET'])]
    public function index(CompetitionRepository $competitionRepository): Response
    {
        return $this->render('competition/index.html.twig', [
            'competitions' => $competitionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_competition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompetitionRepository $competitionRepository,EntityManagerInterface $entityManager): Response
    {
        $competition = new Competition();
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competitionRepository->save($competition, true);
            $competition->generateMatches();
            foreach ($competition->getMatches() as $match) {
                $entityManager->persist($match);
            }

           // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competition);
            $entityManager->flush();

            return $this->redirectToRoute('app_competition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competition/new.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_competition_show', methods: ['GET'])]
    public function show(Competition $competition,EntityManagerInterface $entityManager): Response
    {
            $teams=$competition->getTeams()->toArray();
        usort($teams, function($a, $b) {
            $check1=$b->getpoints_scored() == $a->getpoints_scored();
            if($check1==true)
            return$b->getgoal_average() <=> $a->getgoal_average() ;
            else return $b->getpoints_scored() <=> $a->getpoints_scored();
        });
            $competition->calculatestats();
            $competition->calculateGoalAverage();
            $competition->calculatepoints();
           // $entityManager->persist($competition);
        foreach ($competition->getTeams() as $team) {
            $entityManager->persist($team);
        }
            $entityManager->flush();

        return $this->render('competition/show.html.twig', [
            'competition' => $competition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_competition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Competition $competition, CompetitionRepository $competitionRepository): Response
    {
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competitionRepository->save($competition, true);

            return $this->redirectToRoute('app_competition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competition/edit.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_competition_delete', methods: ['POST'])]
    public function delete(Request $request, Competition $competition, CompetitionRepository $competitionRepository,MatchesRepository $matchesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competition->getId(), $request->request->get('_token'))) {
            foreach($competition->getMatches() as $match){
            $matchesRepository->remove($match,true);
            }
            $competitionRepository->remove($competition, true);
        }

        return $this->redirectToRoute('app_competition_index', [], Response::HTTP_SEE_OTHER);
    }

    private function getDoctrine()
    {
    }
}
