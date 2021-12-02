<?php
namespace App\Infrastructures\Auth\OAuthAccessToken;

use App\Infrastructures\Auth\OAuthAccessToken\Contracts\EloquentOAuthAccessTokenRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentOAuthAccessTokenRepository Class.
 */
class EloquentOAuthAccessTokenRepository extends EloquentRepositoryAbstract implements EloquentOAuthAccessTokenRepositoryInterface
{

}
