<?php

namespace App\Controller\Concurso;

use App\Entity\SorteioOficial\MegaSena;
use App\Entity\SorteioOficial\Quina;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Concurso\Concurso;
use App\Entity\Concurso\PeriodoConcurso\Periodo;
use App\Entity\Concurso\RestricaoConcurso\RestricaoDezenasPorCartela;
use App\Repository\ConcursoRepository;
use App\Service\EntityFactory\ConcursoFactory;
use App\Entity\Cartela\Cartela;
use App\Entity\ValueObject\Jogador\Jogador;
use App\Entity\ValueObject\Email\Email;
use App\Entity\ValueObject\Telefone\Telefone;

class ConcursoController extends AbstractController
{
    private ConcursoFactory $concursoFactory;
    private EntityManagerInterface $entityManager;
    private ConcursoRepository $concursoRepository;

    public function __construct(
        ConcursoFactory $concursoFactory,
        EntityManagerInterface $entityManager,
        ConcursoRepository $concursoRepository
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

        $cartelas = $concurso->cartelas();
        $dezenasSorteadas = [1,5,6,8,10];
        $sorteiosOficiais = $concurso->sorteiosOficiais();

        return $this
            ->render(
                '/concursos/concurso-por-id.html.twig', [
                    'dezenasSorteadas' => $dezenasSorteadas,
                    'concurso' => $concurso,
                    'cartelas' => $cartelas,
                    'sorteiosOficiais' => $sorteiosOficiais,
                ]
            );
    }

    public function teste(): Response
    {
        try {
            $periodo = new Periodo(
                new \DateTimeImmutable('05/08/2022')
            );

            $restricao = new RestricaoDezenasPorCartela(10);

            $concurso = new Concurso('Concurso Malandragem', $periodo, $restricao);

            $telefone = new Telefone('9672180047');
            $email = new Email('renatoaugusto.ads@gmail.com');
            $jogador = new Jogador('Renato', $telefone, $email);

            $cartela = new Cartela([1,2,3,4,5,6,7,8,9,10], $jogador);

            $concurso->addCartela($cartela);

            $this->entityManager->persist($concurso);
            $this->entityManager->flush();
        } catch (\Exception $e){
            $this->addFlash('notice', $e->getMessage());
        }
        return $this->redirectToRoute('formulario-concurso');
    }
}