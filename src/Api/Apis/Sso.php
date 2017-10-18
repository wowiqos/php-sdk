<?php

/**
 * @package      Oneall Single Sign-On
 * @copyright    Copyright 2017-Present http://www.oneall.com
 * @license      GNU/GPL 2 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,USA.
 *
 * The "GNU General Public License" (GPL) is available at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Oneall\Api\Apis;

use Oneall\Api\AbstractApi;

/**
 * Class Sso
 *
 * @package Oneall\Api\Apis
 */
class Sso extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sso';
    }

    /**
     * List All Active SSO Sessions
     *
     * @param array $options
     *
     * @see http://docs.oneall.com/api/resources/sso/list-all-sessions/
     *
     * @return \Oneall\Client\Response
     */
    public function getAll(array $options = [])
    {
        return $this->getClient()->get('/sso/sessions.json', $options);
    }

    /**
     * Read SSO Session
     *
     * @param string $sessionToken
     * @param array  $options
     *
     * @see http://docs.oneall.com/api/resources/sso/read-session-details/
     *
     * @return \Oneall\Client\Response
     */
    public function get($sessionToken, array $options = [])
    {
        return $this->getClient()->get('/sso/sessions/' . $sessionToken . '.json', $options);
    }

    /**
     * Read SSO Session
     *
     * @param string $sessionToken
     * @param array  $options
     *
     * @see http://docs.oneall.com/api/resources/sso/read-session-details/
     *
     * @return \Oneall\Client\Response
     */
    public function delete($sessionToken, array $options = [])
    {
        return $this->getClient()->delete('/sso/sessions/' . $sessionToken . '.json?confirm_deletion=true', $options);
    }

    /**
     * Start SSO Identity Session
     *
     * @see http://docs.oneall.com/api/resources/sso/identity/start-session/
     *
     * @param string      $identityToken
     * @param string|null $topRealm
     * @param string|null $subRealm
     * @param string|null $lifetime
     * @param array       $options
     *
     * @return \Oneall\Client\Response
     */
    public function startIdentitySession(
        $identityToken,
        $topRealm = null,
        $subRealm = null,
        $lifetime = null,
        array $options = []
    ) {
        $data = ['request' => ['sso_session' => []]];

        $data = $this->addInfo($data, '/request/sso_session/top_realm', $topRealm);
        $data = $this->addInfo($data, '/request/sso_session/sub_realm', $subRealm);
        $data = $this->addInfo($data, '/request/sso_session/lifetime', $lifetime);

        return $this->getClient()->put('/sso/sessions/identities/' . $identityToken . '.json', $data, $options);
    }

    /**
     * Read SSO Identity Session
     *
     * @param string $identityToken
     * @param array  $options
     *
     * @see http://docs.oneall.com/api/resources/sso/identity/read-session/
     *
     * @return \Oneall\Client\Response
     */
    public function readIdentitySession($identityToken, array $options = [])
    {
        return $this->getClient()->get('/sso/sessions/identities/' . $identityToken . '.json', $options);
    }

    /**
     * Destroy SSO Identity Session
     *
     * @param string $identityToken
     * @param array  $options
     *
     * @see http://docs.oneall.com/api/resources/sso/identity/read-session/
     *
     * @return \Oneall\Client\Response
     */
    public function destroyIdentitySession($identityToken, array $options = [])
    {
        $url      = '/sso/sessions/identities/' . $identityToken . '.json?confirm_deletion=true';
        $response = $this->getClient()->delete($url, $options);

        return $response;
    }
}