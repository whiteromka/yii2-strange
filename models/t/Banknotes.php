<?php

namespace app\models\t;

/** Слодный пример: есть ограничения по номиналу банкнот */
class Banknotes
{
    /** @var int - Сумма которую нужно разбить на банкноты */
    private int $sum;

    /** @var int[] Банкноты разных номиналов */
    private array $banknotes = [];

    /** @var array - Массив банкнота который должен получить пользователь */
    private array $result = [];

    /** @var int - Остаток который нужно добрать банкнотами */
    private int $remain;

    public function __construct(int $sum)
    {
        $this->sum = $sum;
        $this->remain = $sum;
        $this->banknotes = [30, 50, 100, 500, 1000, 5000];
    }

    /**
     * @return array
     */
    public function calculate(): array
    {
        // Если вдруг можно вернуть 1-ой банкнотой
        if (in_array($this->sum, $this->banknotes)) {
            return [$this->sum];
        }

        $tens = $this->getTens($this->sum); // Получим десятки от искомой суммы
        if ($tens) {
            $this->tryCompleteTensRemain($tens);
        }
        if ($this->remain == 0) { // Если остаток по дибиваемой сумме = 0, то все уже получилось
            return $this->result;
        }
        if ($this->sum == $this->remain && $tens) { // Если добить десятки не получилось, то всю сумму добить не удасться
            return ['Sorry we cant'];
        }

        // Перебираем все банкноты от самой большой к наименьшей и пробуем добить остаток
        $banknotes = $this->getSortedBanknotes();
        foreach ($banknotes as $banknote) {
            if ($this->remain == 0) {
                break;
            }
            if ($banknote <= $this->remain) {
                $this->tryCompleteRemain($banknote);
            }
            if ($this->isMinimalBanknote($banknote) && $this->remain != 0) {
                return ['Sorry we cant'];
            }
        }
        return $this->result;
    }

    /**
     * Получить "десятки" от суммы. Напрмер если мумма = 1260 то десятки = 60
     *
     * @param int $sum
     * @return int
     */
    private function getTens(int $sum): int
    {
        $tens = 0;
        if (strlen($sum) >= 2) {
            $tens = substr($sum, -2);
        }
        return $tens;
    }

    /**
     * Эта функция пытается добить десятки
     *
     * @param int $tens - Десятки от изначальной суммы
     */
    private function tryCompleteTensRemain(int $tens)
    {
        // Начнем перебирать масив банкнот от большей к меньшей
        $banknotes = $this->getSmallestBanknotes(); // Тут банкноты номиналом менее 100
        $countBanknotes = count($banknotes);

        // Каждую будем умножать на [2,3,4,...] пока не найдем в числе совпадение по десяткам из $tens
        $nums = range(1, 9);
        for ($i = 0; $i < $countBanknotes; $i++) {
            $banknote = $banknotes[$i];
            foreach ($nums as $num) {
                // Сравниваем десятки от умноженой на себя банкноты с десятками от изначальной суммы
                $isTensCompleted = $this->checkQuasiBanknote($num, $banknote, $tens);
                if ($isTensCompleted) {
                    return;
                }
                // Десятки от умноженой на себя банкноты складываем со следующими банкнотами и сравниваем с десятками от изначальной суммы
                $isTensCompleted = $this->checkCombineBanknotes($i, $num, $banknote, $tens);
                if ($isTensCompleted) {
                    return;
                }
            }
        }
    }

    /**
     * Сравниваем десятки от умноженой на себя банкноты с десятками от изначальной суммы
     *
     * @param int $num
     * @param int $banknote
     * @param int $tens
     * @return bool
     */
    private function checkQuasiBanknote(int $num, int $banknote, int $tens): bool
    {
        $quasiBanknote = $num * $banknote;
        $quasiTensBanknote = substr($quasiBanknote, -2);
        if ($quasiTensBanknote == $tens) { // Тут сравниваем десятки от искомой суммы и десятки от итерируемой банкноты
            for ($i = 0; $i < $num; $i++) {
                $this->addBanknoteInResult($banknote);
            }
            return true;
        }
        return false;
    }

    /**
     * Десятки от умноженой на себя банкноты складываем со следующими банкнотами и сравниваем с десятками от изначальной суммы
     *
     * @param int $i
     * @param int $num
     * @param int $banknote
     * @param int $tens
     * @return bool
     */
    private function checkCombineBanknotes(int $i, int $num, int $banknote, int $tens): bool
    {
        $banknotes = $this->getSmallestBanknotes();
        if (isset($banknotes[1 + $i])) { // Если существует следующая банкнота  // ToDo тут нужно в цикле проверять все следующие
            $quasiBanknote = $num * $banknote;
            $nextBanknote = $banknotes[1 + $i];
            $quasiTensBanknote = $quasiBanknote + $nextBanknote;
            if ($quasiTensBanknote == $tens) {
                $this->addBanknoteInResult($nextBanknote);
                for ($i = 0; $i < $num; $i++) {
                    $this->addBanknoteInResult($banknote);
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Попытаться добить остаток банкнотами переданного номинала
     *
     * @param int $banknote
     */
    private function tryCompleteRemain(int $banknote)
    {
        $cycleCount = intdiv($this->remain, $banknote);
        for ($i = 0; $i < $cycleCount; $i++) {
            $this->addBanknoteInResult($banknote);
        }
    }

    /**
     * Проверит что банкнота является минимальной из всего набора
     *
     * @param int $banknote
     * @return bool
     */
    private function isMinimalBanknote(int $banknote): bool
    {
        return min($this->banknotes) == $banknote;
    }

    /**
     * Добавить банкноту в итоговый результат
     *
     * @param int $banknote
     */
    private function addBanknoteInResult(int $banknote)
    {
        $this->remain -= $banknote;
        $this->result[] = $banknote;
    }

    /**
     * Отсортирует банкноты от большей к меньшей
     *
     * @return int[]
     */
    private function getSortedBanknotes(): array
    {
        $banknotes = $this->banknotes;
        rsort($banknotes);
        return $banknotes;
    }

    /**
     * Получить банкноты которые меньше $sum
     *
     * @return array
     */
    private function getSmallestBanknotes(): array
    {
        $smallestBanknotes = [];
        $sortedBanknotes = $this->getSortedBanknotes();
        foreach ($sortedBanknotes as $banknote) {
            if ($banknote < 100) {
                $smallestBanknotes[] = $banknote;
            }
        }
        return $smallestBanknotes;
    }
}