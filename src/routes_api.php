<?php

return [
    '~api/articles/(\d+)$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'view'],
    '~api/articles/add$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'add'],
];