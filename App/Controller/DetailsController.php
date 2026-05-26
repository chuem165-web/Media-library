<?php

require_once BASE_PATH . '/Controller/BaseController.php';

class DetailsController extends BaseController
{
    private CatalogService $catalogService;

    public function __construct(
        CatalogService $catalogService
    ) {
        $this->catalogService = $catalogService;
    }

    public function show(): void
    {
        $id = $this->input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if (!$id) {
            $this->redirectCatalog();
        }

        $item = $this->catalogService
            ->getSingleItem($id);

        if (!$item) {
            $this->redirectCatalog();
        }

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
            BASE_URL
            . '/Public/index.php?page=catalog'
        );
    }
}