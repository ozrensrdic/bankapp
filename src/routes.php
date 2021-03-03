<?php

use glimpse\common\controller\HealthController;

// Routes

$app->get('/health', HealthController::class);
