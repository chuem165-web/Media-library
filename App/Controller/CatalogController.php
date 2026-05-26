<?php

namespace App\Controller;

use App\Service\CatalogService;

class CatalogController extends BaseController
{
    private CatalogService $catalogService;

    public function __construct(
        CatalogService $catalogService
    ) {
        $this->catalogService = $catalogService;
    }

    public function home(): void
    {
        $data = [
            'pageTitle' => 'Personal Media Library',
            'section' => 'catalog',
            'random' => $this->catalogService
                ->random_catalog_array()
        ];

        $this->render(
            'home',
            $data
        );
    }

    public function index(): void
    {
        $data = $this->catalogService
            ->getCatalogPage($_GET);

        $this->render(
            'catalog',
            $data
        );


    }
}