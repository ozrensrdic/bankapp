<?php
declare(strict_types=1);

namespace App\Application\Actions\Transaction;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Exception;

class SendAmountController extends Controller
{
    /**
     * @var array
     */
    private array $sender;

    /**
     * @var array
     */
    private array $receiver;

    /**
     * @var float
     */
    private float $amount;

    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $parsedBody = $this->request->getParsedBody();

        $this->amount = (float) $parsedBody['amount'];
        $senderId = (int) $this->resolveArg('senderId');
        $receiverId = (int) $this->resolveArg('receiverId');

        $this->sender = $this->customerRepository->findById($senderId);
        $this->receiver = $this->customerRepository->findById($receiverId);

        $this->validate();

        $this->pdo->beginTransaction();
        try {

            $send = $this->pdo->prepare(
                "UPDATE customers SET `balance` = `balance` - :amount WHERE id = :senderId"
            );
            $send->execute([':amount' => $this->amount, ':senderId' => $this->sender['id']]);

            $transaction = $this->pdo->prepare(
                "INSERT INTO transactions (`sender_customer_id`, `sender_branch_id`, `receiver_customer_id`, `receiver_branch_id`, `balance_sent`) " .
                "VALUES (:senderId, :senderBranch, :receiverId, :receiverBranch, :balance)"
            );

            $transaction->execute([
                ':senderId' => $this->sender['id'],
                ':senderBranch' => $this->sender['branch_id'],
                ':receiverId' => $this->receiver['id'],
                ':receiverBranch' => $this->receiver['branch_id'],
                ':balance' => $this->amount,
            ]);

            $receive = $this->pdo->prepare(
                "UPDATE customers SET `balance` = `balance` + :amount WHERE id = :receiverId"
            );
            $receive->execute([':amount' => $this->amount, ':receiverId' => $this->receiver['id']]);

            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollBack();
            $this->logger->error($exception);

            throw new Exception($exception->getMessage());
        }

        return $this->response('Transaction completed');
    }

    protected function validate()
    {
        if (!isset($this->sender['branch_id'])) {
            throw new Exception('Sender does not have selected branch');
        }

        if (!isset($this->receiver['branch_id'])) {
            throw new Exception('Receiver does not have selected branch');
        }

        if (!($this->amount > 0)) {
            throw new Exception('Insufficient amount');
        }

        if ($this->sender['balance'] < $this->amount) {
            throw new Exception('Not enough balance for transaction');
        }
    }
}
