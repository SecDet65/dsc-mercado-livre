<?php
/**
 * Class OrderService
 *
 * @author Diego Wagner <diegowagner4@gmail.com>
 * http://www.discoverytecnologia.com.br
 */
namespace Dsc\MercadoLivre\Resources\Order;

use Dsc\MercadoLivre\Resources\ResourceService;
use Dsc\MercadoLivre\BaseService;
use Dsc\MercadoLivre\Resources\Feedback\FeedbackPost;
use Dsc\MercadoLivre\Resources\Feedback\FeedbackResponse;

class OrderService extends BaseService implements ResourceService
{
    /**
     * @param $orderId
     * @return Order
     */
    public function findOrder($orderId)
    {
        return $this->getResponse(
            $this->get('/orders/' . $orderId),
            Order::class
        );
    }

    /**
     * @param $sellerId
     * @return OrdersList
     */
    public function findOrdersBySeller($sellerId, $limit = 50, $offset = 0, $sort = 'date_desc')
    {
        return $this->getResponse(
            $this->get('/orders/search', [
                'seller' => $sellerId,
                'limit'  => $limit,
                'offset' => $offset,
                'sort'   => $sort
            ]),
            OrdersList::class
        );
    }

    /**
     * @param $buyerId
     * @return OrdersList
     */
    public function findOrdersByBuyer($buyerId, $limit = 50, $offset = 0, $sort = 'date_desc')
    {
        return $this->getResponse(
            $this->get('/orders/search', [
                'buyer'  => $buyerId,
                'limit'  => $limit,
                'offset' => $offset,
                'sort'   => $sort
            ]),
            OrdersList::class
        );
    }

    /**
     * @param FeedbackPost $feedback
     * @param integer $orderId
     *
     * @return FeedbackResponse
     * @link https://developers.mercadolivre.com.br/pt_br/feedback-de-uma-venda
     */
    public function publishFeedback(FeedbackPost $feedback, $orderId)
    {
        return $this->getResponse(
            $this->post("orders/$orderId/feedback", $feedback),
            FeedbackResponse::class
        );
    }
}
