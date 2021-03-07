<?php
declare(strict_types=1);

namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use FaaPz\PDO\Database as Pdo;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Exception;

abstract class Controller
{
    /**
     * @var string
     */
    protected string $controllerId = __CLASS__;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var array
     */
    protected array $args;

    /**
     * Controller constructor.
     * @param LoggerInterface $logger
     * @param Pdo $pdo
     */
    public function __construct(
        protected LoggerInterface $logger,
        protected Pdo $pdo
    ){}

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws HttpNotFoundException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->process();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @return Response
     */
    public function process(): Response
    {
        try {
            $this->run();
        } catch (Exception $e) {
            $this->logger->error($e);
            $payload = ['controllerId' => $this->controllerId, 'error' => $e->getMessage()];
            $this->response($payload);
        }

        return $this->response;
    }

    /**
     * @throws Exception
     */
    abstract protected function run();

    /**
     * @param array|string $payload
     * @param int $statusCode
     * @return Response
     */
    protected function response(array|string $payload = '',int $statusCode = 200): Response
    {
        if (is_array($payload)) {
            $payload = json_encode($payload);
        }

        $this->response->getBody()->write($payload);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }

    /**
     * @param  string $name
     * @return mixed
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name): mixed
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }
}
