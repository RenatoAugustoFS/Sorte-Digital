<?php

namespace App\Controller\Concurso;

use App\Repository\ConcursoRepository;
use App\Service\Cartela\CartelaDto;
use App\Service\Cartela\CartelaFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdicionarCartelaAoConcurso extends AbstractController
{
    private ConcursoRepository $concursoRepository;
    private EntityManagerInterface $entityManager;
    private CartelaFactory $cartelaFactory;

    public function __construct(ConcursoRepository $concursoRepository, EntityManagerInterface $entityManager, CartelaFactory $cartelaFactory)
    {
        $this->concursoRepository = $concursoRepository;
        $this->entityManager = $entityManager;
        $this->cartelaFactory = $cartelaFactory;
    }

    public function handle(int $id, Request $request): Response
    {
        $concurso = $this->concursoRepository->find($id);
        
        if(is_null($concurso)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $dezenas = $request->request->get('cb');
        $nomeJogador = $request->request->get('nome');
        $telefone = $request->request->get('telefone');
        $email = $request->request->get('email');

        try {
            $cartela = $this->cartelaFactory->criar(new CartelaDto($dezenas, $nomeJogador, $telefone, $email));
            $concurso->addCartela($cartela);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash('notice', $exception->getMessage());
            return $this->redirectToRoute('formulario-adicionar-cartela', ['id' => $id]);
        }

        return $this->render('/concurso/agradecimentos.html.twig', [
            'tokenCartela' => $cartela->token(),
            'concursoId' => $concurso->id(),
            ]);
    }
}