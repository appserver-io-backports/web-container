<?php

/**
 * TechDivision\WebContainer\ServletLocator
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Appserver
 * @package   TechDivision_WebContainer
 * @author    Markus Stockbauer <ms@techdivision.com>
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.appserver.io
 */

namespace TechDivision\WebContainer;

use TechDivision\Servlet\ServletContext;
use TechDivision\Servlet\ServletRequest;
use TechDivision\Servlet\ServletResponse;

/**
 * The servlet resource locator implementation.
 *
 * @category  Appserver
 * @package   TechDivision_WebContainer
 * @author    Markus Stockbauer <ms@techdivision.com>
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.appserver.io
 */
class ServletLocator implements ResourceLocator
{

    /**
     * Tries to locate the resource related with the request.
     *
     * @param \TechDivision\Servlet\ServletContext $servletContext The servlet context that handles the servlets
     * @param \TechDivision\Servlet\ServletRequest $servletRequest The request instance to return the servlet for
     *
     * @return \TechDivision\Servlet\Servlet The requested servlet
     * @see \TechDivision\WebContainer\ResourceLocator::locate()
     * @throws \TechDivision\WebContainer\ServletNotFoundException Is thrown if no servlet can be found for the passed request
     */
    public function locate(ServletContext $servletContext, ServletRequest $servletRequest)
    {
        
        // load the path to the (almost virtual servlet)
        $servletPath = $servletRequest->getServletPath();
        
        // iterate over all servlets and return the matching one
        foreach ($servletContext->getServletMappings() as $urlPattern => $servletName) {
            if (fnmatch($urlPattern, $servletPath)) {
                return $servletContext->getServlet($servletName);
            }
        }
        
        // throw an exception if no servlet matches the servlet path
        throw new ServletNotFoundException(
            sprintf("Can't find servlet for requested path %s", $servletPath)
        );
    }
}
