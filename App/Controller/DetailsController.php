<?php

namespace App\Controller;

use App\Service\CatalogService;

class DetailsController extends BaseController
{
    public function __construct(
        private CatalogService $catalogService
    ) {}

    public function show(): void
    {
        $this->requireAuth();

        $id = (int) $this->input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        $item = $this->catalogService
            ->getSingleItem($id);

        $this->render(
            'details',
            [
                'item' => $item,

                'pageTitle' => $item['title'],

                'section' => $item['category']
            ]
        );
    }

    private function redirectCatalog(): void
    {
        $this->redirect(
            '?page=catalog'
        );
    }
}