<?php

namespace App\Service;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class Paginator
{
private int $limit = 12;
    public function __construct(
        private PaginatorInterface $paginator,
    ) {

    }

    /**
 * @param mixed $query la requête ou les données à paginer.
 * @param Request $request la requête HTTP (pour récupérer le numéro de page).
 * @param int|null $limit nombre d’éléments par page (optionnel, configuré par défaut via service.yaml et variable d'environnement ).
 *
 * @return \Knp\Component\Pager\Pagination\PaginationInterface Résultat paginé.
 */
    public function paginate($query, Request $request, ?int $limit = null)
    {
        $page = $request->query->getInt('page', 1);
        if ($limit === null) {
            $limit = $this->limit;
        };

        return $this->paginator->paginate($query, $page, $limit);
    }
}
