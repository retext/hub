<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appTestUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appTestUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);

        if (0 === strpos($pathinfo, '/assetic/angular_')) {
            if (0 === strpos($pathinfo, '/assetic/angular_js')) {
                // _assetic_angular_js
                if ($pathinfo === '/assetic/angular_js.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_angular_js',);
                }

                if (0 === strpos($pathinfo, '/assetic/angular_js_')) {
                    // _assetic_angular_js_0
                    if ($pathinfo === '/assetic/angular_js_angular_1.js') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_angular_js_0',);
                    }

                    if (0 === strpos($pathinfo, '/assetic/angular_js_r')) {
                        if (0 === strpos($pathinfo, '/assetic/angular_js_resource')) {
                            // _assetic_angular_js_resource
                            if ($pathinfo === '/assetic/angular_js_resource.js') {
                                return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js_resource',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_angular_js_resource',);
                            }

                            // _assetic_angular_js_resource_0
                            if ($pathinfo === '/assetic/angular_js_resource_angular-resource_1.js') {
                                return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js_resource',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_angular_js_resource_0',);
                            }

                        }

                        if (0 === strpos($pathinfo, '/assetic/angular_js_route')) {
                            // _assetic_angular_js_route
                            if ($pathinfo === '/assetic/angular_js_route.js') {
                                return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js_route',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_angular_js_route',);
                            }

                            // _assetic_angular_js_route_0
                            if ($pathinfo === '/assetic/angular_js_route_angular-route_1.js') {
                                return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js_route',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_angular_js_route_0',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/assetic/angular_js_cookies')) {
                        // _assetic_angular_js_cookies
                        if ($pathinfo === '/assetic/angular_js_cookies.js') {
                            return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js_cookies',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_angular_js_cookies',);
                        }

                        // _assetic_angular_js_cookies_0
                        if ($pathinfo === '/assetic/angular_js_cookies_angular-cookies_1.js') {
                            return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_js_cookies',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_angular_js_cookies_0',);
                        }

                    }

                }

            }

            if (0 === strpos($pathinfo, '/assetic/angular_ui_')) {
                if (0 === strpos($pathinfo, '/assetic/angular_ui_router')) {
                    // _assetic_angular_ui_router
                    if ($pathinfo === '/assetic/angular_ui_router.js') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_ui_router',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_angular_ui_router',);
                    }

                    // _assetic_angular_ui_router_0
                    if ($pathinfo === '/assetic/angular_ui_router_angular-ui-router_1.js') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_ui_router',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_angular_ui_router_0',);
                    }

                }

                if (0 === strpos($pathinfo, '/assetic/angular_ui_bootstrap')) {
                    // _assetic_angular_ui_bootstrap
                    if ($pathinfo === '/assetic/angular_ui_bootstrap.js') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_ui_bootstrap',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_angular_ui_bootstrap',);
                    }

                    if (0 === strpos($pathinfo, '/assetic/angular_ui_bootstrap_')) {
                        // _assetic_angular_ui_bootstrap_0
                        if ($pathinfo === '/assetic/angular_ui_bootstrap_jquery_1.js') {
                            return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_ui_bootstrap',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_angular_ui_bootstrap_0',);
                        }

                        // _assetic_angular_ui_bootstrap_1
                        if ($pathinfo === '/assetic/angular_ui_bootstrap_ui-bootstrap_2.js') {
                            return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_ui_bootstrap',  'pos' => 1,  '_format' => 'js',  '_route' => '_assetic_angular_ui_bootstrap_1',);
                        }

                        if (0 === strpos($pathinfo, '/assetic/angular_ui_bootstrap_tpls')) {
                            // _assetic_angular_ui_bootstrap_tpls
                            if ($pathinfo === '/assetic/angular_ui_bootstrap_tpls.js') {
                                return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_ui_bootstrap_tpls',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_angular_ui_bootstrap_tpls',);
                            }

                            if (0 === strpos($pathinfo, '/assetic/angular_ui_bootstrap_tpls_')) {
                                // _assetic_angular_ui_bootstrap_tpls_0
                                if ($pathinfo === '/assetic/angular_ui_bootstrap_tpls_jquery_1.js') {
                                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_ui_bootstrap_tpls',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_angular_ui_bootstrap_tpls_0',);
                                }

                                // _assetic_angular_ui_bootstrap_tpls_1
                                if ($pathinfo === '/assetic/angular_ui_bootstrap_tpls_ui-bootstrap-tpls_2.js') {
                                    return array (  '_controller' => 'assetic.controller:render',  'name' => 'angular_ui_bootstrap_tpls',  'pos' => 1,  '_format' => 'js',  '_route' => '_assetic_angular_ui_bootstrap_tpls_1',);
                                }

                            }

                        }

                    }

                }

            }

        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        // hub_api_login
        if ($pathinfo === '/api/auth/login') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_hub_api_login;
            }

            return array (  '_controller' => 'hub.api.controller.login:loginAction',  '_format' => 'json',  '_route' => 'hub_api_login',);
        }
        not_hub_api_login:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
