<?php

namespace App\Controller\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Cartela\Jogador\Email\Email;
use App\Entity\Cartela\Jogador\Jogador;
use App\Entity\Cartela\Jogador\Telefone\Telefone;
use App\Repository\SorteioOficialRepositoryAPILoterias;
use App\Service\Concurso\ConcursoDto;
use App\Repository\ConcursoRepository;
use App\Service\Concurso\ConcursoFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $concursoDto = new ConcursoDto(
            $request->request->get('descricao'),
            $request->request->get('dataInicio'),
            $request->request->get('quantidadeDezenasPorCartela')
        );

        try {
            $concurso = $this->concursoFactory->criarConcurso($concursoDto);
            $this->entityManager->persist($concurso);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash('notice', $exception->getMessage());
            return $this->redirectToRoute('formulario-concurso');
        }

        $this->addFlash('notice', 'Parabéns! Concurso Criado Com Sucesso!');
        return $this->redirectToRoute('home');
    }

    public function homeConcursos(Request $request): Response
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
        $sorteiosOficiais = $concurso->sorteiosOficiais();

        $dezenasSorteadas = [];
        foreach ($sorteiosOficiais as $sorteioOficial){
            foreach ($sorteioOficial->dezenas() as $dezena ) {
                $dezenasSorteadas[] = $dezena;
            }
        }

        return $this
            ->render(
                '/concursos/concurso-por-id.html.twig', [
                    'concurso' => $concurso,
                    'cartelas' => $cartelas,
                    'sorteiosOficiais' => $sorteiosOficiais,
                    'dezenasSorteadas' => $dezenasSorteadas,
                ]
            );
    }

    public function teste(): Response
    {
        $concurso = $this->concursoRepository->findOneBy([
            'id' => 20
        ]);

        $cartela = new Cartela(
            [1,2,32,54,50,65,7,8,9,10],
            new Jogador(
                'Renato',
                new Telefone('21967218047'),
                new Email('renato@gmail.com')
            )
        );

        //$concurso->inicia();

        //$concurso->addCartela($cartela);


        $sorteioOficial = new SorteioOficialRepositoryAPILoterias();
        $quina = $sorteioOficial->buscarResultadoOficialQuina();
        $concurso->addSorteioOficial($quina);


        $this->entityManager->persist($concurso);
        $this->entityManager->flush();
    }
}