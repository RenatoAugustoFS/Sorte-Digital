<?php

namespace App\Controller\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Concurso\EstadoConcurso\Aberto;
use App\Entity\Concurso\EstadoConcurso\EstadoConcurso;
use App\Repository\ConcursoRepository;
use App\Repository\EstadoConcursoRepository;
use App\Service\EntityFactory\ConcursoFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcursoController extends AbstractController
{
    private ConcursoFactory $concursoFactory;
    private EntityManagerInterface $entityManager;
    private ConcursoRepository $concursoRepository;

    public function __construct(
        ConcursoFactory $concursoFactory,
        EntityManagerInterface $entityManager,
        ConcursoRepository $concursoRepository,
        EstadoConcursoRepository $estadoConcursoRepository
    ) {
        $this->concursoFactory = $concursoFactory;
        $this->entityManager = $entityManager;
        $this->concursoRepository = $concursoRepository;
    }

    public function formularioCriarConcurso(Request $request): Response
    {
        return $this
            ->render(
                '/concursos/formulario-inserir-concurso.html.twig'
            );
    }

    public function criarNovoConcurso(Request $request): Response
    {
        try {
            $concurso = $this->concursoFactory->criarConcurso($request);
            $this->entityManager->persist($concurso);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash('notice', $exception->getMessage());
            return $this->redirectToRoute('formulario-concurso');
        }

        $this->addFlash('notice', 'Parabéns! Concurso Criado Com Sucesso!');
        return $this->redirectToRoute('home');
    }

    public function buscarConcursos(Request $request): Response
    {
        $concursosAbertos = $this->concursoRepository->findConcursosAbertos();
        $concursosEmAndamento = $this->concursoRepository->findConcursosEmAndamento();
        $concursosFechados = $this->concursoRepository->findConcursosFechados();

        return $this->render('/home/index.html.twig', [
            'h1_name' => 'Página inicial',
            'concursosAbertos' => $concursosAbertos,
            'concursosEmAndamento' => $concursosEmAndamento,
            'concursosFechados' => $concursosFechados,
        ]);
    }

    public function concursoPorId(int $id): Response
    {
        $concurso = $this->concursoRepository->findOneBy(['id' => $id]);

        if (is_null($concurso)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $dezenas = [1,2,3,4,5,6,7,8,9,10];
        $cartela = new Cartela(
            'Renato',
            '123456789',
            'renatoaugusto@ads.gmail.com',
            $dezenas
        );

        $concurso->addCartela($cartela);

        $this->entityManager->flush();



        return $this
            ->render(
                '/concursos/concurso-por-id.html.twig',
                ['concurso' => $concurso]
            );
    }
}