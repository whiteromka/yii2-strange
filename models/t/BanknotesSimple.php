<?php

namespace app\models\t;

/** Простой пример: есть все банкноты, всех ноиналов */
class BanknotesSimple
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
        $this->banknotes = [20, 50, 100];
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
}