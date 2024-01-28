<?php

namespace app\widgets\vue;

use Yii;
use yii\base\Widget;

class VueBaseWidget extends Widget
{
    /** @var array - Пропсы vue компонента */
    public array $props = [];

    /** @var string - Имя vue компонента. Например "hello-component" */
    public string $component;

    /** @var bool - Чистить директорию от временных файлов */
    protected bool $isCleanUpDir = true;

    public function run()
    {
        parent::run();
        if ($this->isCleanUpDir) {
            $this->cleanUpDir(); // Чистка от верменных файлов. Для DEV разработки
        }
    }

    /**
     * Вернет ID компонента
     *
     * @return string
     */
    public function getVueId(): string
    {
        return 'v-' . $this->getId();
    }

    /**
     * Создаст vue объект
     */
    public function registerJs(): void
    {
        $el = '#' . $this->getVueId();
        $this->view->registerJs("
            new window.Vue({
                el: '" . $el . "'
            });
        ");
    }

    /**
     * Очищает директорию с временными файлами vue js
     */
    protected function cleanUpDir(): void
    {
        $files = scandir(Yii::$app->basePath . '/web/vue/');
        foreach ($files as $fileName) {
            $isFound = strpos($fileName, '.js');
            if ($isFound === false) {
                $isFound = strpos($fileName, '.json');
            }
            if (
                $isFound !== false ||
                in_array($fileName, ['favicon.ico', 'index.html'])
            ) {
                unlink(Yii::$app->basePath . '/web/vue/' . $fileName);
            }
        }
    }
}
