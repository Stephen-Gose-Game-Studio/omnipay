<?php

/*
 * This file is part of the Omnipay package.
 *
 * (c) Adrian Macneil <adrian@adrianmacneil.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omnipay\CardSave\Message;

use SimpleXMLElement;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * CardSave Complete Purchase Request
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $md = $this->htttpRequest->request->get('MD');
        $paRes = $this->htttpRequest->request->get('PaRes');
        if (empty($md) || empty($paRes)) {
            throw new InvalidResponseException;
        }

        $data = new SimpleXMLElement('<ThreeDSecureAuthentication/>');
        $data->addAttribute('xmlns', $this->namespace);
        $data->ThreeDSecureMessage->MerchantAuthentication['MerchantID'] = $this->getMerchantId();
        $data->ThreeDSecureMessage->MerchantAuthentication['Password'] = $this->getPassword();
        $data->ThreeDSecureMessage->ThreeDSecureInputData['CrossReference'] = $md;
        $data->ThreeDSecureMessage->ThreeDSecureInputData->PaRES = $paRes;

        return $data;
    }
}