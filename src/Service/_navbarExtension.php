<?php

namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class _navbarExtension
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Génère les données pour le titre et les breadcrumbs.
     *
     * @param string $title Le titre de la page.
     * @param array $breadcrumbItems Liste des éléments du breadcrumb (nom et route).
     * @return array Données comprenant le titre et les breadcrumbs.
     */
    public function generateNavbarData(string $title, array $breadcrumbItems): array
    {
        $breadcrumbs = [];

        foreach ($breadcrumbItems as $item) {
            $breadcrumbs[] = [
                'name' => $item['name'],
                'url' => $item['route'] ? $this->urlGenerator->generate($item['route']) : null,
            ];
        }

        return [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
        ];
    }
}
