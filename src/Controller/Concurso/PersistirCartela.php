<?php

namespace App\Controller\Concurso;

use App\Entity\Cartela\Cartela;
use App\Entity\Cartela\Jogador\Email\Email;
use App\Entity\Cartela\Jogador\Jogador;
use App\Entity\Cartela\Jogador\Telefone\Telefone;
use App\Entity\Concurso\Estado\Aberto;
use App\Repository\ConcursoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersistirCartela extends AbstractController
{
    private ConcursoRepository $concursoRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ConcursoRepository $concursoRepository, EntityManagerInterface $entityManager)
    {
        $this->concursoRepository = $concursoRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(int $id, Request $request): Response
    {
        /**
         * @var array $dezenas
         */
        $dezenas = $request->request->get('cb');
        $nomeJogador = $request->request->get('nome');
        $telefone = $request->request->get('telefone');
        $email = $request->request->get('email');

        try {
            $cartela = new Cartela(
                $dezenas,
                new Jogador(
                    $nomeJogador,
                    new Telefone($telefone),
                    new Email($email)
                )
            );
            $concurso = $this->concursoRepository->find($id);
            $concurso->addCartela($cartela);
            $cartela->pagar();
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $this->addFlash('notice', $exception->getMessage());
        }
        return $this->redirectToRoute('home');
    }
}