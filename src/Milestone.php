<?php

namespace Encore\Milestone;

use Encore\Admin\Extension;
use Encore\Milestone\Service\MilestoneManageTrait;

class Milestone extends Extension
{
    use MilestoneManageTrait;

    public $name = 'milestone';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $migrations = __DIR__.'/../database/migrations';

    public $menu = [
        'title' => '大事记',
        'path'  => 'milestone',
        'icon'  => 'fa-gears',
    ];
}