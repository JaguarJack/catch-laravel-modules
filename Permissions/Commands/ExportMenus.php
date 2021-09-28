<?php
// +----------------------------------------------------------------------
// | CatchAdmin [Just Like ～ ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017~2021 https://catchadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://github.com/JaguarJack/catchadmin-laravel/blob/master/LICENSE.md )
// +----------------------------------------------------------------------
// | Author: JaguarJack [ njphper@gmail.com ]
// +----------------------------------------------------------------------

declare(strict_types=1);

namespace CatchAdmin\Permissions\Commands;

use CatchAdmin\Permissions\Models\Permissions;
use Catcher\CatchAdmin;
use Catcher\Support\Tree;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use JaguarJack\Generate\Build\Class_;
use JaguarJack\Generate\Build\ClassMethod;
use JaguarJack\Generate\Build\FunctionCall;
use JaguarJack\Generate\Define;
use JaguarJack\Generate\Generator;
use JaguarJack\Generate\Types\Array_;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;

class ExportMenus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catch:export:menus {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'catch export menus';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $module = $this->argument('module');

        $menus = Tree::done(
            Permissions::query()->where('module', strtolower($module))
                ->get()
                ->toArray()
        );

        $seederName = ucfirst($module) . 'MenuSeeder';

        $seeder = CatchAdmin::makeDir(CatchAdmin::getModuleSeederPath($module)) . $seederName . '.php';

        File::put($seeder, $this->seederContent($seederName, $menus));

        $this->info("Export Module [{$module}] Menus Successful");
    }


    /**
     * seeder content
     *
     * @param $name
     * @param $data
     * @return string
     * @throws \Exception
     * @author CatchAdmin
     * @time 2021年08月01日
     */
    protected function seederContent($name, $data): string
    {
        $generator = new Generator();

        return '<?php' . PHP_EOL . PHP_EOL . $generator->getContent([
                new Use_([
                    new UseUse(new Name('Illuminate\Database\Seeder')),
                ]),
                new Use_([
                    new UseUse(new Name('CatchAdmin\Permissions\Models\Permissions'))
                ]),

                (new Class_($name))->extend('Seeder')
                    ->setDocComment(PHP_EOL)
                    ->useMethod(
                        (new ClassMethod('run'))
                            ->makePublic()
                            ->body([
                                Define::variable('permissionsModel',
                                    FunctionCall::name('app')->args(
                                        Define::classConstFetch('Permissions')
                                    )
                                ),

                                $generator->methodCall(['permissionsModel', 'import'], [
                                    $generator->methodCall('data')
                                ])
                            ])
                    )
                    ->useMethod(
                        (new ClassMethod('data'))
                            ->makePublic()
                            ->body([
                                new Array_($data)
                            ])
                            ->return('array')
                    )
                    ->fetch()
            ]);
    }
}
