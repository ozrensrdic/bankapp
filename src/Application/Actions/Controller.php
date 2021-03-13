<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Domain\Entity;
use App\Domain\Hydrator\Hydrator;
use App\Domain\Repository\CustomerRepository;
use App\Domain\Repository\BranchRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use FaaPz\PDO\Database as Pdo;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * @var null|Entity
     */
    protected ?Entity $model;

    /**
     * @var ?string
     */
    protected string $modelClass = '';

    /**
     * Controller constructor.
     * @param LoggerInterface $logger
     * @param Pdo $pdo
     * @param CustomerRepository $customerRepository,
     * @param BranchRepository $branchRepository,
     * @param ValidatorInterface $validation
     * @param Hydrator $hydrator
     */
    public function __construct(
        protected LoggerInterface $logger,
        protected Pdo $pdo,
        protected CustomerRepository $customerRepository,
        protected BranchRepository $branchRepository,
        protected ValidatorInterface $validation,
        protected Hydrator $hydrator
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
            $this->initializeModel();

            $this->validateInput();
            return $this->process();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    protected function initializeModel()
    {
        $this->model = null;
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
     * @throws Exception
     */
    protected function validateInput()
    {
        if (empty($this->model)) {
            return;
        }

        $errors = $this->validation->validate($this->model);
        if (count($errors)) {
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                throw new Exception('field ' . $error->getPropertyPath() .' :'. $error->getMessage());
            }
        }
    }

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
     * @param  mixed $defaultValue
     * @return mixed
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name, mixed $defaultValue = null): mixed
    {
        if (!isset($this->args[$name]) && (!$defaultValue)) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        if (!isset($this->args[$name]) && $defaultValue) {
            return $defaultValue;
        }

        return $this->args[$name];
    }
}
