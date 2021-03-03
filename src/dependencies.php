<?php
// DIC configuration

use glimpse\common\services\GlimpseDependencies;

$container = $app->getContainer();

GlimpseDependencies::addDefault($container);
