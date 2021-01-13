<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Cronjobs;
use app\models\MetalsPrices;
use app\models\Products;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }


    public function actionUpdateprices()
    {
        date_default_timezone_set("Asia/Kuala_Lumpur");

        $fromdate = date('Y-m-d 00:00:00');
        $todate = date('Y-m-d H:i:s');

        $model = MetalsPrices::find()->where(['>=','DATE(created_at)', $fromdate])->andWhere(['<=','DATE(created_at)', $todate])->andWhere(['is', 'updated_at', new \yii\db\Expression('null')])->orderBy([
            'id' => SORT_DESC])->one();
        if(!empty($model)) {
            foreach (Products::find()->each(500) as $product) {
                $id = $product->id;
                $platinum_price = (float)$model->platinum_price;
                $palladium_price = (float)$model->palladium_price;
                $rhodium_price = (float)$model->rhodium_price;
                $usdollar = 14.50;
                $convertweight = 31.1028;
                $platinum_ppm = $product->platinum_ppt;
                $palladium_ppm = $product->palladium_ppt;
                $rhodium_ppm = $product->rhodium_ppt;
                $weight = $product->converter_ceramic_weight;
                $convertervalueusd = $weight * (($platinum_ppm * ($platinum_price / $convertweight)) + ($palladium_ppm * ($palladium_price / $convertweight)) + ($rhodium_ppm * ($rhodium_price / $convertweight))) / 1000;
                $product->converter_value = $convertervalueusd;
                $platinum = (($convertervalueusd - $usdollar) * 0.8) + 14.50;
                $gold = (($convertervalueusd - $usdollar) * 0.75) + 14.50;
                $green = (($convertervalueusd - $usdollar) * 0.7) + 14.50;

                $product->platinum_price = $platinum;
                $product->gold_price = $gold;
                $product->green_price = $green;
                $product->updated_at = date('Y-m-d H:i:s');
                $product->save(false);


            }
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save(false);

        }
        $cronjob = new Cronjobs();
        $cronjob->date = date('Y-m-d');
        $cronjob->type = 'updateprices';
        $cronjob->created_at = date('Y-m-d H:i:s');
        $cronjob->save(false);

    }

}
