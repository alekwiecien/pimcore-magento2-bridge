<?php
/**
 * @category    pimcore5-module-magento2-integration
 * @date        22/06/2018
 * @author      Michał Bolka <mbolka@divante.co>
 * @copyright   Copyright (c) 2018 DIVANTE (https://divante.co)
 */

namespace Divante\MagentoIntegrationBundle\Controller\Rest;

use Divante\MagentoIntegrationBundle\Model\Request\UpdateStatus;
use Divante\MagentoIntegrationBundle\Service\Asset\AssetStatusService;
use Pimcore\Bundle\AdminBundle\Controller\Rest\Element\AbstractElementController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class AssetController
 * @package Divante\MagentoIntegrationBundle\Controller\Rest
 */
class AssetController extends AbstractElementController
{
    /** @var AssetStatusService */
    private $assetStatusService;

    /**
    * @Method("POST")
    * @Route("/asset/update-status")
    *
    * @api {post} /asset/update-status Save information about synchronization status
    * @apiName Save asset status
    * @apiGroup Object
    * @apiSampleRequest off
    * @apiParam {int} id of elemenet
    * @apiParam {string} status ['synchronized','error']
    * @apiParam {instanceUrl} url to your instance
    * @apiParam {string} apikey your access token
    * @apiParam {storeViewId} id to your store view
    *
    * @apiParamExample {json} Request-Example:
    *     {
    *         "id": 1,
    *         "status"  : "SUCCESS",
    *         "message" : "",
    *         "instanceUrl":"http://magento.ecommerce",
    *         "storeViewId": "1"
    *         "apikey": "21314njdsfn1342134"
    *      }
    * @apiSuccess {json} success parameter of the returned data = true
    * @apiError {json} success parameter of the returned data = false
    * @apiErrorExample {json} Error-Response:
    *                  {"success":false, "msg":"exception 'Exception' with message '....'"}
    * @apiSuccessExample {json} Success-Response:
    *                    HTTP/1.1 200 OK
    *                    {
    *                      "success": true
    *                    }
    *
    * @param UpdateStatus $request
    *
    * @return JsonResponse
    */
    public function updateStatusAction(UpdateStatus $request): JsonResponse
    {
        return $this->adminJson($this->getAssetStatusService()->handleRequest($request));
    }

    /**
     * @return AssetStatusService
     */
    protected function getAssetStatusService(): AssetStatusService
    {
        if (!$this->assetStatusService instanceof AssetStatusService) {
            $this->assetStatusService = $this->get(AssetStatusService::class);
        }
        return $this->assetStatusService;
    }
}
