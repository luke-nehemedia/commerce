<?php

namespace craft\commerce\gateways;

use craft\base\MissingComponentInterface;
use craft\base\MissingComponentTrait;
use craft\commerce\base\Gateway;
use craft\commerce\base\RequestResponseInterface;
use craft\commerce\models\payments\BasePaymentForm;
use craft\commerce\models\Transaction;
use craft\web\Response as WebResponse;
use yii\base\NotSupportedException;

/**
 * MissingGateway represents a gateway with an invalid class.
 *
 * @property null $paymentFormModel
 * @property null $gatewayClassName
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  2.0
 */
class MissingGateway extends Gateway implements MissingComponentInterface
{
    // Traits
    // =========================================================================

    use MissingComponentTrait;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getPaymentFormHtml(array $params)
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function getPaymentFormModel()
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function authorize(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function capture(Transaction $transaction, string $reference): RequestResponseInterface
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function completeAuthorize(Transaction $transaction): RequestResponseInterface
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function completePurchase(Transaction $transaction): RequestResponseInterface
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function purchase(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function processWebHook(): WebResponse
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function refund(Transaction $transaction, string $reference): RequestResponseInterface
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function supportsAuthorize(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function supportsCapture(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function supportsCompleteAuthorize(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function supportsCompletePurchase(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function supportsPurchase(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function supportsRefund(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function supportsWebhooks(): bool
    {
        return false;
    }
}