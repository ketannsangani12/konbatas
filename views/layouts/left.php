<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel" style="display: none;">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/home-yellow.png" class="img-circle" alt="User Image"/>
            </div>
            <?php
            $userdetails = app\models\Users::find()
                ->where('id = :userid', [':userid' => Yii::$app->user->id])
                ->one();
            ?>
            <div class="pull-left info">
                <p><?php echo $userdetails->full_name;?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->

        <!-- /.search form -->
        <?php
        $item = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    //['label' => 'Menu Yii2', 'options' => ['class' => 'header']],

                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/']],
                      [
                        'label' => 'Settings',
                        'icon' => ' fa-life-buoy',
                        'url' => '#',
                        'visible'=>(Yii::$app->user->identity->role=='Superadmin'),
                        'items' => [
                            ['label' => 'Countries', 'icon' => ' fa-adjust', 'url' => ['/countries']],
                            ['label' => 'States', 'icon' => ' fa-adjust', 'url' => ['/states']],

                            ]
                        ],

                    ['label' => 'Sellers', 'icon' => ' fa-users', 'url' => ['/sellers'],'active'=>($item == 'sellers'),'visible'=>(Yii::$app->user->identity->role=='Superadmin'),
                    ],
                    ['label' => 'Buyers', 'icon' => ' fa-user', 'url' => ['/buyers'],'active'=>($item == 'buyers'),'visible'=>(Yii::$app->user->identity->role=='Superadmin'),
                    ],

                     ['label' => 'Categories', 'icon' => ' fa-cube', 'url' => ['/categories'],'visible'=>(Yii::$app->user->identity->role=='Superadmin'),
                     ],
                     ['label' => 'Metal Prices', 'icon' => ' fa-shield', 'url' => ['/metalsprices/create'],'active'=>($item == 'metalsprices'),'visible'=>(Yii::$app->user->identity->role=='Superadmin'),
                     ],
                    ['label' => 'Products', 'icon' => ' fa-cube', 'url' => ['/products'],'active'=>($item == 'products'),'visible'=>(Yii::$app->user->identity->role=='Superadmin'),
                    ],

//                    ['label' => 'Properties', 'icon' => ' fa-home', 'url' => ['/properties'],'active'=>($item == 'properties' || ($item=='images' && $action=='create'))],
//                    ['label' => 'Booking Requests', 'icon' => '  fa-database', 'url' => ['/bookingrequests'],'active'=>($item == 'bookingrequests')],
//                    ['label' => 'Renovation Quotes', 'icon' => ' fa-recycle', 'url' => ['/renovationquotes'],'active'=>($item == 'renovationquotes')],
//                    ['label' => 'Insurances', 'icon' => ' fa-shield', 'url' => ['/insurances'],'active'=>($item == 'insurances')],
//                    ['label' => 'Defect Reports', 'icon' => ' fa-bug', 'url' => ['/defectreports'],'active'=>($item == 'defectreports')],
//                    ['label' => 'Auto Rental Collection', 'icon' => '  fa-ticket', 'url' => ['/autorentalcollections'],'active'=>($item == 'autorentalcollections')],
//                    ['label' => 'General Invoices', 'icon' => '   fa-money', 'url' => ['/invoices'],'active'=>($item == 'invoices')],
//                    ['label' => 'Service Requests', 'icon' => '   fa-gear', 'url' => ['/servicerequests'],'active'=>($item == 'servicerequests')],
//                    ['label' => 'Promo Codes', 'icon' => '    fa-tags', 'url' => ['/promocodes'],'active'=>($item == 'promocodes')],
//                    ['label' => 'Gold Coins', 'icon' => '     fa-sun-o', 'url' => ['/goldcoins'],'active'=>($item == 'goldcoins')],



                ],
            ]
        ) ?>

    </section>

</aside>
