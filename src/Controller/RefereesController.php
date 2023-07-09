<?php

namespace App\Controller;

use App\Entity\Referees;
use App\Form\RefereesType;
use App\Repository\RefereesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/referees')]
class RefereesController extends AbstractController
{
    #[Route('/', name: 'app_referees_index', methods: ['GET'])]
    public function index(RefereesRepository $refereesRepository): Response
    {
        return $this->render('referees/index.html.twig', [
            'referees' => $refereesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_referees_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RefereesRepository $refereesRepository): Response
    {
        $referee = new Referees();
        $form = $this->createForm(RefereesType::class, $referee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refereesRepository->save($referee, true);

            return $this->redirectToRoute('app_referees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('referees/new.html.twig', [
            'referee' => $referee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_referees_show', methods: ['GET'])]
    public function show(Referees $referee): Response
    {
        return $this->render('referees/show.html.twig', [
            'referee' => $referee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_referees_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Referees $referee, RefereesRepository $refereesRepository): Response
    {
        $form = $this->createForm(RefereesType::class, $referee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refereesRepository->save($referee, true);

            return $this->redirectToRoute('app_referees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('referees/edit.html.twig', [
            'referee' => $referee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_referees_delete', methods: ['POST'])]
    public function delete(Request $request, Referees $referee, RefereesRepository $refereesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$referee->getId(), $request->request->get('_token'))) {
            $refereesRepository->remove($referee, true);
        }

        return $this->redirectToRoute('app_referees_index', [], Response::HTTP_SEE_OTHER);
    }
}
