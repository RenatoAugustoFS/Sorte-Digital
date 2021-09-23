<?php

namespace App\Controller\Admin;

use App\Entity\Concurso\SorteioOficial\SorteioOficialRepository;
use App\Repository\ConcursoRepository;
use App\Repository\SorteioOficialRepositoryAPILoterias;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersistirSorteioOficial extends AbstractController
{
    private ConcursoRepository $concursoRepository;
    private SorteioOficialRepository $sorteioOficialRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ConcursoRepository $concursoRepository,
        SorteioOficialRepositoryAPILoterias $sorteioOficialRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->concursoRepository = $concursoRepository;
        $this->sorteioOficialRepository = $sorteioOficialRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(Request $request): Response
    {
        $this->entityManager->beginTransaction();

        $concursosEmAndamento = $this->concursoRepository->findConcursosEmAndamento();
        $sorteioOficial = $this->sorteioOficialRepository->buscarResultadoOficialQuina();

        foreach ($concursosEmAndamento as $concurso){
            $concurso->addSorteioOficial($sorteioOficial);
            $this->entityManager->persist($concurso);
        }

        $this->entityManager->flush();
        $this->entityManager->commit();
        return new Response('', Response::HTTP_OK);
    }
}