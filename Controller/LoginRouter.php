<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Controller;

use BitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\Router\Base;

/**
 * Class LoginRouter
 *
 * @package BitExpert\ForceCustomerLogin\Controller
 */
class LoginRouter extends Base
{
    /**
     * @var LoginCheck
     */
    private $loginCheck;

    /**
     * LoginRouter constructor.
     *
     * @param \Magento\Framework\App\Router\ActionList $actionList
     * @param ActionFactory $actionFactory
     * @param \Magento\Framework\App\DefaultPathInterface $defaultPath
     * @param \Magento\Framework\App\ResponseFactory $responseFactory
     * @param \Magento\Framework\App\Route\ConfigInterface $routeConfig
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Framework\Code\NameBuilder $nameBuilder
     * @param \Magento\Framework\App\Router\PathConfigInterface $pathConfig
     * @param LoginCheckInterface $loginCheck
     * @throws \InvalidArgumentException
     */
    public function __construct(
        \Magento\Framework\App\Router\ActionList $actionList,
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\DefaultPathInterface $defaultPath,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\App\Route\ConfigInterface $routeConfig,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\Code\NameBuilder $nameBuilder,
        \Magento\Framework\App\Router\PathConfigInterface $pathConfig,
        LoginCheckInterface $loginCheck
    ) {
        parent::__construct(
            $actionList,
            $actionFactory,
            $defaultPath,
            $responseFactory,
            $routeConfig,
            $url,
            $nameBuilder,
            $pathConfig
        );

        $this->loginCheck = $loginCheck;
    }

    /**
     * {@inheritdoc}
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        if ($this->loginCheck->execute()) {
            $request->setDispatched(true);
            return $this->actionFactory->create(\Magento\Framework\App\Action\Redirect::class);
        }
    }
}
