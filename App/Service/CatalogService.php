<?php

namespace App\Service;

use App\Contract\CatalogRepositoryInterface;
use App\Repository\CatalogRepository;

class CatalogService extends BaseService
{
    private const ITEMS_PER_PAGE = 8;

    private const ALLOWED_CATEGORIES = [
        'books',
        'movies',
        'music'
    ];

    private CatalogRepositoryInterface $repo;

    public function __construct(?CatalogRepositoryInterface $repo = null)
    {
        if ($repo === null) {
            $db = \Database::getConnection();
            $repo = new CatalogRepository($db);
        }

        $this->repo = $repo;
    }

    /* =========================================================
     * MAIN METHOD (Controller calls ONLY this)
     * ========================================================= */
    public function getCatalogPage(array $queryParams): array
    {
        $section = $this->getCategory($queryParams);
        $search = $this->getSearchTerm($queryParams);
        $currentPage = $this->getCurrentPage($queryParams);

        $totalItems = $this->get_catalog_count($section, $search);
        $totalItems = $totalItems !== null ? $totalItems : 0;

        $foundInFullCatalog = 0;
        if ($search !== null && $section !== null) {
            $foundInFullCatalog = $this->get_catalog_count(null, $search) ?? 0;
        }

        $pagination = $this->buildPagination($totalItems, $currentPage);

        $catalog = $this->loadCatalogData(
            $section,
            $search,
            $pagination['limit'],
            $pagination['offset']
        );

        return [
            'catalog' => $catalog,
            'section' => $section,
            'search' => $search,
            'currentPage' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'totalItems' => $totalItems,
            'foundInFullCatalog' => $foundInFullCatalog,
            'pageTitle' => $this->buildPageTitle($section)
        ];
    }

    /* =========================================================
     * FILTER: CATEGORY
     * ========================================================= */
    private function getCategory(array $queryParams): ?string
    {
        $category = $queryParams['cat'] ?? null;

        if (
            $category !== null &&
            in_array($category, self::ALLOWED_CATEGORIES, true)
        ) {
            return $category;
        }

        return null;
    }

    /* =========================================================
     * FILTER: SEARCH
     * ========================================================= */
    private function getSearchTerm(array $queryParams): ?string
    {
        $search = trim($queryParams['s'] ?? '');

        return $search !== '' ? $search : null;
    }

    /* =========================================================
     * PAGINATION: CURRENT PAGE
     * ========================================================= */
    private function getCurrentPage(array $queryParams): int
    {
        $page = filter_var(
            $queryParams['pg'] ?? 1,
            FILTER_VALIDATE_INT
        );

        if ($page === false || $page === null || $page < 1) {
    return 1;
}

        return $page;
    }

    /* =========================================================
     * PAGINATION LOGIC
     * ========================================================= */
    private function buildPagination(int $totalItems, int $currentPage): array
    {
        $totalPages = max(
            1,
            (int) ceil($totalItems / self::ITEMS_PER_PAGE)
        );

        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }
        $offset = ($currentPage - 1) * self::ITEMS_PER_PAGE;
        return [
            'limit' => self::ITEMS_PER_PAGE,
            'offset' => $offset,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ];
    }
 /* =========================================================
     * LOAD DATA (DECISION LOGIC MOVED HERE)
     * ========================================================= */
    private function loadCatalogData(
        ?string $section,
        ?string $search,
        int $limit,
        int $offset
    ): array {
        if ($search !== null && $section !== null) {
            return $this->search_catalog_array(
                $search,
                $section,
                $limit,
                $offset
            );
        }

        if ($search !== null) {
            return $this->search_catalog_array(
                $search,
                null,
                $limit,
                $offset
            );
        }

        if ($section !== null) {
            return $this->category_catalog_array(
                $section,
                $limit,
                $offset
            );
        }

        return $this->full_catalog_array(
            $limit,
            $offset
        );
    }

    /* =========================================================
     * PAGE TITLE
     * ========================================================= */
    private function buildPageTitle(?string $section): string
    {
        return $section ? ucfirst($section) : "Full Catalog";
    }

    /* =========================================================
     * DATABASE METHODS (repository wrappers)
     * ========================================================= */

    public function get_catalog_count($section, $search)
    {
        $filters = [
            'search' => $search,
            'category' => $section
        ];

        return (int) $this->repo->count($filters);
    }

    public function search_catalog_array($search, $section, $limit, $offset)
    {
        return $this->repo->search($search, $section, $limit, $offset);
    }

    public function category_catalog_array($section, $limit, $offset)
    {
        return $this->repo->getByCategory($section, $limit, $offset);
    }

    public function full_catalog_array($limit, $offset)
    {
        return $this->repo->getAll($limit, $offset);
    }

    public function random_catalog_array()
    {
        return $this->repo->getRandom();
    }

     /* =========================================================
     * I change
     * ========================================================= */
    public function getSingleItem(int $id): ?array
{
    return $this->repo->getById($id);
}


public function single_item_array($id)
{
    // existing DB query
}



}