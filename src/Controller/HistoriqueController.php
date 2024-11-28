<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Repository\HistoriqueRepository;
use App\Service\HistoriqueService;// Import NavbarExtension service
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Referentiel\TypeElement;
use App\Service\_navbarExtension;

#[Route('/historique')]
final class HistoriqueController extends AbstractController
{
    public function __construct(
        private HistoriqueService $historiqueService,
        private HistoriqueRepository $historiqueRepository,
        private _navbarExtension $navbarExtension // Add NavbarExtension service
    ) {}

    #[Route(name: 'app_historique_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $type = $request->query->get('type');
        $dateDebut = $request->query->get('dateDebut');
        $dateFin = $request->query->get('dateFin');
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        $criteria = [];
        if ($type) {
            $criteria['typeElement'] = $type;
        }
        if ($dateDebut) {
            $criteria['dateHistorique']['$gte'] = new \DateTime($dateDebut);
        }
        if ($dateFin) {
            $criteria['dateHistorique']['$lte'] = new \DateTime($dateFin);
        }

        $offset = ($page - 1) * $limit;
        $historique = $this->historiqueService->searchHistorique($criteria, ['dateHistorique' => 'DESC'], $limit, $offset);
        $total = $this->historiqueRepository->count($criteria);

        $navbarData = $this->navbarExtension->generateNavbarData(
            'Historique',
            [
                ['name' => 'Accueil', 'route' => 'app_acceuil'],
                ['name' => 'Historique', 'route' => 'app_historique_index']
            ]
        );

        return $this->render('historique/index.html.twig', [
            'historique' => $historique,
            'types' => TypeElement::cases(),
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/{id}', name: 'app_historique_show', methods: ['GET'])]
    public function show(Historique $historique): Response
    {
        $navbarData = $this->navbarExtension->generateNavbarData(
            'Détail Historique',
            [
                
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Historique', 'route' => 'app_historique_index'],
                ['name' => 'Détail Historique', 'route' => null],
            ]
        );

        return $this->render('historique/show.html.twig', [
            'historique' => $historique,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/element/{typeElement}/{idElement}', name: 'app_historique_element', methods: ['GET'])]
    public function viewElementHistorique(string $typeElement, int $idElement, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $offset = ($page - 1) * $limit;

        $historique = $this->historiqueService->getHistorique($typeElement, $idElement, $limit, $offset);
        $total = $this->historiqueRepository->count(['typeElement' => $typeElement, 'idElement' => $idElement]);

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Historique $typeElement - $idElement",
            [
                
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Historique', 'route' => 'app_historique_index'],
                ['name' => "Élément: $idElement", 'route' => null],
            ]
        );

        return $this->render('historique/element.html.twig', [
            'historique' => $historique,
            'typeElement' => $typeElement,
            'idElement' => $idElement,
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'navbarData' => $navbarData,
        ]);
    }

    #[Route('/type/{typeElement}', name: 'app_historique_type', methods: ['GET'])]
    public function viewTypeHistorique(string $typeElement, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $offset = ($page - 1) * $limit;

        $criteria = ['typeElement' => $typeElement];
        $orderBy = ['dateHistorique' => 'DESC'];

        $historique = $this->historiqueService->searchHistorique($criteria, $orderBy, $limit, $offset);
        $total = $this->historiqueRepository->count($criteria);

        $navbarData = $this->navbarExtension->generateNavbarData(
            "Historique par Type: $typeElement",
            [
                
                ['name' => 'Accueil', 'route' => 'app_acceuil'],['name' => 'Historique', 'route' => 'app_historique_index'],
                ['name' => "Type: $typeElement", 'route' => null],
            ]
        );

        return $this->render('historique/type.html.twig', [
            'historique' => $historique,
            'typeElement' => $typeElement,
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'navbarData' => $navbarData,
        ]);
    }
}
