<?php

namespace App\Controller;

use App\Service\FindologicApiService;
use FINDOLOGIC\Api\Client;
use FINDOLOGIC\Api\Definitions\OutputAdapter;
use FINDOLOGIC\Api\Requests\SearchNavigation\SearchRequest;
use FINDOLOGIC\Api\Responses\Json10\Json10Response;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FindologicApiController extends AbstractController
{
    /** @var Client */
    private $client;

    public function __construct(FindologicApiService $findologicApiService)
    {
        if (!$this->isServiceIdIsSet()) {
            throw new InvalidArgumentException(
                'Enter your ServiceId / Shopkey to "FINDOLOGIC_SERVICE_ID" in the ".env" file.'
            );
        }

        $this->client = $findologicApiService->getClient();
    }

    /**
     * @Route("/search", name="findologic_api")
     */
    public function index(Request $request)
    {
        $searchRequest = new SearchRequest();
        $searchRequest
            ->setQuery($request->get('query'))
            ->setShopUrl('your-shopdomain.com')
            ->setUserIp($request->getClientIp())
            ->setRevision('1.0.0') // Version of your API wrapper.
            ->setOutputAdapter(OutputAdapter::JSON_10);

        $searchRequest->addOutputAttrib('Farbe');
        $this->handleSelectedFilters($request, $searchRequest);

        // Only set the referer if there really is one.
        if ($referer = $request->headers->get('referer')) {
            $searchRequest->setReferer($referer);
        }

        /** @var Json10Response $response */
        $response = $this->client->send($searchRequest);

        return $this->render('findologic_api/index.html.twig', [
            'response' => $response,
            'controller_name' => 'FindologicApiController',
        ]);
    }

    private function handleSelectedFilters(Request $request, SearchRequest $searchRequest): void
    {
        if (!($selectedFilters = $this->getSelectedFilters($request))) {
            return;
        }

        foreach ($selectedFilters as $name => $item) {
            $searchRequest->addAttribute($name, $item);
        }
    }

    private function isServiceIdIsSet(): bool
    {
        return !!$_ENV['FINDOLOGIC_SERVICE_ID'];
    }

    private function getSelectedFilters(Request $request): ?array
    {
        return $request->get('attrib');
    }
}
