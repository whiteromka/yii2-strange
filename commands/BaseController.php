<?php

namespace app\commands;

use yii\console\Controller;

class BaseController extends Controller
{
    /** @var float */
    protected $actionTimeStart;

    /** @var float */
    protected $actionTimeEnd;

    /** @var int  */
    protected $successCount = 0;

    public function setSuccessCount(int $count): void
    {
        $this->successCount = $count;
    }

    public function beforeAction($action)
    {
        $this->successCount = 0;
        $this->actionTimeStart = time();
        return parent::beforeAction($action);
    }

    public function timeEnd(): void
    {
        $this->actionTimeEnd = time();
    }

    public function checkSave($resultSave): void
    {
        if ($resultSave) {
            $this->successCount = $this->successCount + 1;
        }
        echo $resultSave ? '.' : '-';
    }

    public function showActionInfo(bool $isShowSuccessCount = true, bool $isShowTime = true)
    {
        $this->timeEnd();
        if ($isShowSuccessCount) {
            echo PHP_EOL . 'Added - ' . $this->successCount;
        }
        if ($isShowTime) {
            //ToDo fix warning
            #echo PHP_EOL . 'Action time - ' . $this->actionTimeEnd - $this->actionTimeStart;
        }
    }
}