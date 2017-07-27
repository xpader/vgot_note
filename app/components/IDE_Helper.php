<?php
/**
 * Created by PhpStorm.
 * User: Pader
 * Date: 2017/7/28
 * Time: 0:55
 */

namespace vgot\Core;

/**
 * @property Config $config
 * @property Input $input
 * @property Output $output
 * @property Router $router
 * @property View $view
 * @property Controller $controller
 * @property \vgot\Database\QueryBuilder $db
 * @property \vgot\Cache\Cache $cache
 * @property Security $security
 *
 * @property \app\components\User $user
 */
class Base {}

/**
 * @method register(string $name, Object|array|string $object, array $args) Register object to application
 * @method Application getInstance()
 */
class Application extends Base {}
