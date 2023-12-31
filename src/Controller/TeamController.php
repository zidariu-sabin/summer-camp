<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\MemberRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/team')]
class TeamController extends AbstractController
{
    #[Route('/', name: 'app_team_index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_team_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeamRepository $teamRepository,EntityManagerInterface $entityManager): Response
    {
        //  dd($request);
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
       // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);
            $team->generateplayers($entityManager);
//            foreach ($team->getMembers() as $member) {
//               // $entityManager->persist($member);
//            }
            //$entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    #[Route('/{id}', name: 'app_team_show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
     //   dd($team);
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, TeamRepository $teamRepository,MemberRepository $memberRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            foreach($team->getMembers() as $player){
                $memberRepository->remove($player,true);
            }
            $teamRepository->remove($team, true);
        }

        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/members', name: 'app_team_members', methods: ['GET'])]
    public function showMatches(Team $team, EntityManagerInterface $entityManager):Response
    {
        return $this->render('team/members.html.twig', [
            'team'=>$team,
            'members' => $team->getMembers(),
        ]);

    }
}
